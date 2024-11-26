<?php
// Include the config file to establish the database connection
include 'config.php';

// Start the session to access session variables
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['ID'])) {
    echo "You must be logged in to access this page.";
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['ID'];

// Fetch student details to autofill form
$studentQuery = "SELECT * FROM students WHERE id = ?";
$studentStmt = $conn->prepare($studentQuery);
$studentStmt->bind_param("i", $user_id);
$studentStmt->execute();
$studentResult = $studentStmt->get_result();
$student = $studentResult->fetch_assoc();

// Fetch the username of the logged-in user
$sql_username = "SELECT username FROM users WHERE id = ?";
$stmt_username = mysqli_prepare($conn, $sql_username);
mysqli_stmt_bind_param($stmt_username, "i", $user_id);
mysqli_stmt_execute($stmt_username);
$result_username = mysqli_stmt_get_result($stmt_username);

// Check if username was found
if ($result_username && mysqli_num_rows($result_username) > 0) {
    $row = mysqli_fetch_assoc($result_username);
    $username = $row['username']; // Retrieve the username
} else {
    $username = "User"; // Default in case of an error
}

// Query to get event crews (assuming 'event_role' column marks crew members)
$query_crew = "SELECT ec.crew_id, ec.event_id, e.status, e.organizer, e.event_name, ec.role, ec.application_status, ec.created_at, ec.updated_at
               FROM event_crews ec
               JOIN events e ON ec.event_id = e.event_id
               WHERE ec.id = ?";
$stmt_crew = $conn->prepare($query_crew);
$stmt_crew->bind_param("i", $user_id);
$stmt_crew->execute();
$result_crew = $stmt_crew->get_result();

// Query to get event participants (non-crew members)
$query_participant = "SELECT ep.participant_id, e.organizer, e.status, ep.event_id, e.event_name, ep.registration_status, ep.created_at, ep.updated_at
                      FROM event_participants ep
                      JOIN events e ON ep.event_id = e.event_id
                      WHERE ep.id = ?";
$stmt_participant = $conn->prepare($query_participant);
$stmt_participant->bind_param("i", $user_id);
$stmt_participant->execute();
$result_participant = $stmt_participant->get_result();

// Fetch results for display
$events_crews = $result_crew->num_rows > 0 ? $result_crew->fetch_all(MYSQLI_ASSOC) : [];
$events_participant = $result_participant->num_rows > 0 ? $result_participant->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>www.eventureutm.com</title>
    <link rel="stylesheet" href="participantdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="participanthome.php" class="logo">EVENTURE</a> 
            <nav class="nav-left">
                <a href="participanthome.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participanthome.php' ? 'active' : ''; ?>"></i>Home</a></li>
                <a href="participantdashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participantdashboard.php' ? 'active' : ''; ?>"></i>Dashboard</a></li>
                <a href="participantcalendar.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participantcalendar.php' ? 'active' : ''; ?>"></i>Calendar</a></li>
                <a href="profilepage.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profilepage.php' ? 'active' : ''; ?>"></i>User Profile</a></li>
            </nav>
        </div>
        <div class="nav-right">
            <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
            <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a> 
            <span class="notification-bell">🔔</span>
            <div class="profile-menu">
                <!-- Ensure the profile image is fetched and rendered properly -->
                <?php if (!empty($student['student_photo'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($student['student_photo']); ?>" alt="Student Photo" class="profile-icon">
                <?php else: ?>
                    <img src="default-profile.png" alt="Default Profile" class="profile-icon">
                <?php endif; ?>

                <!-- Dropdown menu -->
                <div class="dropdown-menu">
                    <a href="profilepage.php">Profile</a>
                    <hr>
                    <a href="logout.php" class="sign-out">Sign Out</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="main-content">
            <div class="event-status">
                <h2>Welcome <?php echo htmlspecialchars($username); ?>!</h2>
            </div>

            <div class="event-status">
                <h2>Applied Events</h2><br>
                
                <!-- Crew Events -->
                <h3>Crew</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Event Name</th>
                            <th>Organizer</th>
                            <th>Application Date</th>
                            <th>Application Status</th>
                            <th>Event Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($events_crews)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($events_crews as $event): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                                <td><?php echo htmlspecialchars($event['organizer']); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($event['created_at'])); ?></td>
                                <td>
                                <?php 
                                    if ($event['application_status'] == 'applied') {
                                        echo '<span class="status applied">Applied</span>';
                                    } elseif ($event['application_status'] == 'interview') {
                                        echo '<span class="status interview">Interview</span>';
                                    } elseif ($event['application_status'] == 'rejected') {
                                        echo '<span class="status rejected">Rejected</span>';
                                    } elseif ($event['application_status'] == 'pending') {
                                        echo '<span class="status pending">Pending</span>';
                                    } elseif ($event['application_status'] == 'accepted') {
                                        echo '<span class="status accepted">Accepted</span>';
                                    }
                                ?>
                                </td>
                                <td>
                                <?php echo htmlspecialchars($event['status']); ?></td>
                                </td>
                                <td>
                                <a href="viewcrewapplication.php?event_id=<?php echo $event['event_id']; ?>" class="btn view">View</a>
                                     <!-- Edit button enabled only if application status is 'pending' or 'applied' -->
                                    <a href="editcrewform.php?event_id=<?php echo $event['event_id']; ?>"
                                    class="btn edit <?php echo ($event['application_status'] != 'pending' && $event['application_status'] != 'applied') ? 'disabled' : ''; ?>"
                                    <?php echo ($event['application_status'] != 'pending' && $event['application_status'] != 'applied') ? 'onclick="return false;"' : ''; ?>>
                                    Edit
                                    </a>
    
                                    <!-- Delete button enabled only if application status is 'pending' or 'applied' -->
                                    <a href="delete_event.php?event_id=<?php echo $event['event_id']; ?>"
                                    class="btn delete <?php echo ($event['application_status'] != 'pending' && $event['application_status'] != 'applied') ? 'disabled' : ''; ?>"
                                    <?php echo ($event['application_status'] != 'pending' && $event['application_status'] != 'applied') ? 'onclick="return false;"' : 'onclick="return confirm(\'Are you sure you want to delete this application?\')"'; ?>>
                                    Cancel
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">You have not registered for any crew events yet.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table><br>

                <!-- Participant Events -->
                <h3>Participant</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Event Name</th>
                            <th>Organizer</th>
                            <th>Application Date</th>
                            <th>Application Status</th>
                            <th>Event Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($events_participant)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($events_participant as $event): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                                <td><?php echo htmlspecialchars($event['organizer']); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($event['created_at'])); ?></td>
                                <td>
                                    <?php 
                                    if ($event['registration_status'] == 'registered') {
                                        echo '<span class="status accepted">Registered</span>';
                                    } elseif ($event['registration_status'] == 'cancelled') {
                                        echo '<span class="status rejected">Cancelled</span>';
                                    } 
                                    ?>
                                </td>
                                <td>
                                <?php echo htmlspecialchars($event['status']); ?>
                                </td>
                                <td>
                                <a href="viewparticipantapplication.php?event_id=<?php echo $event['event_id']; ?>" class="btn view">View</a>
                                    <a href="editparticipantform.php?event_id=<?php echo $event['event_id']; ?>"
                                    class="btn edit <?php echo ($event['registration_status'] != 'registered') ? 'disabled' : ''; ?>"
                                    <?php echo ($event['registration_status'] != 'registered') ? 'onclick="return false;"' : ''; ?>>
                                    Edit
                                    </a>
                                    <a href="delete_event.php?event_id=<?php echo $event['event_id']; ?>"
                                    class="btn delete <?php echo ($event['registration_status'] != 'registered') ? 'disabled' : ''; ?>"
                                    <?php echo ($event['registration_status'] != 'registered') ? 'onclick="return false;"' : 'onclick="return confirm(\'Are you sure you want to delete this application?\')"'; ?>>
                                    Cancel
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">You have not registered for any events yet.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="event-status">
                <h2>Feedback</h2>
            </div>

        </section>
    </main>

    <script>
    /// Handle Profile Icon Click
    document.addEventListener("DOMContentLoaded", function () {
    const profileMenu = document.querySelector(".profile-menu");
    const profileIcon = document.querySelector(".profile-icon");

    // Toggle dropdown on profile icon click
    profileIcon.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent event from bubbling
        profileMenu.classList.toggle("open");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (!profileMenu.contains(event.target)) {
            profileMenu.classList.remove("open");
        }
    });
});

</script>
</body>
</html>