<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\AcademicProgramRequest;
use App\Http\Resources\AcademicProgramResource;
use App\Interfaces\AcademicProgramRepositoryInterface;
use App\Models\AcademicProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicProgramController extends Controller
{
    private AcademicProgramRepositoryInterface $academicProgramRepositoryInterface;

    public function __construct(AcademicProgramRepositoryInterface $academicProgramRepositoryInterface)
    {
        $this->academicProgramRepositoryInterface = $academicProgramRepositoryInterface;
    }

    public function index()
    {
        $data = $this->academicProgramRepositoryInterface->getAll();

        return ApiResponseHelper::sendResponse(AcademicProgramResource::collection($data));
    }

    public function store(AcademicProgramRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {

            $academicProgram = $this->academicProgramRepositoryInterface->store($data);

            DB::commit();

            return ApiResponseHelper::sendResponse($academicProgram, 'Academic program created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function show($id)
    {
        $academicProgram = $this->academicProgramRepositoryInterface->getById($id);

        return ApiResponseHelper::sendResponse(new AcademicProgramResource($academicProgram));
    }

    public function update(AcademicProgramRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            
            $this->academicProgramRepositoryInterface->update($id, $data);

            DB::commit();

            return ApiResponseHelper::sendResponse(null, 'Academic program updated successfully');
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->academicProgramRepositoryInterface->delete($id);

            DB::commit();

            return ApiResponseHelper::sendResponse(null, '', 204);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }
}
