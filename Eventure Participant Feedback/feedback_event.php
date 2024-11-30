<?php
session_start();
require 'config.php'; // Ensure this includes your database connection setup

// Get the event ID from the URL query parameter
$view_event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

if (!$view_event_id) {
    echo "<script>alert('No event selected.'); window.location.href='rate_crew.php';</script>";
    exit;
}

$sql_feedback = "
SELECT 
    fe.feedbackevent_id, 
    fe.rating, 
    fe.feedback, 
    fe.feedback_date, 
    e.event_role, 
    fe.crew_id, 
    fe.participant_id
FROM feedbackevent fe
JOIN events e ON fe.event_id = e.event_id
WHERE fe.event_id = ?
ORDER BY fe.feedback_date DESC";

$stmt_feedback = $conn->prepare($sql_feedback);
$stmt_feedback->bind_param("i", $view_event_id);
$stmt_feedback->execute();
$result_feedback = $stmt_feedback->get_result();

$feedbacks = [];
while ($row = $result_feedback->fetch_assoc()) {
    $feedback = $row;

    // Fetch the appropriate name based on the role
if ($row['event_role'] === 'Crew') {
    $sql_name = "SELECT first_name FROM students WHERE id = (SELECT id FROM event_crews WHERE crew_id = ?)";
} elseif ($row['event_role'] === 'Participant') {
    $sql_name = "SELECT first_name FROM students WHERE id = (SELECT id FROM event_participants WHERE participant_id = ?)";
}

// Assign the correct ID to a variable
$role_id = $row['event_role'] === 'Crew' ? $row['crew_id'] : $row['participant_id'];

// Prepare and execute the query
$stmt_name = $conn->prepare($sql_name);
$stmt_name->bind_param("i", $role_id);  // Pass the variable here
$stmt_name->execute();
$result_name = $stmt_name->get_result();
$name_row = $result_name->fetch_assoc();

$feedback['name'] = $name_row['first_name'] ?? 'Unknown';
 // Add feedback to the array
 $feedbacks[] = $feedback;  
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback for Event</title>
    <link rel="stylesheet" href="rate_crew.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .feedback-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .feedback-card h4 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }

        .feedback-card p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }

        .feedback-card p small {
            font-size: 12px;
            color: #888;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h2>Feedback for Event</h2>
        <div class="header-left">
            <div class="nav-right">
                <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
                <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a>
                <span class="notification-bell">🔔</span>
                <a href="profilepage.php" class="profile-icon"><i class="fas fa-user-circle"></i></a>
            </div>
        </div>
    </header>

    <main>
        <aside class="sidebar">
            <div class="logo-container">
                <a href="organizerhome.php" class="logo">EVENTURE</a>
            </div>
            <ul>
                <li><a href="organizerhome.php"><i class="fas fa-home-alt"></i> Dashboard</a></li>
                <li><a href="organizerevent.php"><i class="fas fa-calendar-alt"></i> Event Hosted</a></li>
                <li><a href="organizerparticipant.php"><i class="fas fa-user-friends"></i> Participant Listing</a></li>
                <li><a href="organizercrew.php"><i class="fas fa-users"></i> Crew Listing</a></li>
                <li><a href="organizerreport.php"><i class="fas fa-chart-line"></i> Reports</a></li>
                <li><a href="rate_crew.php" class="active"><i class="fas fa-star"></i> Feedback</a></li>
            </ul>
            <ul style="margin-top: 60px;">
                <li><a href="organizersettings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <h3>Feedback for the Selected Event</h3>
            <div class="card-container">
                <?php if (!empty($feedbacks)): ?>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <div class="feedback-card">
                            <h4>Feedback ID: <?= htmlspecialchars($feedback['feedbackevent_id']); ?></h4>
                            <p><strong>Name:</strong> <?= htmlspecialchars($feedback['name']); ?></p>
                            <p><strong>Role:</strong> <?= htmlspecialchars($feedback['event_role']); ?></p>
                            <p><strong>Rating:</strong> <?= htmlspecialchars($feedback['rating']); ?> / 5</p>
                            <p><strong>Feedback:</strong> <?= htmlspecialchars($feedback['feedback']); ?></p>
                            <p><small><strong>Date:</strong> <?= htmlspecialchars($feedback['feedback_date']); ?></small></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No feedback available for this event.</p>
                <?php endif; ?>
            </div>
            <a href="rate_crew.php" class="btn-back">Back to Feedback</a>
        </div>
    </main>
</body>
</html>
