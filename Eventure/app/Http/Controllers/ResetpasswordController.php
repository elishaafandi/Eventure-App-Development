<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; 
use App\Models\User;

class ResetpasswordController extends Controller
{
    public function Resetemailpass(Request $request)
    {
        // Debug entry
        Log::info("Request received:", $request->all());

        // Validate input fields
        $request->validate([
            'email' => 'required|email',
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);
        

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided email does not match our records.'],
            ]);
        }

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        // Check if the new password is different from the current password
        if (Hash::check($request->new_password, $user->password)) {
            throw ValidationException::withMessages([
                'new_password' => ['The new password cannot be the same as the current password.'],
            ]);
        }

        //dd("Password checks passed. Proceeding to update password.");

        // Update the password
        $user->forceFill([
            'password' => Hash::make($request->new_password),
        ])->setRememberToken(Str::random(60));

        $user->save();

        // Return success response
        return redirect()->route('login')->with('status', 'Your password has been reset successfully!');
    }
}
