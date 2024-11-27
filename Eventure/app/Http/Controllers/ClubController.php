<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    public function createclub(Request $request)
{
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
        'proof' => 'nullable|mimes:jpg,jpeg,png,pdf|max:40960', // Optional file upload validation
    ]);

    // Handle the image upload
    $clubPhoto = null;
    if ($request->hasFile('image')) {
        $clubPhoto = $request->file('image')->store('club_images', 'public'); // Save to 'storage/app/public/club_images'
    }

    // Handle the proof upload
    $approvalLetter = null;
    if ($request->hasFile('proof')) {
        $approvalLetter = $request->file('proof')->store('club_proofs', 'public'); // Save to 'storage/app/public/club_proofs'
    }

    // Insert the club into the database and retrieve the inserted club's ID
    $clubId = DB::table('clubs')->insertGetId([
        'club_name' => $validated['club_name'],
        'description' => $validated['description'],
        'founded_date' => $validated['founded_date'],
        'club_type' => $validated['club_type'],
        'president_id' => $user->id,
        'created_at' => now(),
        'updated_at' => now(),
        'club_photo' => $clubPhoto, // Store the path to the uploaded image
        'approval_letter' => $approvalLetter, // Store the path to the uploaded proof
    ]);

    // Insert the user as a member of the newly created club
    DB::table('club_memberships')->insert([
        'user_id' => $user->id,
        'club_id' => $clubId,
        'position' => 'Member',
        'status' => 'Pending',
        'join_date' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Redirect with success message
    return redirect()->route('addclub')->with('success', 'Club details added successfully!');
}

}
