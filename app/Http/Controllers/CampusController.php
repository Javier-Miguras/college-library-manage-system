<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampusRequest;
use App\Http\Resources\CampusCollection;
use App\Http\Resources\CampusResource;
use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index()
    {
        $campus = Campus::all();

        return response()->json([
            "campus" => new CampusCollection($campus)
        ]);
    }

    public function store(CampusRequest $request)
    {
        $campus = Campus::create($request->validated());

        return response()->json([
            "message" => "Campus created successfully",
            "campus" => new CampusResource($campus)
        ], 201);
    }

    public function show(Campus $campus)
    {
        return response()->json([
            "campus" => new CampusResource($campus)
        ]);
    }

    public function update(CampusRequest $request, Campus $campus)
    {
        $campus->update($request->validated());

        return response()->json([
            "message" => "Campus updated successfully",
            "campus" => new CampusResource($campus)
        ], 200);
    }

    public function destroy(Campus $campus)
    {
        $campus->delete();

        return response()->noContent();
    }
}
