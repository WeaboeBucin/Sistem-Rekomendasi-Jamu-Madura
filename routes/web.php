<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JamuController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/', [UserController::class, 'showForm'])->name('auth.login');
Route::get('/', [JamuController::class, 'showForm'])->name('rekomendasi.form');
Route::get('/detail-jamu/{id}', [JamuController::class, 'detailJamu'])->name('jamu.detail');
Route::post('/rekomendasi-jamu', [JamuController::class, 'rekomendasiJamu'])->name('rekomendasi.process');
