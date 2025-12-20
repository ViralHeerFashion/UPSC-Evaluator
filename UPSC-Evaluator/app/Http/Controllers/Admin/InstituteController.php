<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\Admin\{
    UserImport
};
use App\Models\{
    Institute
};

class InstituteController extends Controller
{
    public function index(Request $request)
    {
        $institutes = Institute::select('id', 'name', 'phone', 'email', 'logo', 'created_at', 'uuid');

        $institutes = $institutes->orderByDesc('id')
                                ->paginate(100);

        return view('admin.institute.index', compact(
            'institutes'
        ));
    }

    public function add(string $uuid = null)
    {
        $institue = null;
        if (!is_null($uuid)) {
            $institue = Institute::where('uuid', $uuid)->first();
            if (is_null($institue)) {
                abort(404);
            }
        }
        return view('admin.institute.add', compact(
            'institue'
        ));
    }

    public function create(Request $request)
    {
        if ($request->filled('id')) {
            $institue = Institute::findOrFail($request->id);
        } else {
            $institue = new Institute;
        }
        $institue->name = $request->name;
        $institue->phone = $request->phone;
        $institue->email = $request->email;
        if (
            ($request->filled('id') && $request->filled('password')) 
            || !$request->filled('id')
        ) {
            $institue->password = Hash::make($request->password);
        }
        $institue->logo = $request->logo;
        $institue->save();

        return redirect()->route('admin.institute')->with('alert_success', 'Action Performed successfully...');
    }

    public function uploadLogo(Request $request)
    {
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('institute_logo', 'public');

            return response()->json([
                'path' => $path,
                'preview_path' => Storage::disk('public')->url($path)
            ]);
        }
    }

    public function deleteLogo(Request $request)
    {
        if ($request->filled('url') && Storage::disk('public')->exists($request->url)) {
            Storage::disk('public')->delete($request->url);
        }
        return response()->json(true);
    }

    public function studentSheet(string $uuid)
    {
        $institue = Institute::select('id')
                            ->where('uuid', $uuid)
                            ->first();

        if (is_null($institue)) {
            abort(404);
        }
        return view('admin.institute.student-sheet', compact(
            'institue'
        ));
    }

    public function uploadSheet(int $institute_id, Request $request)
    {
        if ($request->hasFile('student_sheet')) {
            try {
                Excel::import(
                    new UserImport($request->institute_id, $request->file('student_sheet')->getClientOriginalName()),
                    $request->file('student_sheet')
                );

                return back()->with('success', 'Excel imported successfully');

            } catch (ValidationException $e) {
                $errors = [];
                foreach ($e->failures() as $failure) {
                    $errors[$failure->row()][$failure->attribute()] = $failure->errors();
                }

                return back()->withErrors(json_encode($errors));
            
            } catch (\Throwable $e) {
                dd($e->getMessage());
                return back()->withErrors(['error' => $e->getMessage()]);
            }
        }
    }
}
