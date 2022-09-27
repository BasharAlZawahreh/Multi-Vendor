<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function _construct()
    {
        // $this->middleware(['auth'])->except(['index']);
        // $this->middleware(['auth'])->only(['index']);
    }

    public function index()
    {
        return view('dashboard.index');
    }
}
