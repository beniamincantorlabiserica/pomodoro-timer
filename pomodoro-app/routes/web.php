<?php

use App\Http\Controllers\PomodoroController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PomodoroController::class, 'index'])->name('pomodoro.index');
