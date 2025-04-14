<?php

use Azuriom\Plugin\CommunityTube\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/getall', [ApiController::class, 'getAll'])->name('getAll');
Route::get('/getids', [ApiController::class, 'getAllIds'])->name('getIds');
Route::get('/latest', [ApiController::class, 'getLatest'])->name('getLatest');
Route::get('/get', [ApiController::class, 'getVideo'])->name('get');