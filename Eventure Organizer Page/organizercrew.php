<?php
session_start();
require 'config.php'; // Ensure this includes your database connection setup

// Check if a club is selected and store it in the session
if (isset($_GET['club_id'])) {
    $_SESSION['SELECTEDID'] = $_GET['club_id'];
    header("Location: organizerevent.php"); // Redirect to avoid form resubmission
    exit;
}

// Get the selected club ID from the session
$selected_club_id = isset($_SESSION['SELECTEDID']) ? $_SESSION['SELECTEDID'] : null;

// Fetch events for the selected club
$sql_events = "SELECT event_id, event_name FROM events WHERE club_id = ? AND event_role = 'crew'";
$stmt_events = $conn->prepare($sql_events);
$stmt_events->bind_param("i", $selected_club_id);
$stmt_events->execute();
$result_events = $stmt_events->get_result();

$events = [];
while ($row = $result_events->fetch_assoc()) {
    $events[] = $row;
}

// Get the selected event ID
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : (isset($events[0]['event_id']) ? $events[0]['event_id'] : null);

$_SESSION['SELECTED_EVENT_ID'] = $event_id;

// Fetch event details for the selected event
if ($event_id) {
    $sql_event = "SELECT e.event_name, e.start_date, e.end_date, e.event_status, e.event_type, 
                         e.event_format, e.description, e.location, e.total_slots, e.available_slots
                  FROM events e
                  WHERE e.event_id = ? ";
    $stmt_event = $conn->prepare($sql_event);
    $stmt_event->bind_param("i", $event_id);
    $stmt_event->execute();
    $result_event = $stmt_event->get_result();

    if ($result_event->num_rows > 0) {
        $event = $result_event->fetch_assoc();
    } else {
        $event = null;
    }
}

// Fetch crew applications for the selected event
$crew_filter = isset($_GET['crew_filter']) ? $_GET['crew_filter'] : 'all';
$sql_crew = "
    SELECT 
        ec.crew_id, ec.role, ec.application_status, 
        s.id, s.first_name, s.last_name, s.student_photo, 
        s.ic, s.matric_no, s.phone, s.faculty_name, 
        s.year_course, s.college, s.email, s.gender
    FROM 
        event_crews ec
    JOIN 
        students s ON ec.id = s.id
    WHERE 
        ec.event_id = ?";
