<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Metode GET dapat digunakan untuk mendapatkan data. 
Metode POST dapat digunakan untuk membuat data baru.
Metode PUT adalah Metode POST, tetapi dapat digunakan untuk memperbarui data yang ada.  
Metode DELETE digunakan untuk menghapus data.
*/

Route::get('/', [TodoController::class, 'index'])->name('home');

Auth::routes();

Route::middleware('auth')->group(function () {
    //=== ini CRUD (Create, Read, Update, dan Delete)
    Route::post('/todos', [TodoController::class, 'store']);
    Route::put('/todos/{id}', [TodoController::class, 'update']);
    Route::put('/todos/complete/{id}', [TodoController::class, 'complete']);
    Route::delete('/todos/{id}', [TodoController::class, 'destroy']);
});
