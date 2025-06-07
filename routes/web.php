<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/documents/{document}', [HomeController::class, 'show'])->name('documents.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Document download routes
    Route::prefix('documents')->name('document.')->group(function () {
        Route::get('{document}/download/{index}', [DocumentController::class, 'downloadSingle'])
            ->name('download.single');
        Route::get('{document}/download-all', [DocumentController::class, 'downloadAll'])
            ->name('download.all');
        Route::get('{document}/download', [DocumentController::class, 'download'])
            ->name('download');
    });
});

require __DIR__.'/auth.php';
