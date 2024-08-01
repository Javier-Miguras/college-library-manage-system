<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Resources\CityCollection;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();

        return response()->json([
            "cities" => new CityCollection($cities)
        ]);
    }

    public function store(CityRequest $request)
    {
        $city = City::create($request->validated());

        return response()->json([
            "message" => "City created successfully",
            "city" => new CityResource($city)
        ], 201);
    }

    public function show(City $city)
    {
        return response()->json([
            "city" => new CityResource($city)
        ]);
    }

    public function update(CityRequest $request, City $city)
    {
        $city->update($request->validated());

        return response()->json([
            "message" => "City updated successfully",
            "city" => new CityResource($city)
        ], 200);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->noContent();
    }
}
