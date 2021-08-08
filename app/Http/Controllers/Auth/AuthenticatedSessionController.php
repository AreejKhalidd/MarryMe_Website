<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //$request->authenticate();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data'], 400);
        } else {
            //$request->session()->regenerate();
            //$request->password=Hash::make($request->password);
            $credentials = $request->only('email', 'password');
            $token = auth()->attempt($credentials,true);
            if ($token){
                return response()->json(['message' => 'logged in successfully','AccessToken:'=>$token], 200);
            }
            else{
                return response()->json(['message' => 'No such user, invalid email or password'], 400);
            }
        }
    }

    
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        //Auth::guard('api')->logout();
        auth()->logout();

        //$request->session()->invalidate();
        //$request->session()->regenerateToken();

        return response()->json(['message' => 'logged out successfully'], 200);
    }
}
