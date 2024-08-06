<?php

namespace App\Repositories;

use App\Interfaces\TownRepositoryInterface;
use App\Models\Town;

class TownRepository implements TownRepositoryInterface
{
    public function getAll()
    {
        return Town::all();
    }

    public function getById($id)
    {
        return Town::findOrFail($id);
    }

    public function store(array $data)
    {
        return Town::create($data);
    }

    public function update($id, array $data)
    {
        Town::find($id)->update($data);
    }

    public function delete($id)
    {
        Town::destroy($id);
    }
}
