<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Wallet
};

class WalletController extends Controller
{
    public function index()
    {
        $balance = Wallet::where('user_id', Auth::id())->sum('amount');
        $transactions = Wallet::orderBy('id')->get();

        return view('student.wallet.index', compact(
            'balance',
            'transactions'
        ));    
    }
}
