<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Factories\BookIndexFactory;
use App\Factories\BookShowFactory;
use App\Factories\BookStockFactory;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\BookStockRepositoryInterface;
use App\Interfaces\CampusRepositoryInterface;
use App\Models\BookStock;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    private BookRepositoryInterface $bookRepositoryInterface;
    private CampusRepositoryInterface $campusRepositoryInterface;
    private BookStockRepositoryInterface $bookStockRepositoryInterface;

    public function __construct(
        BookRepositoryInterface $bookRepositoryInterface, 
        CampusRepositoryInterface $campusRepositoryInterface, 
        BookStockRepositoryInterface $bookStockRepositoryInterface
    )
    {
        $this->bookRepositoryInterface = $bookRepositoryInterface;
        $this->campusRepositoryInterface = $campusRepositoryInterface;
        $this->bookStockRepositoryInterface = $bookStockRepositoryInterface;
    }

    public function index()
    {
        $data = BookIndexFactory::make($this->bookRepositoryInterface->getAll());
       
        return ApiResponseHelper::sendResponse($data);
        
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();
        $campusList = $this->campusRepositoryInterface->getAll();

        DB::beginTransaction();

        try {
            $book = $this->bookRepositoryInterface->store($data);

            foreach($campusList as $campus){
                $bookStockData = BookStockFactory::make($campus, $book);
    
                $this->bookStockRepositoryInterface->store($bookStockData);
            }

            DB::commit();
            return ApiResponseHelper::sendResponse(new BookResource($book), 'Book created successfully.', 201);

        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }

    }

    public function show($id)
    {
        $book = $this->bookRepositoryInterface->getById($id);

        return ApiResponseHelper::sendResponse(BookShowFactory::make($book));
    }

    public function update(BookRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $this->bookRepositoryInterface->update($id, $data);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, 'Book updated successfully.');
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->bookRepositoryInterface->delete($id);
            DB::commit();

            return ApiResponseHelper::sendResponse(null, '', 204);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollback($e);
        }
    }
}
