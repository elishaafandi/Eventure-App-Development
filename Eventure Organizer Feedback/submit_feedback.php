<?php
// Include the configuration file
require_once("config.php");

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $feedback_to = $mysqli->real_escape_string($_POST['feedback-to']);
    $feedback_text = $mysqli->real_escape_string($_POST['feedback']);
    $rating = intval($_POST['rating']);
    $from_id = 'user_id'; // Replace this with the actual user ID from session or login data

    // Insert feedback into the feedbackevent table
    $sql = "INSERT INTO feedbackevent (from_id, feedback_text, rating, event_id, created_at) 
            VALUES ('$from_id', '$feedback_text', '$rating', (SELECT event_id FROM events WHERE event_name = '$feedback_to' LIMIT 1), NOW())";

    // Execute the query
    if ($mysqli->query($sql) === TRUE) {
        echo "<p>Feedback submitted successfully!</p>";
    } else {
        echo "<p>Error: " . $mysqli->error . "</p>";
    }
}

// Redirect back to the feedback collection page
header("Location: feedback_collection_page.php");
exit();
?>
