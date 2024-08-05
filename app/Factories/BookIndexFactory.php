<?php

namespace App\Factories;

use App\Http\Resources\BookAdminResource;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookIndexFactory
{
    public static function make($books)
    {
        if(Auth::user()->role == 2){
            return BookAdminResource::collection($books);
        }

        $campus = Auth::user()->campus;
        $booksStock = $campus->booksStock()->get()->keyBy('book_id');

        $booksWithStock = $books->map(function ($book) use ($booksStock) {
            // Encuentra el stock correspondiente al libro
            $bookStock = $booksStock->get($book->id);
            // Asigna el stock al libro
            $book->stock = $bookStock ? $bookStock->stock : 0;
            return $book;
        });

        return BookResource::collection($booksWithStock);
    }
}
