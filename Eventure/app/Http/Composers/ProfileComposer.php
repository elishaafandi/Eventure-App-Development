<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileComposer
{
    public function compose(View $view)
    {
        $user = Auth::user(); // Get authenticated user

        if (!$user) {
            abort(404, 'User not found');
        }

        $student = \DB::table('students')->where('id', $user->id)->first();

        // Prepare data
        $data = [
            'username'  => $user->username,
            'email'     => $user->email,
            'role'      => $user->role,
            'firstname' => $student ? $student->first_name : null,
            'lastname'  => $student ? $student->last_name : null,
            'ic'        => $student ? $student->ic : null,
            'matricno'  => $student ? $student->matric_no : null,
            'gender'    => $student ? $student->gender : null,
        ];

        // Share data with the view
        $view->with($data);
    }
}
