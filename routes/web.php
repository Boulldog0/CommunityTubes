<?php

use Azuriom\Plugin\CommunityTube\Controllers\CommunityTubeHomeController;
use Azuriom\Plugin\CommunityTube\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/', [CommunityTubeHomeController::class, 'index'])->name('index');
Route::get('/submit', [CommunityTubeHomeController::class, 'submit'])->middleware('auth')->name('submit');
Route::post('/submit/send', [CommunityTubeHomeController::class, 'send'])->middleware('auth')->name('submit.send');
Route::get('/video/{id}', [CommunityTubeHomeController::class, 'video'])->name('video');
Route::post('/video/l/{id}', [LikeController::class, 'like'])->middleware('auth')->name('like');