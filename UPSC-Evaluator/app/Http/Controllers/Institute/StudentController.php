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
                        ->withCount('answer_sheet')
                        ->where('institute_id', Auth::guard('institute')->id());

        if ($request->filled('search')) {
            $students = $students->whereAny(
                ['name', 'phone', 'email', 'unique_id'],
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

    public function loginStudentAccount(int $user_id, Request $request)
    {
        $student = User::findOrFail($user_id);
        if (is_null($student->institute_id) || $student->institute_id != Auth::guard('institute')->id()) {
            abort(404);
        }
        $request->session()->put('is_institute_temporary_login', true);
        
        Auth::guard('web')->logout();
        Auth::guard('web')->login($student);
        $request->session()->regenerateToken();

        return redirect()->route('student.mains-evaluation.list');
    }
}
