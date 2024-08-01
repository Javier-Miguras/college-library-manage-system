<?php

use App\Http\Controllers\AcademicProgramController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookStockController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CampusProgramController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\UserController;
use App\Models\CampusProgram;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    //Test
    Route::get('/test', [TestController::class, 'index']);

    //User
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);

    //Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    //Book
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{book}', [BookController::class, 'show']);

    //Reservation
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancelReservation']);

    //Author
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::get('/authors/{author}', [AuthorController::class, 'show']);

    //Category
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    //AcademicProgram
    Route::get('/academic-programs', [AcademicProgramController::class, 'index']);
    Route::get('/academic-programs/{academicProgram}', [AcademicProgramController::class, 'show']);

    //City
    Route::get('/cities', [CityController::class, 'index']);
    Route::get('/cities/{city}', [CityController::class, 'show']);

    //Town
    Route::get('/towns', [TownController::class, 'index']);
    Route::get('/towns/{town}', [TownController::class, 'show']);

    //Campus
    Route::get('/campus', [CampusController::class, 'index']);
    Route::get('/campus/{campus}', [CampusController::class, 'show']);

    //CampusProgram
    Route::get('/campus-programs', [CampusProgramController::class, 'index']);
    Route::get('/campus-programs/{campusProgram}', [CampusProgramController::class, 'show']);

});

Route::middleware(['auth:sanctum', 'isAdminOrEmployee'])->group(function () {

    //User
    Route::get('/users', [UserController::class, 'index']);

    //Reservation
    Route::post('/reservations/{reservation}/pickup', [ReservationController::class, 'pickUpReservation']);
    Route::post('/reservations/{reservation}/finish', [ReservationController::class, 'finishReservation']);

    //BookStock
    Route::put('/books-stock/{bookStock}', [BookStockController::class, 'update']);
});

Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {

    //User
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    
    //Book
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);

    //Author
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

    //Category
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    //AcademicProgram
    Route::post('/academic-programs', [AcademicProgramController::class, 'store']);
    Route::put('/academic-programs/{academicProgram}', [AcademicProgramController::class, 'update']);
    Route::delete('/academic-programs/{academicProgram}', [AcademicProgramController::class, 'destroy']);

    //City
    Route::post('/cities', [CityController::class, 'store']);
    Route::put('/cities/{city}', [CityController::class, 'update']);
    Route::delete('/cities/{city}', [CityController::class, 'destroy']);

    //Campus
    Route::post('/campus', [CampusController::class, 'store']);
    Route::put('/campus/{campus}', [CampusController::class, 'update']);
    Route::delete('campus/{campus}', [CampusController::class, 'destroy']);

    //Town
    Route::post('/towns', [TownController::class, 'store']);
    Route::put('/towns/{town}', [TownController::class, 'update']);
    Route::delete('/towns/{town}', [TownController::class, 'destroy']);

    //CampusProgram
    Route::post('/campus-programs', [CampusProgramController::class, 'store']);
    Route::put('/campus-programs/{campusProgram}', [CampusProgramController::class, 'update']);
    Route::delete('/campus-programs/{campusProgram}', [CampusProgramController::class, 'destroy']);
});

//Auth
Route::post('/login', [AuthController::class, 'login']);


