<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\CityRequest;
use App\Http\Resources\CityResource;
use App\Interfaces\CityRepositoryInterface;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    private CityRepositoryInterface $cityRepositoryInterface;

    public function __construct(CityRepositoryInterface $cityRepositoryInterface)
    {
        $this->cityRepositoryInterface = $cityRepositoryInterface;
    }

    public function index()
    {
        $data = $this->cityRepositoryInterface->getAll();

        return ApiResponseHelper::sendResponse(CityResource::collection($data));
    }   

    public function store(CityRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $city = $this->cityRepositoryInterface->store($data);

            DB::commit();

            return ApiResponseHelper::sendResponse(new CityResource($city), 'City created successfully.', 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function show($id)
    {
        $city = $this->cityRepositoryInterface->getById($id);

        return ApiResponseHelper::sendResponse(new CityResource($city));
    }

    public function update(CityRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $this->cityRepositoryInterface->update($id, $data);

            DB::commit();

            return ApiResponseHelper::sendResponse(null, 'City updated successfully');
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->cityRepositoryInterface->delete($id);

            DB::commit();

            return ApiResponseHelper::sendResponse(null, '', 204);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }
}
