<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {   
        $request->validate([
            'email' => 'required|email',
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if(!($status == Password::RESET_LINK_SENT)){
            return response()->json(['message'=>'No such user'], 405);                  
        }                    
        else{                    
            //$data=DB::table('password_resets')->where('email', $request->only('email'))->first(); Frontend will send the token that is in the header 
            return response()->json(['message'=>'Reset password link sent successfully'], 200);                    
        }
    }
}