if ($crew_filter !== 'all') {
    $sql_crew .= " AND ec.application_status = ?";
    $stmt_crew = $conn->prepare($sql_crew);
    $stmt_crew->bind_param("is", $event_id, $crew_filter);
} else {
    $stmt_crew = $conn->prepare($sql_crew);
    $stmt_crew->bind_param("i", $event_id);
}
$stmt_crew->execute();
$result_crew = $stmt_crew->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Listing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="organizercrew.css">
</head>
<body>
    <header>
        <h1>Crew Listing</h1>
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
        <li><a href="organizerhome.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerhome.php' ? 'active' : ''; ?>"><i class="fas fa-home-alt"></i> Dashboard</a></li>
        <li><a href="organizerevent.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerevent.php' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i>Event Hosted</a></li>
        <li><a href="organizerparticipant.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerparticipant.php' ? 'active' : ''; ?>"><i class="fas fa-user-friends"></i>Participant Listing</a></li>
        <li><a href="organizercrew.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizercrew.php' ? 'active' : ''; ?>"><i class="fas fa-users"></i>Crew Listing</a></li>
        <li><a href="organizerreport.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerreport.php' ? 'active' : ''; ?>"><i class="fas fa-chart-line"></i>Reports</a></li>
        <li><a href="rate_crew.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizerfeedback.php' ? 'active' : ''; ?>"><i class="fas fa-star"></i>Feedback</a></li>
    </ul>
    <ul style="margin-top: 60px;">
        <li><a href="organizersettings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'organizersettings.php' ? 'active' : ''; ?>"><i class="fas fa-cog"></i>Settings</a></li>
        <li><a href="logout.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : ''; ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Event Selection -->
            <form method="GET">
                <label for="event_id">Select Event:</label>
                <select name="event_id" id="event_id" onchange="this.form.submit()">
                    <?php foreach ($events as $event_option): ?>
                        <option value="<?php echo htmlspecialchars($event_option['event_id']); ?>"
                            <?php echo $event_id == $event_option['event_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($event_option['event_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if (isset($event)): ?>
                <div class="event-info">
                    <h2><?php echo htmlspecialchars($event['event_name']); ?></h2>
                    <p>Program Date: <?php echo htmlspecialchars($event['start_date'] . " to " . $event['end_date']); ?></p>
                    <p>Location: <?php echo htmlspecialchars($event['location']); ?></p>
                    <p>Description: <?php echo htmlspecialchars($event['description']); ?></p>
            </div>
            <?php endif; ?>



            <!-- Crew Applications -->
            <h3>Crew Applications</h3>
            <label for="crew-filter">Filter by Status:</label>
            <select id="crew-filter" onchange="window.location.href='?event_id=<?php echo $event_id; ?>&crew_filter=' + this.value;">
                <option value="all" <?php echo $crew_filter === 'all' ? 'selected' : ''; ?>>All</option>
                <option value="applied" <?php echo $crew_filter === 'applied' ? 'selected' : ''; ?>>Applied</option>
                <option value="interview" <?php echo $crew_filter === 'interview' ? 'selected' : ''; ?>>Interview</option>
                <option value="rejected" <?php echo $crew_filter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                <option value="accepted" <?php echo $crew_filter === 'accepted' ? 'selected' : ''; ?>>Accepted</option>
            </select>

         
            <form method="POST" action="process_crew_action.php">
    <table class="crew-table">
        <thead>
            <tr>
                <th>Select</th>
                <th>Photo</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Year & Course</th>
                <th>Role</th>
                <th>Application Status</th>
                <th>View Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($crew = $result_crew->fetch_assoc()): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="selected_crew[]" value="<?php echo htmlspecialchars($crew['crew_id']); ?>">
                    </td>
                    <td>
                    <?php
                           
                        if (!empty($crew['student_photo'])) {
                            $base64Image = 'data:image/jpeg;base64,' . base64_encode($crew['student_photo']);
                            echo '<img src="' . $base64Image . '" alt="Student Photo" width="50" height="50">';
                        } else {
                             echo '<img src="placeholder.jpg" alt="Placeholder" width="50" height="50">';
                        }
                           
                    ?>

                    </td>
                    <td><?php echo htmlspecialchars($crew['first_name'] . " " . $crew['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($crew['email']); ?></td>
                    <td><?php echo htmlspecialchars($crew['year_course']); ?></td>
                    <td><?php echo htmlspecialchars($crew['role']); ?></td>
                    <td><?php echo htmlspecialchars($crew['application_status']); ?></td>
                    <td>
                    <a href="organizerviewcrew.php?id=<?php echo $crew['crew_id']; ?>" class="view-button">View</a>
                <?php if ($crew['application_status'] === 'interview'): ?>
                    <a href="interview_details.php?crew_id=<?php echo $crew['crew_id']; ?>&event_id=<?php echo $event_id; ?>" class="interview-details-button">Interview Details</a>

                <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="action-buttons">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        <button type="submit" name="action" value="accept" class="accept-btn">Accept</button>
        <button type="submit" name="action" value="reject" class="reject-btn">Reject</button>
        <button type="submit" name="action" value="interview" class="interview-btn">Interview</button>
        <!--<button class="view-interview-btn">View Interview List</button>-->
        <a href="interviewlist.php" class="view-interview-btn">View Interview List</a>
    </div>
</form>

<script>
    // Set the new_status value before submitting the form
    function setStatus(status) {
        document.getElementById('new_status').value = status;
    }
</script>
        </div>
    </main>
</body>
</html>
