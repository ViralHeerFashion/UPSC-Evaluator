<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

    	if (Auth::guard('institute')->attempt($credentials, 1)) {
            $request->session()->regenerate();

            return redirect(
                $this->redirectInstituteTab()
            );
		}

        return back();
    }

    public function logout(Request $request)
    {
        Auth::guard('institute')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('institute.login');
    }
    
    private function redirectInstituteTab()
    {
        $permission = json_decode(Auth::guard('institute')->user()->permissions);
        if(is_null($permission)){
            return route('institute.profile');
        }
        $route = null;
        switch ($permission[0]) {
            case 'model_answer':
                $route = route('institute.model-answer');
                break;
            
            case 'students':
                $route = route('institute.students');
                break;
                
            case 'bulk_pdf_process':
                $route = route('institute.bulk-pdf-process');
                break;
                
            default:
                $route = route('institute.profile');
                break;
        }
        return $route;
    }
}
