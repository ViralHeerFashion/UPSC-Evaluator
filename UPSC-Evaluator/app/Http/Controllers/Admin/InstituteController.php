<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Imports\Admin\{
    UserImport
};
use App\Models\{
    Institute,
    StudentSheet,
    Recharge,
    Wallet,
    User
};

class InstituteController extends Controller
{
    public function index(Request $request)
    {
        $institutes = Institute::select('id', 'name', 'phone', 'email', 'logo', 'created_at', 'uuid', 'institute_api_name');

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
        $institue->institute_api_name = $request->institute_api_name;
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
        $institue = Institute::select('id', 'uuid')
                            ->where('uuid', $uuid)
                            ->first();

        if (is_null($institue)) {
            abort(404);
        }

        $total_students = User::where('institute_id', $institue->id)->count();

        $student_sheets = StudentSheet::select('id', 'sheet_name', 'created_at')
                                    ->withCount('users')
                                    ->where('institute_id', $institue->id)
                                    ->orderByDesc('id')
                                    ->get();

        return view('admin.institute.student-sheet', compact(
            'institue',
            'student_sheets',
            'total_students'
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

                return back()->with('alert_success', 'Excel imported successfully');

            } catch (ValidationException $e) {
                $errors = [];
                foreach ($e->failures() as $failure) {
                    $errors[$failure->row()][$failure->attribute()] = $failure->errors();
                }

                return back()->withErrors(json_encode($errors));
            
            } catch (\Throwable $e) {
                return back()->with('alert_error', $e->getMessage());
            }
        }
    }

    public function recharge(Request $request, string $uuid, int $id = null)
    {
        $recharge = null;
        if (!is_null($id)) {
            $recharge = Recharge::where('id', $id)
                                ->whereHas('institute', function($query) use($uuid){
                                    $query->where('uuid', $uuid);
                                })
                                ->first();
        }
        $wallets = Wallet::select('id', 'recharge_id', 'amount', 'created_at')
                        ->with([
                            'recharge' => function($query){
                                $query->select('id', 'order_id', 'razorpay_order_id', 'institute_id');
                            }
                        ])
                        ->whereHas('institute', function($query) use($uuid){
                            $query->where('uuid', $uuid);
                        })
                        ->orderBy('id')
                        ->get();

                        // return response()->json($wallets);

        return view('admin.institute.recharge', compact(
            'wallets',
            'recharge',
            'uuid'
        ));
    }

    public function makeRecharge(string $uuid, Request $request)
    {
        $institue = Institute::where('uuid', $uuid)->first();
        if (is_null($institue)) {
            abort(404);
        }
        if ($request->filled('id')) {
            $recharge = Recharge::find($request->id);
        } else {
            $recharge = new Recharge;
        }        
        $recharge->institute_id = $institue->id;
        $recharge->amount = $request->amount;
        $recharge->order_id = $request->order_no;
        $recharge->razorpay_order_id = $request->payment_proof;
        $recharge->save();

        if (!$request->filled('id')) {
            $wallet = new Wallet;
            $wallet->user_id = Auth::id();
            $wallet->recharge_id = $recharge->id;
            $wallet->institute_id = $institue->id;
        } else {
            $wallet = Wallet::where('recharge_id', $recharge->id)->first();
        }
        $wallet->amount = $request->amount;
        $wallet->save();

        return redirect()->route('admin.institute.recharge', ['uuid' => $uuid])->with('alert_success', 'Recharge successfully...');
    }

    public function deleteRecharge(string $uuid, int $id)
    {
        $recharge = Recharge::destroy($id);
        $wallet = Wallet::where('recharge_id', $id)->delete();

        return back()->with('alert_success', "Recharge deleted successfully...");
    }
}
