<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('projects', 'projects')
    ->middleware(['auth']) // I'll handle role check inside the component if needed, or I could add a custom middleware.
    ->name('projects');

require __DIR__.'/auth.php';
