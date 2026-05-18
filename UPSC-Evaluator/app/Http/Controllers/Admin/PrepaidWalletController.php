<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Admin\{
	PostPaidWalletRechargeExport
};
use App\Models\{
    User
};

class PrepaidWalletController extends Controller
{
    public function index(Request $request)
    {
        $filter_from = $request->filled('filter_from') ? $request->filter_from : date("Y-m-d", strtotime("first day of this month"));
        $filter_to = $request->filled('filter_to') ? $request->filter_to : date("Y-m-d", strtotime("last day of this month"));

        $prepaid_wallet = DB::table('wallet as w')
                            ->join('users as u', function ($join) {
                                $join->on('u.id', '=', 'w.user_id')
                                    ->where('u.is_outside_institute_reference', 1);
                            })
                            ->join('institutes as i', function($join){
                                $join->on('i.id', '=', 'u.institute_id');
                            })
                            ->join('recharge as r', function ($join) use($filter_from, $filter_to){
                                $join->on('r.id', '=', 'w.recharge_id')
                                    ->where('r.razorpay_order_id', 'like', 'Welcome bonus%')
                                    ->whereDate('r.created_at', '>=', $filter_from)
                                    ->whereDate('r.created_at', '<=', $filter_to);
                            })
                            ->select(
                                'u.id as user_id',
                                'u.name as user_name',
                                'i.name as institute_name',
                                DB::raw('SUM(w.amount) as prepaid_wallet_amount')
                            )
                            ->groupBy('u.id', 'u.name', 'i.name');

        if ($request->has('download')) {
            $prepaid_wallet = $prepaid_wallet->get();
            
            return Excel::download(
				new PostPaidWalletRechargeExport($prepaid_wallet),
				date("d-m-Y h:i A").".xlsx"
			);
        }

        $prepaid_wallet = $prepaid_wallet->paginate(100);

        return view('admin.prepaid-wallet.index', compact(
    		'prepaid_wallet',
            'filter_from',
            'filter_to'
    	));
    }

    public function makePaid(Request $request)
    {
        if ($request->filled('user_ids')) {
            User::whereIn('id', $request->user_ids)
                ->update([
                    'is_wallet_referred_amount_received' => 1
                ]);
        }
        return back()->with('alert_success', "Wallet amount paid successfully...");
    }
}
