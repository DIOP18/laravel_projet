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
    Route::put('/updateLivre/{id}', [LivreController::class, 'update'])->name('updateLivre');
    Route::delete('/deleteLivre/{id}', [LivreController::class, 'destroy'])->name('deleteLivre');
    Route::patch('/archiveLivre/{id}', [LivreController::class, 'archive'])->name('archiveLivre');
    Route::patch('/unarchiveLivre/{id}', [LivreController::class, 'unarchive'])->name('unarchiveLivre');
    Route::get('/catalogue', [LivreController::class, 'catalogue'])->name('catalogue');
    Route::get('/showDetails/{id}', [LivreController::class, 'showDetails'])->name('showDetails');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//LES ROUTES DE TON APPLICATION

require __DIR__.'/auth.php';
