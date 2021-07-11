<?php

use App\Http\Controllers\DashboardController;
use App\Http\Livewire\PatronManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', HomeController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/patrons', PatronManager::class)->name('patrons');
});

require __DIR__.'/auth.php';
