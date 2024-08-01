<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampusProgramRequest;
use App\Http\Resources\CampusProgramCollection;
use App\Http\Resources\CampusProgramResource;
use App\Models\CampusProgram;
use Illuminate\Http\Request;

class CampusProgramController extends Controller
{
    public function index()
    {
        $campusPrograms = CampusProgram::all();

        return response()->json([
            "campus-programs" => new CampusProgramCollection($campusPrograms)
        ]);
    }

    public function store(CampusProgramRequest $request)
    {
        $campusProgram = CampusProgram::create($request->validated());

        return response()->json([
            "message" => "Campus program created successfully",
            "campus-program" => new CampusProgramResource($campusProgram)
        ]);
    }

    public function show(CampusProgram $campusProgram)
    {
        return response()->json([
            "campus-program" => new CampusProgramResource($campusProgram)
        ]);
    }

    public function update(CampusProgramRequest $request, CampusProgram $campusProgram)
    {
        $campusProgram->update($request->validated());

        return response()->json([
            "message" => "Campus program updated successfully",
            "campus-program" => new CampusProgramResource($campusProgram)
        ],200);
    }

    public function destroy(CampusProgram $campusProgram)
    {
        $campusProgram->delete();

        return response()->noContent();
    }
}
