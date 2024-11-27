<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Your login logic here
        $fields = $request->validate([
            'email' => ['required', 'max:25', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($fields, $request->remember_me)) {
            $userId = Auth::id();
            Session::put('user_id', Auth::id());
            
            return redirect()->route('Homepage')->with('success', 'Login successful!');
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('Homepage');
        } else {
            return back()->withErrors([
                'failed' => 'The provided credentials do not match our records'
            ]);
        }
    }


    
}
