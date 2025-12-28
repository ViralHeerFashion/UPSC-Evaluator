<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    User
};

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = User::select('id', 'name', 'phone', 'email', 'unique_id')
                        ->where('institute_id', Auth::guard('institute')->id());

        if ($request->filled('search')) {
            $students = $students->whereAny(
                ['name', 'phone', 'email'],
                'like',
                '%'.$request->search.'%'
            );
        }

        $students = $students->orderByDesc('id')
                            ->paginate(50);

        return view('institute.student.index', compact(
            'students'
        ));
    }
}
