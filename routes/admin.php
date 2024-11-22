<?php

use Azuriom\Plugin\CommunityTube\Controllers\Admin\AdminController;
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

Route::get('/settings', [AdminController::class, 'index'])->middleware('auth')->name('index');
Route::get('/verif', [AdminController::class, 'verif'])->middleware('auth')->name('verif');
Route::post('/verif/accept/{id}', [AdminController::class, 'accept'])->middleware('auth')->name('verif.accept');
Route::post('delete/{id}', [AdminController::class, 'delete'])->middleware('auth')->name('delete');
Route::get('/edit/{id}', [AdminController::class, 'edit'])->middleware('auth')->name('edit');
Route::post('/edit/{id}/submit', [AdminController::class, 'edit_submit'])->middleware('auth')->name('edit.save');