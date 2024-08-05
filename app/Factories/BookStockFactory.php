<?php

namespace App\Factories;

class BookStockFactory
{
    public static function make($campus, $book)
    {
        $data = [
            'campus_id' => $campus->id,
            'book_id' => $book->id,
            'stock' => 0
        ];

        return $data;
    }
}
