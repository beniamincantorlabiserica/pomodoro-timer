<?php

namespace App\Http\Controllers;

class PomodoroController extends Controller
{
    public function index()
    {
        return view('pomodoro.index');
    }
}
