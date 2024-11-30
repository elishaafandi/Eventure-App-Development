<?php
session_start();
require 'config.php'; // Ensure this includes your database connection setup

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the event ID and selected crew IDs from the form
    $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;
    $selected_crew = isset($_POST['selected_crew']) ? $_POST['selected_crew'] : [];
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Ensure that event ID and at least one crew member are selected
    if ($event_id && !empty($selected_crew) && in_array($action, ['accept', 'reject', 'interview'])) {
        // Prepare the status value based on the action
        $status = '';
        if ($action == 'accept') {
            $status = 'accepted';
        } elseif ($action == 'reject') {
            $status = 'rejected';
        } elseif ($action == 'interview') {
            $status = 'interview';
        }

        // Update the status for each selected crew member
        $sql_update = "UPDATE event_crews SET application_status = ? WHERE crew_id = ? AND event_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        
        foreach ($selected_crew as $crew_id) {
            $stmt_update->bind_param("sii", $status, $crew_id, $event_id);
            $stmt_update->execute();
        }

        if ($action == 'interview') {
            // Redirect to interview_details.php with both event_id and crew_id
            $selected_crew_id = isset($_POST['selected_crew'][0]) ? $_POST['selected_crew'][0] : null; // Assuming one crew is selected
            if ($selected_crew_id) {
                header("Location: interview_details.php?event_id=" . $event_id . "&crew_id=" . $selected_crew_id . "&status=success");
            } else {
                $_SESSION['error'] = "Please select a crew member to schedule an interview.";
                header("Location: organizercrew.php?event_id=" . $event_id . "&status=error");
            }
        } else {
            header("Location: organizercrew.php?event_id=" . $event_id . "&status=success");
        }
        exit;
    }
} else {
    // If not a POST request, redirect back to the crew listing page
    header("Location: organizercrew.php");
    exit;
}
?>
