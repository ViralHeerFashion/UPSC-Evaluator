<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    ScreeningQuestion
};

class DashboardController extends Controller
{
    /**
     * https://aiwave.pixcelsthemes.com/
     */
    public function index()
    {
        return view('student.dashboard.index');
    }
}
