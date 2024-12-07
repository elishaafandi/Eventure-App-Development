<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ParticipantDashController extends Controller
{
    public function viewcrewApplication($event_id)
    {
        // Get the event
        $event = DB::table('events')->where('event_id', $event_id)->first();
        Log::info('Event fetched:', ['event' => $event]);

        $user = Auth::user();
        Log::info('Authenticated user:', ['user' => $user]);

        // Get the student's details for this event
        $student = DB::table('students as s')
            ->join('event_crews as ec', 's.id', '=', 'ec.id')
            ->where('ec.event_id', $event_id)
            ->where('ec.id', $user->id)
            ->select(
                's.student_photo',
                's.first_name',
                's.last_name',
                's.email',
                's.matric_no',
                's.phone',
                's.ic',
                's.college',
                's.year_course',
                's.gender',
                'ec.crew_id',
                'ec.past_experience',
                'ec.role',
                'ec.commitment',
                'ec.application_status'
            )
            ->first();

        // Check if the student exists
        if (!$student) {
            Log::warning('No student found for event ID:', ['event_id' => $event_id, 'user_id' => $user->id]);
            return redirect()->route('participantdashboard')->with('error', 'Student data not found for this event.');
        }

        // Return the view with the data
        return view('participant.viewcrewapplication', compact('student', 'event'));
    }
    public function editCrew(Request $request, $event_id)
    {
        $user_id = Auth::id(); // Get authenticated user ID

        // Fetch student details
        $student = DB::table('students')->find($user_id);

        // Fetch crew details for the specific event
        $crew = DB::table('event_crews')
            ->where('id', $user_id)
            ->where('event_id', $event_id)
            ->first();

        // Redirect if no student or crew data is found
        if (!$student || !$crew) {
            return redirect()->route('participantdashboard')->with('error', 'Data not found for this event.');
        }

        if ($request->isMethod('post')) {
            // Validate input data
            $validatedData = $request->validate([
                'past_experience' => 'required|string',
                'role' => 'required|string',
                'commitment' => 'required|string|in:Yes,No',
            ]);

            // Update crew details
            $updated = DB::table('event_crews')
                ->where('id', $user_id)
                ->where('event_id', $event_id)
                ->update([
                    'past_experience' => $validatedData['past_experience'],
                    'role' => $validatedData['role'],
                    'commitment' => $validatedData['commitment'],
                    'updated_at' => now(),
                ]);

            // Provide feedback based on the update result
            if ($updated) {
                return redirect()->route('participantdashboard')->with('success', 'Crew details updated successfully!');
            }
            return back()->with('info', 'No changes were made.');
        }

        // Render the form for GET requests
        return view('participant.editcrew', compact('student', 'crew', 'event_id'));
    }

    public function deleteCrew(Request $request, $event_id)
    {
        $crew_id = $request->input('crew_id'); // Pass this from the form
        \Log::info('Processing deletion', compact('crew_id', 'event_id'));

        // Start a database transaction
        DB::beginTransaction();

        // Step 1: Attempt to delete rows from `feedbackcrew`
    
        // Step 2: Delete rows from `event_crews`
        $deletedCrew = DB::table('event_crews')
            ->where('crew_id', $crew_id)
            ->where('event_id', $event_id)
            ->delete();

        if ($deletedCrew === 0) {
            DB::rollBack();
            \Log::error('No crew deleted', compact('crew_id', 'event_id'));
            return redirect()->route('participantdashboard')
                ->with('error', 'Failed to delete crew.');
        }

        // Commit the transaction
        DB::commit();

        // Success response
        return redirect()->route('participantdashboard')
            ->with('success', 'Crew application deleted successfully. Feedback (if any) was also deleted.');
    }





    // Edit participant information for a specific event
    public function editParticipant(Request $request, $event_id)
    {
        $user_id = Auth::id(); // Get authenticated user ID

        // Fetch student details
        $student = DB::table('students')->where('id', $user_id)->first();
        // Fetch existing registration details for autofill
        $registration = DB::table('event_participants')
            ->where('id', $user_id)
            ->where('event_id', $event_id)
            ->first();

        // Check if the student and registration exist
        if (!$student || !$registration) {
            return redirect()->route('participantdashboard')->with('error', 'Data not found for this event.');
        }

        // Handle POST request for form submission
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'attendance' => 'required|string',
                'requirements' => 'required|string',
            ]);

            // Update the registration data
            $updated = DB::table('event_participants')
                ->where('id', $user_id)
                ->where('event_id', $event_id)
                ->update([
                    'attendance' => $validatedData['attendance'],
                    'requirements' => $validatedData['requirements'],
                    'updated_at' => now(),
                ]);

            if ($updated === 0) {
                return back()->with('info', 'No changes were made.');
            }

            return redirect()->route('participantdashboard')->with('success', 'Your information has been updated successfully!');
        }

        // Render the form for GET request
        return view('participant.editparticipant', compact('student', 'registration', 'event_id'));
    }



    public function viewparticipantApplication($event_id)
    {
        $user_id = Auth::id(); // Get the authenticated user's ID

        // Fetch event details
        $event = DB::table('events')->where('event_id', $event_id)->first();

        // Fetch student details
        $student = DB::table('students as s')
            ->join('event_participants as ep', 's.id', '=', 'ep.id')
            ->where('ep.event_id', $event_id)
            ->where('ep.id', $user_id)
            ->select(
                's.student_photo',
                's.first_name',
                's.last_name',
                's.email',
                's.matric_no',
                's.phone',
                's.ic',
                's.college',
                's.year_course',
                's.gender',
                'ep.participant_id',
                'ep.registration_status',
                'ep.attendance_status',
                'ep.requirements'
            )
            ->first();

        if (!$event || !$student) {
            return redirect()->route('participantdashboard')->with('error', 'Data not found.');
        }

        // Pass data to the view
        return view('participant.viewparticipantapplication', compact('event', 'student'));
    }

    public function deleteParticipant(Request $request, $event_id)
    {
        $user_id = auth()->id(); // Get the authenticated user's ID
        Log::info('Processing participant deletion', compact('user_id', 'event_id'));

        // Start a database transaction
        DB::beginTransaction();

        // Step 1: Attempt to delete the participant from `event_participants`
        $deletedParticipant = DB::table('event_participants')
            ->where('id', $user_id)
            ->where('event_id', $event_id)
            ->delete();

        if ($deletedParticipant === 0) {
            DB::rollBack();
            Log::error('No participant deleted', compact('user_id', 'event_id'));
            return redirect()->route('participantdashboard')
                ->with('error', 'Failed to delete participant application.');
        }

        // Commit the transaction if both operations succeed
        DB::commit();

        // Success response
        return redirect()->route('participantdashboard')
            ->with('success', 'Participant application deleted successfully, and available slots updated.');
    }
}
