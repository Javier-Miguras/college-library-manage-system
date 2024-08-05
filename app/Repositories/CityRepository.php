<?php

namespace App\Repositories;

use App\Interfaces\CityRepositoryInterface;
use App\Models\City;

class CityRepository implements CityRepositoryInterface
{
    public function getAll()
    {
        return City::all();
    }

    public function getById($id)
    {
        return City::findOrFail($id);
    }

    public function store(array $data)
    {
        return City::create($data);
    }

    public function update($id, array $data)
    {
        City::find($id)->update($data);
    }

    public function delete ($id)
    {
        City::destroy($id);
    }
}
