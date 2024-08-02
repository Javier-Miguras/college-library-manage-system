<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelReservationRequest;
use App\Http\Requests\FinishReservationRequest;
use App\Http\Requests\PickUpReservationRequest;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Resources\ReservationAdminCollection;
use App\Http\Resources\ReservationAdminResource;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationEmployeeCollection;
use App\Http\Resources\ReservationEmployeeResource;
use App\Http\Resources\ReservationResource;
use App\Models\Book;
use App\Models\BookStock;
use App\Models\Campus;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\ReservationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 2){
            $reservations = Reservation::with(['user', 'campus.town', 'book'])->get();

            return response()->json([
                "reservations" => new ReservationAdminCollection($reservations)
            ]);
        }elseif(Auth::user()->role == 1){
            $reservations = Reservation::where('campus_id', Auth::user()->campus->id)->with(['user', 'book'])->get();

            return response()->json([
                "reservations" => new ReservationEmployeeCollection($reservations)
            ]);
        }else{
            $reservations = Reservation::where('user_id', Auth::user()->id)->with(['book'])->get();

            return response()->json([
                "reservations" => new ReservationCollection($reservations)
            ]);
        }
        
    }

    public function store(ReservationStoreRequest $request)
    {   
        $data = $request->validated();

        $user = User::find(Auth::user()->id);

        if($user->role == 2){
            $campus_id = $data['campus_id'];
        }else{
            $campus_id = $user->campus->id;
        }

    
        $bookStock = BookStock::where('campus_id', $campus_id)->where('book_id', $data['book_id'])->first();

        if($bookStock->stock <= 0){
            return response()->json(["error" => "Insufficient stock"], 400);
        }

        $now = Carbon::now();

        DB::beginTransaction();
        try {
            $reservation = Reservation::create([
                'expiration_date' => $now->addWeeks(2),
                'user_id' => $user->id,
                'campus_id' => $campus_id,
                'book_id' => $data['book_id'],
                'status' => 'Created'
            ]);

            $bookStock->stock--;
            $bookStock->save();

            DB::commit();

            $user->notify(new ReservationNotification($reservation));

            return response()->json([
                "message" => "Reservation created successfully",
                "reservation" => new ReservationResource($reservation)
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Failed to create reservation"], 500);
        }

    }

    public function show(Reservation $reservation)
    {
        if(Auth::user()->role == 2){

            return response()->json([
                "reservation" => new ReservationAdminResource($reservation)
            ]);
        }elseif(Auth::user()->role == 1){

            if(Auth::user()->campus->id != $reservation->campus_id){

                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'You do not have permission to access this resource.'
                ], 403);
            }else{

                return response()->json([
                    "reservation" => new ReservationEmployeeResource($reservation)
                ]);
            }
        }else{
            if(Auth::user()->id != $reservation->user_id){

                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'You do not have permission to access this resource.'
                ], 403);
            }else{
                return response()->json([
                    "reservation" => new ReservationResource($reservation)
                ]);
            }
        }
    }

    public function pickUpReservation(PickUpReservationRequest $request, Reservation $reservation)
    {
        $data = $request->validated();
        $user = $reservation->user;

        if(!$reservation){
            return response()->json([
                'error' => 'Reservation not found',
            ], 404);
        }

        if($reservation->status != 'Created'){
            return response()->json([
                'error' => 'Invalid Reservation Status',
                'message' => 'The reservation status must be "Created" to pick it up.'
            ], 400);
        }

        $reservation->status = $data['status'];
        $reservation->save();

        $user->notify(new ReservationNotification($reservation));

        return response()->json([
            'message' => 'Reservation picked up successfully',
            'reservation' => $reservation
        ], 200);
    }

    public function cancelReservation(CancelReservationRequest $request, Reservation $reservation)
    {
        $data = $request->validated();
        $user = $reservation->user;

        if(!$reservation){
            return response()->json([
                'error' => 'Reservation not found',
            ], 404);
        }

        if($reservation->status != 'Created'){
            return response()->json([
                'error' => 'Invalid Reservation Status',
                'message' => 'The reservation status must be "Created" to cancel it.'
            ], 400);
        }

        if(Auth::user()->role == 1 && Auth::user()->campus->id != $reservation->campus_id ){
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }

        if(Auth::user()->role == 0 && Auth::user()->id != $reservation->user_id){
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }

        $bookStock = BookStock::where('campus_id', $reservation->campus_id)->where('book_id', $reservation->book_id)->first();

        DB::beginTransaction();
        
        try {
            $reservation->status = $data['status'];
            $bookStock->stock++;
            $bookStock->save();
            $reservation->save();

            DB::commit();

            $user->notify(new ReservationNotification($reservation));

            return response()->json([
                'message' => 'Reservation cancelled successfully',
                'reservation' => $reservation
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Failed to cancel reservation"], 500);
        }
        

    }

    public function finishReservation(FinishReservationRequest $request, Reservation $reservation)
    {
        $data = $request->validated();
        $user = $reservation->user;

        if(!$reservation){
            return response()->json([
                'error' => 'Reservation not found',
            ], 404);
        }

        if($reservation->status != 'Picked up'){
            return response()->json([
                'error' => 'Invalid Reservation Status',
                'message' => 'The reservation status must be "Picked up" to finish it.'
            ], 400);
        }

        if(Auth::user()->role == 1 && Auth::user()->campus->id != $reservation->campus_id ){
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }

        $bookStock = BookStock::where('campus_id', $reservation->campus_id)->where('book_id', $reservation->book_id)->first();

        DB::beginTransaction();

        try {
            $reservation->status = $data['status'];
            $bookStock->stock++;
            $bookStock->save();
            $reservation->save();

            DB::commit();

            $user->notify(new ReservationNotification($reservation));

            return response()->json([
                'message' => 'Reservation finished successfully',
                'reservation' => $reservation
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Failed to finish reservation"], 500);
        }
    }
}
