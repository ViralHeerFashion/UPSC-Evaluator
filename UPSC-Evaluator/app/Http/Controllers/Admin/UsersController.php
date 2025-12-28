<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Admin\{
	UsersExport
};
use App\Models\{
	User,
	UserAttemptQuestion,
	Wallet,
	Institute
};

class UsersController extends Controller
{
    public function index(Request $request)
    {
    	$filter_from = $request->filled('filter_from') ? $request->filter_from : date("Y-m-d", strtotime("-30 days"));
    	$filter_to = $request->filled('filter_to') ? $request->filter_to : date("Y-m-d");
		$institute_wallet_amount = 0;
		$limit = $request->filled('limit') ? $request->limit : 100;

		if ($request->filled('life_time')) {
			$filter_from = date("Y-m-d", strtotime("-50 years"));
			$filter_to = date("Y-m-d");
		}

    	$users = User::select('id', 'name', 'phone', 'email', 'is_registered', 'question_attempted', 'created_at', 'institute_id', 'plain_password', 'status')
    				->withCount('questionAttemp as question_attempted_count')
    				->whereDate('created_at', '>=', $filter_from)
    				->whereDate('created_at', '<=', $filter_to);

		if ($request->filled('institute')) {
			$users = $users->whereHas('institute', function($query) use($request){
				$query->where('uuid', $request->institute)
						->where(function($query) use($request){
							if ($request->filled('sheet_id')) {
								$query->where('student_sheet_id', $request->sheet_id);
							}
						});
			});
			$institute_wallet_amount = Wallet::whereHas('institute', function($query) use($request){
				$query->where('uuid', $request->institute);
			})
			->sum('amount');
		}

    	if ($request->filled('is_registered')) {
    		$users = $users->where('is_registered', $request->is_registered);
    	}

    	if ($request->filled('search')) {
    		$users = $users->where(function($query) use($request){
    			$query->where('name', 'like', '%'.$request->search.'%')
    				->orWhere('email', 'like', '%'.$request->search.'%')
    				->orWhere('phone', 'like', '%'.$request->search.'%');
    		});
    	}

		if ($request->filled('download')) {
			$users = $users->orderByDesc('id')
    					->get();

			return Excel::download(
				new UsersExport($users),
				date("d-m-Y h:i A").".xlsx"
			);
		}

    	$users = $users->orderByDesc('id')
    					->paginate($limit);

    	return view('admin.users.index', compact(
    		'filter_from',
    		'filter_to',
    		'users',
			'institute_wallet_amount',
			'limit'
    	));
    }

    public function getAttemptedQuestion(int $id)
    {
    	$user_attempted_questions = UserAttemptQuestion::select('question_id', 'answer')
    													->with([
    														'screening_questions' => function($query) {
    															$query->select('id', 'question');
    														}
    													])
    													->where('user_id', $id)
    													->get();

    	return view('admin.users.attempt-question', compact(
    		'user_attempted_questions'
    	));
    }

	public function distributeRecharge(string $institute_uuid, Request $request)
	{
		$institute_id = Institute::select('id')
							->where('uuid', $institute_uuid)
							->value('id');
		$recahrge_data = $this->instituteFundDestributionData($institute_id, count($request->user_ids));

		$institue_wallet = new Wallet;
		$institue_wallet->user_id = Auth::id();
		$institue_wallet->institute_id = $institute_id;
		$institue_wallet->amount = "-".$recahrge_data['wallet'];
		$institue_wallet->save();

		foreach ($request->user_ids as $key => $user_id) {
			$wallet = new Wallet;
			$wallet->user_id = Auth::id();
			$wallet->wallet_id = $institue_wallet->id;
			$wallet->amount = $recahrge_data['per_student_recharge'];
			$wallet->save();
		}
		
		return back()->with('alert_success', "Recharge Distribute successfully...");
	}

	private function instituteFundDestributionData(int $institute_id, int $no_of_students)
	{
		$wallet =  Wallet::where('institute_id', $institute_id)->sum('amount');
		$per_student_recharge = round($wallet / $no_of_students, 2);
		return [
			'wallet' => $wallet,
			'per_student_recharge' => $per_student_recharge
		];
	}

	public function changeStatus(int $id, int $status)
	{
		$user = User::find($id);
		$user->status = $status;
		$user->save();

		return response()->json(true);
	}
}
