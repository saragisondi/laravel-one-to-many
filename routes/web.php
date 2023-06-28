<?php

use App\Http\Controllers\Admin\DashbordController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[PageController::class,'index'])->name('home');


Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function(){
        Route::get('/', [DashbordController::class, 'index'])->name('home');
        Route::resource('projects', ProjectController::class);
        Route::get('orderBy/{direction}', [ProjectController::class, 'orderBy'])->name('orderBy');
        Route::resource('types', TypeController::class);
        Route::get('typeProject',[ProjectController::class, 'typeProject'])->name('typeProject');
    });




require __DIR__.'/auth.php';