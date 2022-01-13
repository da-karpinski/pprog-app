<?php

use App\Http\Controllers\ProcessorController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//Processors
Route::get('api/processor', [ProcessorController::class, 'list']);
Route::get('api/processor/{id}', [ProcessorController::class, 'select']);
Route::post('api/processor', [ProcessorController::class, 'add']);
Route::patch('api/processor/{id}', [ProcessorController::class, 'update']);
Route::delete('api/processor', [ProcessorController::class, 'delete']);
