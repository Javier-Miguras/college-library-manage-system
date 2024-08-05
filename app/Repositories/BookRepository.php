<?php

namespace App\Repositories;

use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;

class BookRepository implements BookRepositoryInterface
{
    public function getAll()
    {
        return Book::all();
    }

    public function getById($id)
    {
        return Book::findOrFail($id);
    }

    public function store(array $data)
    {
        return Book::create($data);
    }

    public function update($id, array $data)
    {
        Book::find($id)->update($data);
    }

    public function delete($id)
    {
        Book::destroy($id);
    }
}
