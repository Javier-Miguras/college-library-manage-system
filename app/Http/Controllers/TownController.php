<?php

namespace App\Http\Controllers;

use App\Http\Requests\TownRequest;
use App\Http\Resources\TownCollection;
use App\Http\Resources\TownResource;
use App\Models\Town;
use Illuminate\Http\Request;

class TownController extends Controller
{
    public function index()
    {
        $towns = Town::all();

        return response()->json([
            "towns" => new TownCollection($towns)
        ]);
    }

    public function store(TownRequest $request)
    {
        $town = Town::create($request->validated());

        return response()->json([
            "message" => "Town created successfully",
            "town" => new TownResource($town)
        ], 201);
    }

    public function show(Town $town)
    {
        return response()->json([
            "town" => new TownResource($town)
        ]);
    }

    public function update(TownRequest $request, Town $town)
    {
        $town->update($request->validated());

        return response()->json([
            "message" => "Town updated successfully",
            "town" => new TownResource($town)
        ], 200);
    }

    public function destroy(Town $town)
    {
        $town->delete();

        return response()->noContent();
    }
}
