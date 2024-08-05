<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Interfaces\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    private AuthorRepositoryInterface $authorRepositoryInterface;

    public function __construct(AuthorRepositoryInterface $authorRepositoryInterface)
    {
        $this->authorRepositoryInterface = $authorRepositoryInterface;
    }

    public function index()
    {
        $data = $this->authorRepositoryInterface->getAll();

        return ApiResponseHelper::sendResponse(AuthorResource::collection($data));
    }

    public function store(AuthorRequest $request)
    {   
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $author = $this->authorRepositoryInterface->store($data);

            DB::commit();

            return ApiResponseHelper::sendResponse(new AuthorResource($author), 'Author created successfully.', 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
        
    }

    public function show($id)
    {
        $author = $this->authorRepositoryInterface->getById($id);

        return ApiResponseHelper::sendResponse(new AuthorResource($author));
    }

    public function update(AuthorRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $this->authorRepositoryInterface->update($id, $data);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, 'Author updated successfully.');
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->authorRepositoryInterface->delete($id);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, '', 204);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }
}
