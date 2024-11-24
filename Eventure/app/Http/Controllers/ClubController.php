<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    public function createclub(Request $request){
        //dd('Create club works');

        // Ensure the user is logged in
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        // Validate the form inputs
        $validated = $request->validate([
            'club_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'founded_date' => 'required|date',
            'club_type' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:40960',
            'proof' => 'file|mimes:jpg,jpeg,png,pdf|max:40960', // Optional file upload validation
        ]);

        //dd($validated);

        // Insert the club into the database
        DB::table('clubs')->insert([
            'club_name' => $validated['club_name'],
            'description' => $validated['description'],
            'founded_date' => $validated['founded_date'],
            'club_type' => $validated['club_type'],
            'president_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
            'club_photo'  => $validated['image'],
            'approval_letter' => $validated['proof'],
        ]);

        // Redirect with success message
        return redirect()->route('addclub')->with('success', 'Club details added successfully!');
    
    }
}
