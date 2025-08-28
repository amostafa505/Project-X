<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Branch;

class DashboardController extends Controller
{
    public function index()
    {
        $schoolsCount  = School::count();
        $branchesCount = Branch::count();

        return view('dashboard', compact('schoolsCount','branchesCount'));
    }
}
