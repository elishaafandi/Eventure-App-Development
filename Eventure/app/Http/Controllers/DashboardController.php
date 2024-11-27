<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function organizerclubevent(Request $request)
    { 

        $selectedClubId = $request->input('club_id');

        // Fetch events for the selected club
        $events = DB::table('events')
                    ->where('club_id', $selectedClubId)
                    ->orderBy('start_date')
                    ->get();
                    $events = $events->map(function ($event) {
                        // Assuming 'total_slots' is a field in your 'events' table
                        $totalSlots = $event->total_slots; // Get the total slots from the event
                        $availableSlots = $event->available_slots; // Get the available slots from the event
                
                        // Calculate participants as total slots minus available slots
                        $participants = $totalSlots - $availableSlots;
                
                        // Add the calculated participants value to the event
                        $event->participants = $participants;
                
                        return $event;
                    });
                    
        // Return the events as a JSON response
        return response()->json([
            'events' => $events
        ]);
    }
}
