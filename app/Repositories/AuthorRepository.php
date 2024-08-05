<?php

namespace App\Repositories;

use App\Interfaces\AuthorRepositoryInterface;
use App\Models\Author;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function getAll()
    {
        return Author::all();
    }

    public function getById($id)
    {
        return Author::findOrFail($id);
    }

    public function store(array $data)
    {
        return Author::create($data);
    }

    public function update($id, array $data)
    {
        return Author::find($id)->update($data);
    }

    public function delete($id)
    {
        Author::destroy($id);
    }
}
