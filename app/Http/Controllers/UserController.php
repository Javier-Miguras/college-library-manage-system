<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserShowCollection;
use App\Http\Resources\UserShowResource;
use App\Models\AcademicProgram;
use App\Models\Campus;
use App\Models\StudentProgram;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 2){

            $users = User::all();

            return response()->json([
                'users' => new UserShowCollection($users)
            ]);
        }
        
        $users = User::all();
        $authCampusId = Auth::user()->campus->id;

        $filteredUsers = $users->filter(function ($user) use ($authCampusId) {
            return $user->campus->id === $authCampusId;
        });

        return response()->json([
            'users' => new UserShowCollection($filteredUsers)
        ]);
        
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        
        try {

            $user = User::create([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => $data['role'],
            ]);

            if($user->role != 2){

                $studentProgram = new StudentProgram;
                $now = Carbon::now();
                $studentProgram->student_id = $user->id;
                $studentProgram->campus_id = $data['campus_id'];
                $studentProgram->matriculation_date = $now;

                if($user->role == 0){

                    $studentProgram->program_id = $data['program_id'];
                }

                $studentProgram->save();
            }

            DB::commit();

            return response()->json([
                "message" => "User created successfully",
                "user" => new UserResource($user)
            ], 201);


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "error" => "Failed to create user",
                "details" => $e->getMessage()
            ], 500);
        }

    }

    public function show(User $user)
    {
        if(Auth::user()->role == 0 && Auth::user()->id != $user->id){
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }

        if(Auth::user()->role == 1 && Auth::user()->campus->id != $user->campus->id){
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }

        return response()->json([
            "user" => new UserShowResource($user)
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        if((Auth::user()->role == 0 || Auth::user()->role == 1) && Auth::user()->id != $user->id){
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }

        $data = $request->validated();

        DB::beginTransaction();

        try {
            if(Auth::user()->role == 0 || Auth::user()->role == 1){

                $updateData = [
                    'name' => $user->name,
                    'lastname' => $user->lastname,
                    'email' => $data['email'],
                    'role' => $user->role
                ];
    
            }else{
    
                if($user->role == 0 || $user->role == 1){
                    $studentProgram = StudentProgram::where('student_id', $user->id)->firstOrFail();
                    $studentProgram->campus_id = $data['campus_id'];
    
                    if($user->role == 0){
                        $studentProgram->program_id = $data['program_id'];
                    }
    
                    $studentProgram->save();
                }
                
                $updateData = [
                    'name' => $data['name'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'role' => $user->role
                ];
            }
    
            if (!empty($data['password'])) {
                $updateData['password'] = bcrypt($data['password']);
            }
    
            $user->update($updateData);
    
            DB::commit();
    
            
            return response()->json([
                "message" => "User updated successfully",
                "user" => new UserShowResource($user)
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update user',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
