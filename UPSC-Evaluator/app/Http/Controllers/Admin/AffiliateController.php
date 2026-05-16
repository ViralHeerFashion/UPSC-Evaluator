<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Affiliate,
    User
};

class AffiliateController extends Controller
{
    public function index()
    {
        $affiliates = Affiliate::withCount('students');

        $affiliates = $affiliates->orderByDesc('id')
                                ->paginate(100);

        return view('admin.affiliate.index', compact(
            'affiliates'
        ));    
    }

    public function create(Request $request)
    {
        if ($request->filled('id')) {
            $affiliate = Affiliate::findOrFail($request->id);
        } else {
            $affiliate = new Affiliate;
        }
        $affiliate->name = $request->name;
        $affiliate->phone = $request->phone;
        $affiliate->email = $request->email;
        $affiliate->affiliate_code = $request->affiliate_code;
        $affiliate->save();
        
        return back()->with('alert_success', 'Affiliate add/edit successfully...');
    }

    public function delete(int $id)
    {
        $student_exists = User::where('affiliate_id', $id)->exists();

        if (!$student_exists) {
            Affiliate::destroy($id);
            return back()->with('alert_success', "Affiliate Deleted successfully...");
        }
        return back()->with('alert_error', "We are unable to delete these affiliate users because they are associated with active student records.");
    }
}
