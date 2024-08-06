<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\TownRequest;
use App\Http\Resources\TownCollection;
use App\Http\Resources\TownResource;
use App\Interfaces\TownRepositoryInterface;
use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TownController extends Controller
{
    private TownRepositoryInterface $townRepositoryInterface;

    public function __construct(TownRepositoryInterface $townRepositoryInterface)
    {
        $this->townRepositoryInterface = $townRepositoryInterface;
    }

    public function index()
    {
        $data = $this->townRepositoryInterface->getAll();

        return ApiResponseHelper::sendResponse(TownResource::collection($data));
    }

    public function store(TownRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $town = $this->townRepositoryInterface->store($data);
            DB::commit();

            return ApiResponseHelper::sendResponse(new TownResource($town), 'Town created successfully.', 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function show($id)
    {
        $town = $this->townRepositoryInterface->getById($id);

        return ApiResponseHelper::sendResponse(new TownResource($town));
    }

    public function update($id, TownRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $this->townRepositoryInterface->update($id, $data);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, 'Town updated successfully');
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->townRepositoryInterface->delete($id);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, '', 204);
        } catch (\Exception $e) {
            DB::rollBack($e);
        }
    }
}
