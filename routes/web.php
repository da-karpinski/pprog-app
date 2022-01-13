<?php

use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProcessorController;
use App\Http\Controllers\SystemController;
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

//Phones
Route::get('api/phone/export', [PhoneController::class, 'export']);
Route::get('api/phone', [PhoneController::class, 'list']);
Route::get('api/phone/{id}', [PhoneController::class, 'select']);
Route::post('api/phone', [PhoneController::class, 'add']);
Route::patch('api/phone', [PhoneController::class, 'update']);
Route::delete('api/phone', [PhoneController::class, 'delete']);

//Processors
Route::get('api/processor', [ProcessorController::class, 'list']);
Route::get('api/processor/{id}', [ProcessorController::class, 'select']);
Route::post('api/processor', [ProcessorController::class, 'add']);
Route::patch('api/processor', [ProcessorController::class, 'update']);
Route::delete('api/processor', [ProcessorController::class, 'delete']);

//Systems
Route::get('api/system', [SystemController::class, 'list']);
Route::get('api/system/{id}', [SystemController::class, 'select']);
Route::post('api/system', [SystemController::class, 'add']);
Route::patch('api/system', [SystemController::class, 'update']);
Route::delete('api/system', [SystemController::class, 'delete']);

//Manufacturers
Route::get('api/manufacturer', [ManufacturerController::class, 'list']);
Route::get('api/manufacturer/{id}', [ManufacturerController::class, 'select']);
Route::post('api/manufacturer', [ManufacturerController::class, 'add']);
Route::patch('api/manufacturer', [ManufacturerController::class, 'update']);
Route::delete('api/manufacturer', [ManufacturerController::class, 'delete']);
