<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
	User,
	UserAttemptQuestion
};

class UsersController extends Controller
{
    public function index(Request $request)
    {
    	$filter_from = $request->filled('filter_from') ? $request->filter_from : date("Y-m-d", strtotime("-30 days"));
    	$filter_to = $request->filled('filter_to') ? $request->filter_to : date("Y-m-d");

    	$users = User::select('id', 'name', 'phone', 'email', 'is_registered', 'question_attempted', 'created_at')
    				->withCount('questionAttemp as question_attempted_count')
    				->whereDate('created_at', '>=', $filter_from)
    				->whereDate('created_at', '<=', $filter_to);

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

    	$users = $users->orderByDesc('id')
    					->paginate(100);

    	return view('admin.users.index', compact(
    		'filter_from',
    		'filter_to',
    		'users'
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
}
