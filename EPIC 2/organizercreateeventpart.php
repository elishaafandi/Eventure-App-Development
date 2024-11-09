<?php
include 'config.php';
session_start();

// Check if user is logged in by verifying the session ID
if (!isset($_SESSION["id"])) {
    // Redirect to homepage if ID is missing
    header("Location: organizerhome.php");
    exit; 
}

// Ensure the club ID is stored in the session
if (isset($_GET['club_id'])) {
    $_SESSION['SELECTEDID'] = $_GET['club_id'];  // Store selected club ID in session
} 

// Initialize club ID from session
$selected_club_id = isset($_SESSION["SELECTEDID"]) ? $_SESSION["SELECTEDID"] : '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Event details handling code here...
        $event_role = $_POST['event_role'] ?? 'Participant';
        $organizer_id = $_POST['organizer_id'] ?? 0;
        $club_id = $_SESSION['SELECTEDID'] ?? 0; // Use the club_id from session
        $organizer = $_POST['organizer'] ?? '';
        $event_name = $_POST['event_name'] ?? '';
        $description = $_POST['event_description'] ?? '';
        $location = $_POST['location'] ?? '';
        $total_slots = $_POST['total_slots'] ?? 0;
        $available_slots = $_POST['available_slots'] ?? $total_slots; // Default available slots to total slots
        $event_status = $_POST['event_status'] ?? 'pending';
        $event_type = $_POST['event_type'] ?? '';
        $event_format = $_POST['event_format'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';
        $status = $_POST['status'] ?? 'upcoming';
    

    // Get the selected club ID from the session for event creation
    $club_id = $_SESSION['SELECTEDID'] ?? 0; // Use the club_id from session

    // Assuming the user is logged in and their ID is stored in the session
     $organizer_id = $_SESSION['id']; // Use session ID as the organizer ID

    // Validate the organizer ID exists in the user table
    $user_check_query = "SELECT id FROM users WHERE id = ?";
    $stmt_check = $conn->prepare($user_check_query);
    $stmt_check->bind_param("i", $organizer_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows == 0) {
    echo "<script>alert('Invalid organizer ID. Please log in again.');</script>";
    exit;
}
$stmt_check->close();

    // Handle file upload and database insertion...
    $approval_letter = $_FILES['approval_letter']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($approval_letter);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["approval_letter"]["tmp_name"], $target_file)) {

    // Get the club name for the organizer
    $club_query = "SELECT club_name FROM clubs WHERE club_id = ?";
    $stmt_club = $conn->prepare($club_query);
    $stmt_club->bind_param("i", $club_id);
    $stmt_club->execute();
    $stmt_club->bind_result($club_name);
    $stmt_club->fetch();
    $stmt_club->close();

    // Now you have the club_name, which will be used as the organizer
    $organizer = $club_name;


    $sql = "INSERT INTO events (event_role, organizer_id, club_id, organizer, event_name, description, location, total_slots, available_slots, event_status, event_type, event_format, start_date, end_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("siissssiissssss", $event_role, $organizer_id, $club_id, $organizer, $event_name, $description, $location, $total_slots, $available_slots, $event_status, $event_type, $event_format, $start_date, $end_date, $status);

    // Execute the statement and check for success
    if ($stmt->execute()) {
    
        echo "<script>alert('Event created successfully!'); window.location.href='organizerhome.php';</script>";
    } else {
        echo "<script>alert('Error creating event: " . $stmt->error . "');</script>";
    }

    $stmt->close();
 }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventure Organizer Site</title>
    <link rel="stylesheet" href="organizercreate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-left">
            <div class="nav-right">
                <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
                <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a> 
                <span class="notification-bell">🔔</span>
                <a href="profilepage.php" class="profile-icon">
                <i class="fas fa-user-circle"></i> 
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
                <li><a href="organizerevent.php"><i class="fas fa-calendar-alt"></i>Event Hosted</a></li>
                <li><a href="organizerparticipant.php"><i class="fas fa-user-friends"></i>Participant Listing</a></li>
                <li><a href="organizercrew.php"><i class="fas fa-users"></i>Crew Listing</a></li>
                <li><a href="organizerreport.php"><i class="fas fa-chart-line"></i>Reports</a></li>
                <li><a href="organizerfeedback.php"><i class="fas fa-star"></i>Feedback</a></li>
            </ul>
            <ul style="margin-top: 60px;">
                <li><a href="organizersettings.php"><i class="fas fa-cog"></i>Settings</a></li>
                <li><a href="organizerlogout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="form-container">
        <h2>Create New Program & Event For Participant</h2>
        <p>Please fill in all the event details below.</p>
        <form method="POST" action="organizercreateeventpart.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Event Details</legend>

                <div class="form-group">
                    <label for="event_name">Event Name</label>
                    <input type="text" id="event_name" name="event_name" required>
                </div>

                <div class="form-group">
                    <label for="event_description">Description</label>
                    <textarea id="event_description" name="event_description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" required>
                </div>

                <div class="form-group">
                    <label for="total_slots">Total Slots</label>
                    <input type="number" id="total_slots" name="total_slots" required>
                </div>

                <div class="form-group">
                    <label for="event_status">Event Status</label>
                    <input type="text" id="event_status" name="event_status" value="Pending" readonly>

                </div>


                <div class="form-group">
                <label for="event_type">Event Type</label>
                <select id="event_type" name="event_type">
                    <option value="academic">Academic</option>
                    <option value="sports">Sports</option>
                    <option value="cultural">Cultural</option>
                    <option value="social">Social</option>
                    <option value="volunteer">Volunteer</option>
                    <option value="college">College</option>
                </select>
                </div>

            <div class="form-group">
                <label for="event_format">Event Format</label>
                <select id="event_format" name="event_format">
                    <option value="in-person">In-Person</option>
                    <option value="online">Online</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date of Event</label>
                <input type="datetime-local" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date of Event</label>
                <input type="datetime-local" id="end_date" name="end_date" required>
            </div>
            </fieldset>

            <fieldset>
                <legend>Additional Event Information</legend>

                <div class="form-group">
                    <label for="club_id">Club ID:</label>
                     <input type="text" id="selected_club_id" name="club_id" value="<?php echo htmlspecialchars($selected_club_id); ?>" readonly>
                </div>
             
                <div class="form-group">
                    <label for="approval_letter">Upload Approval Letter</label>
                    <input type="file" id="approval_letter" name="approval_letter" accept=".pdf,.doc,.docx" required>
                </div>

            </fieldset>

            <div class="button-group">
                <button type="submit" class="submit-button">Submit</button>
                <button type="button" class="cancel-button" onclick="window.location.href='organizerhome.php';">Cancel</button>
            </div>

        </form>
    </main>
</body>
</html>

