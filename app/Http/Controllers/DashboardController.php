<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $files = auth()->user()->files;

        return view('dashboard', compact('files'));
    }
}
