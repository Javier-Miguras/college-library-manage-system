<?php

namespace App\Repositories;

use App\Interfaces\BookStockRepositoryInterface;
use App\Models\BookStock;

class BookStockRepository implements BookStockRepositoryInterface
{
    public function getAll()
    {
        return BookStock::all();
    }

    public function getById($id)
    {
        return BookStock::findOrFail($id);
    }

    public function store(array $data)
    {
        return BookStock::create($data);
    }

    public function update($id, array $data)
    {
        BookStock::find($id)->update($data);
    }

    public function delete ($id)
    {
        BookStock::destroy($id);
    }
}
