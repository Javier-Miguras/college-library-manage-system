<?php

namespace App\Factories;

use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;

class BookShowFactory
{
    public static function make($book)
    {
        if(Auth::user()->role != 2){
            $stock = $book->stock->where('campus_id', Auth::user()->campus->id)->first()->stock;
            $book->stock = $stock;
        }

        return new BookResource($book);
    }
}
