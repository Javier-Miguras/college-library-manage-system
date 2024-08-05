<?php

namespace App\Repositories;

use App\Interfaces\CampusRepositoryInterface;
use App\Models\Campus;

class CampusRepository implements CampusRepositoryInterface
{
    public function getAll()
    {
        return Campus::all();
    }

    public function getById($id)
    {
        return Campus::findOrFail($id);
    }

    public function store(array $data)
    {
        return Campus::create($data);
    }

    public function update($id, array $data)
    {
        Campus::find($id)->update($data);
    }

    public function delete($id)
    {
        Campus::destroy($id);
    }
}
