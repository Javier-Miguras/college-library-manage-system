<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStockRequest;
use App\Http\Resources\BookStockResource;
use App\Models\BookStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookStockController extends Controller
{
    public function update(BookStockRequest $request, BookStock $bookStock)
    {
        if(Auth::user()->role == 1 && Auth::user()->campus->id != $bookStock->campus_id)
        {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }

        $data = $request->validated();

        $bookStock->stock = $data['stock'];
        $bookStock->save();

        return response()->json([
            "message" => "Book stock updated successfully",
            "book stock" => new BookStockResource($bookStock)
        ]);
    }
}
