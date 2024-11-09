<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Created</title>
    <link rel="stylesheet" href="organizerevent.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
            <a href="organizerhome.php" class="logo">EVENTURE</a>
        </div>
    <ul>
        <li><a href="organizerhome.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerhome.php' ? 'active' : ''; ?>"><i class="fas fa-home-alt"></i> Dashboard</a></li>
        <li><a href="organizerevent.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerevent.php' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i>Event Hosted</a></li>
        <li><a href="organizerparticipant.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerparticipant.php' ? 'active' : ''; ?>"><i class="fas fa-user-friends"></i>Participant Listing</a></li>
        <li><a href="organizercrew.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizercrew.php' ? 'active' : ''; ?>"><i class="fas fa-users"></i>Crew Listing</a></li>
        <li><a href="organizerreport.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerreport.php' ? 'active' : ''; ?>"><i class="fas fa-chart-line"></i>Reports</a></li>
        <li><a href="organizerfeedback.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerfeedback.php' ? 'active' : ''; ?>"><i class="fas fa-star"></i>Feedback</a></li>
    </ul>
    <ul style="margin-top: 60px;">
        <li><a href="organizersettings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizersettings.php' ? 'active' : ''; ?>"><i class="fas fa-cog"></i>Settings</a></li>
        <li><a href="organizerlogout.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerlogout.php' ? 'active' : ''; ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
    </aside>   

    <div class="main-content">
        <header>
            <h1>Events Created</h1>
            <button class="participant-site">PARTICIPANT SITE</button>
            <button class="organizer-site">ORGANIZER SITE</button>
            <span class="notification-bell">🔔</span>
        </header>

        <div class="top-bar">
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <button>🔍</button>
            </div>
            <div class="status-tabs">
                <span>All Events</span>
                <span>Successful</span>
                <span>Pending</span>
                <span>Saved Drafts</span>
            </div>
            <button class="create-event-button">CREATE EVENT FOR PARTICIPANT</button>
            <button class="create-event-button">CREATE EVENT FOR CREW</button>
        </div>

        <?php
// Include the database connection
include('config.php'); // Ensure you have a db_connection.php with $conn defined

// Fetch events from the database
$sql = "SELECT event_id, event_name, description, location, event_status, event_type FROM events";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($event = $result->fetch_assoc()) {
        echo '<div class="event-row">';
        echo '<div class="event-card">';

        echo '<div class="event-info">';
        echo '<h2>' . htmlspecialchars($event["event_name"]) . '</h2>';
        echo '<p>' . htmlspecialchars($event["description"]) . ', Location: ' . htmlspecialchars($event["location"]) . '</p>';
        
        // Example details, assuming you have columns like 'unprocessed', 'accepted', 'rejected', and 'interview' in the `event` table or related table
        echo '<div class="details">';
        echo '<span>Unprocessed: ' . (isset($event["unprocessed"]) ? $event["unprocessed"] : 0) . '</span>';
        echo '<span>Accepted: ' . (isset($event["accepted"]) ? $event["accepted"] : 0) . '</span>';
        echo '<span>Rejected: ' . (isset($event["rejected"]) ? $event["rejected"] : 0) . '</span>';
        echo '<span>Interview: ' . (isset($event["interview"]) ? $event["interview"] : 0) . '</span>';
        echo '</div>';

        echo '<div class="event-actions">';
        echo '<a href="organizerviewevent.php?id=' . $event['event_id'] . '" class="view">VIEW</a>';
        echo '<a href="editevent.php?id=' . $event['event_id'] . '" class="edit">EDIT</a>';
        echo '<a href="deleteevent.php?id=' . $event['event_id'] . '" class="delete" onclick="return confirm(\'Are you sure you want to delete this event?\');">DELETE</a>';
        echo '</div>';
        echo '</div>';
        
        // Status container
        echo '<div class="status-container">';
        echo '<div class="status">';
        echo '<strong>' . htmlspecialchars($event["event_status"]) . '</strong><br>';
        if ($event["event_status"] == "Application Open") {
            echo '<button class="close-application">Close Application</button>';
        } else {
            echo '<button class="open-application">Open Application</button>';
        }
        echo '</div>';
        echo '</div>';

        echo '</div>'; // end of event-card
        echo '</div>'; // end of event-row
    }
} else {
    echo "<p>No events found.</p>";
}
?>
        </div>
    </div>
</body>
</html>
