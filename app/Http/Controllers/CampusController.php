<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\CampusRequest;
use App\Http\Resources\CampusResource;
use App\Interfaces\CampusRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CampusController extends Controller
{
    private CampusRepositoryInterface $campusRepositoryInterface;

    public function __construct(CampusRepositoryInterface $campusRepositoryInterface)
    {
        $this->campusRepositoryInterface = $campusRepositoryInterface;
    }

    public function index()
    {
        $data = $this->campusRepositoryInterface->getAll();

        return ApiResponseHelper::sendResponse(CampusResource::collection($data));
    }

    public function store(CampusRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $campus = $this->campusRepositoryInterface->store($data);
            DB::commit();

            return ApiResponseHelper::sendResponse(new CampusResource($campus), 'Campus created successfully.', 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function show($id)
    {
        $campus = $this->campusRepositoryInterface->getById($id);

        return ApiResponseHelper::sendResponse(new CampusResource($campus));
    }

    public function update($id, CampusRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $this->campusRepositoryInterface->update($id, $data);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, 'Campus updated successfully');
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->campusRepositoryInterface->delete($id);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, '', 204);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }
}
