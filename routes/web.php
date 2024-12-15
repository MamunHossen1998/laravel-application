<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestWebController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/test',[TestWebController::class,'test']);
Route::get('/test/data',[TestWebController::class,'testData']);
Route::get('/test/data/details',[TestWebController::class,'testDataDetails']);
Route::get('/test/controller',[TestWebController::class,'testController']);

require __DIR__.'/auth.php';
