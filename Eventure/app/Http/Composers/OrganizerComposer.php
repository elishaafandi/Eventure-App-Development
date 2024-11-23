<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Use the DB facade for raw queries

class OrganizerComposer
{
    public function compose(View $view)
    {
        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            abort(404, 'User not found');
        }

        // Fetch the clubs where the user is the president (using raw query or query builder)
        $clubs = DB::table('clubs')
                    ->where('president_id', $user->id)
                    ->get();

        // Get the selected club ID from the session
        $selectedClubId = session('$clubs->club_id', null);

        // If a club is selected, fetch the events related to that club
        if ($selectedClubId) {
            // Return events as a collection (do not convert to array)
            $events = DB::table('events')
                        ->where('club_id', $selectedClubId)
                        ->orderBy('start_date')
                        ->get(); // Keep it as a collection
        } else {
            $events = collect(); // Return an empty collection if no club is selected
        }

        // Prepare data to pass to the views
        $data = [
            'username' => $user->username, // User's username
            'clubs' => $clubs,             // List of clubs the user is president of
            'events' => $events,           // Events related to the selected club (as a collection)
            'selected_club_id' => $selectedClubId // ID of the selected club
        ];

        // Share data with the view
        $view->with($data);
    }
}
