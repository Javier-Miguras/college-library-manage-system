<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookAdminCollection;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\BookStock;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        if(Auth::user()->role == 2){
            return response()->json([
                "books" => new BookAdminCollection($books)
            ]);
        }

        $campus = Auth::user()->campus;
        $booksStock = $campus->booksStock()->get()->keyBy('book_id');

        // Asocia el stock a cada libro
        $booksWithStock = $books->map(function ($book) use ($booksStock) {
            // Encuentra el stock correspondiente al libro
            $bookStock = $booksStock->get($book->id);
            // Asigna el stock al libro
            $book->stock = $bookStock ? $bookStock->stock : 0;
            return $book;
        });

        return response()->json([
            "books" => new BookCollection($booksWithStock) 
        ]);
        
    }

    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());
        $campusList = Campus::all();

        foreach($campusList as $campus){
            $bookStock = new BookStock;

            $bookStock->stock = 0;
            $bookStock->campus_id = $campus->id;
            $bookStock->book_id = $book->id;

            $bookStock->save();
        }
        
        return response()->json([
            "message" => "Book created successfully",
            "book" => new BookResource($book)
        ], 201);
    }

    public function show(Book $book)
    {
        if(Auth::user()->role == 2){
            return response()->json([
                "book" => new BookResource($book)
            ]);
        }else{
            $stock = $book->stock->where('campus_id', Auth::user()->campus->id)->first()->stock;
            $book->stock = $stock;
            return response()->json([
                "book" => new BookResource($book)
            ]);
        }
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return response()->json([
            "message" => "Book updated successfully",
            "book" => new BookResource($book)
        ], 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();  //return 204
    }
}
