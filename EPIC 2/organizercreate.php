<?php
include 'config.php';

// Check if club_id is set in the session
if (!isset($_SESSION["club_id"])) {
    // Redirect to homepage  if club_id is missing
    header("Location: organizerhome.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_role = $_POST['event_role'] ?? '';
    $organizer_id = $_POST['organizer_id'] ?? 0;
    $club_id = $_POST['club_id'] ?? 0;
    $organizer = $_POST['organizer'] ?? '';
    $event_name = $_POST['event_name'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $total_slots = $_POST['total_slots'] ?? 0;
    $available_slots = $_POST['available_slots'] ?? 0;
    $event_status = $_POST['event_status'] ?? 'pending';
    $event_type = $_POST['event_type'] ?? '';
    $event_format = $_POST['event_format'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $status = $_POST['status'] ?? 'upcoming';

    $sql = "INSERT INTO event (event_role, organizer_id, club_id, organizer, event_name, description, location, total_slots, available_slots, event_status, event_type, event_format, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $selected_club_id = htmlspecialchars($_SESSION["SELECTEDID"]);


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
        <h2>Create New Program & Event</h2>
        <p>Please fill in all the event details below.</p>
        <form method="POST" action="organizercreate.php">
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
                <select id="event_status" name="event_status">
                    <option value="pending">Pending</option>
                </select>
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
                    <input type="text" id="selected_club_id" name="club id" value="<?php echo htmlspecialchars($_SESSION['SELECTEDID']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="approval_letter">Upload Approval Letter</label>
                    <input type="file" id="approval_letter" name="approval_letter" accept=".pdf,.doc,.docx" required>
                </div>

                <div class="form-group">
                    <label>Select Crew Roles</label>
                    <label><input type="checkbox" name="crew_roles[]" value="protocol"> Protocol</label>
                    <label><input type="checkbox" name="crew_roles[]" value="technical"> Technical</label>
                    <label><input type="checkbox" name="crew_roles[]" value="gift"> Gift</label>
                    <label><input type="checkbox" name="crew_roles[]" value="food"> Food</label>
                    <label><input type="checkbox" name="crew_roles[]" value="special_task"> Special Task</label>
                    <label><input type="checkbox" name="crew_roles[]" value="multimedia"> Multimedia</label>
                    <label><input type="checkbox" name="crew_roles[]" value="sponsorship"> Sponsorship</label>
                    <label><input type="checkbox" name="crew_roles[]" value="documentation"> Documentation</label>
                    <label><input type="checkbox" name="crew_roles[]" value="transportation"> Transportation</label>
                    <label><input type="checkbox" name="crew_roles[]" value="activity"> Activity</label>
                </div>
            </fieldset>

            <div class="button-group">
                <button type="submit" class="submit-button" onclick="window.location.href='eventcreateconfirmation.php';">Submit</button>
                <button type="button" class="cancel-button" onclick="window.location.href='organizerhome.php';">Cancel</button>
            </div>

        </form>
    </main>
</body>
</html>
