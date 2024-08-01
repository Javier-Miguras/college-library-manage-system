<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicProgramRequest;
use App\Http\Resources\AcademicProgramCollection;
use App\Http\Resources\AcademicProgramResource;
use App\Models\AcademicProgram;
use Illuminate\Http\Request;

class AcademicProgramController extends Controller
{
    public function index()
    {
        $academicPrograms = AcademicProgram::all();

        return response()->json([
            "academic programs" => new AcademicProgramCollection($academicPrograms)
        ]);
    }

    public function store(AcademicProgramRequest $request)
    {
        $academicProgram = AcademicProgram::create($request->validated());

        return response()->json([
            "message" => "Academic program created successfully",
            "academic program" => new AcademicProgramResource($academicProgram)
        ], 201);
    }

    public function show(AcademicProgram $academicProgram)
    {
        return response()->json([
            "academic program" => new AcademicProgramResource($academicProgram)
        ]);
    }

    public function update(AcademicProgramRequest $request, AcademicProgram $academicProgram)
    {
        $academicProgram->update($request->validated());

        return response()->json([
            "message" => "Academic program updated successfully",
            "academic program" => new AcademicProgramResource($academicProgram)
        ]);
    }

    public function destroy(AcademicProgram $academicProgram)
    {
        $academicProgram->delete();

        return response()->noContent();
    }
}
