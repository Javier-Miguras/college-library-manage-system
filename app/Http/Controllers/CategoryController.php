<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepositoryInterface;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {   
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }

    public function index()
    {
        $data = $this->categoryRepositoryInterface->getAll();

        return ApiResponseHelper::sendResponse(CategoryResource::collection($data));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $category = $this->categoryRepositoryInterface->store($data);
            DB::commit();

            return ApiResponseHelper::sendResponse(new CategoryResource($category), 'Category created successfully.', 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }

    }

    public function show($id)
    {
        $category = $this->categoryRepositoryInterface->getById($id);

        return ApiResponseHelper::sendResponse(new CategoryResource($category));
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $this->categoryRepositoryInterface->update($id, $data);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, 'Category updated successfully.');
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }

    }

    public function destroy($id)
    {
        try {
            $this->categoryRepositoryInterface->delete($id);

            return ApiResponseHelper::sendResponse(null, '', 204);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
        
    }
}
