<?php

use App\Http\Controllers\LivreController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //LES ROUTES DE TON APPLICATION
    Route::get('/livre', [LivreController::class, 'index']);
        Route::get('/ajoutLivre', [LivreController::class, 'create'])->name('ajoutLivre');
    Route::post('/saveLivre', [LivreController::class, 'store'])->name('saveLivre');
    Route::get('/editLivre/{id}', [LivreController::class, 'edit'])->name('editLivre');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//LES ROUTES DE TON APPLICATION

require __DIR__.'/auth.php';
