<?php
session_start();

// Check if club_id is set in the session
if (!isset($_SESSION["club_id"])) {
    // Redirect to homepage  if club_id is missing
    header("Location: organizerhome.php");
    exit;
}

// Retrieve club information from the session
$club_id = htmlspecialchars($_SESSION["club_id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventure Organizer Site</title>
    <link rel="stylesheet" href="organizerhome.css">
</head>
<body>
    <header>
    <div class="header-left">
            <a href="participanthome.php" class="logo">EVENTURE</a> 
            <nav class="nav-left">
                <a href="participanthome.php" class="active">Home</a>
                <a href="#">Calendar</a>
                <a href="#">User Profile</a>
                <a href="#">Dashboard</a>
            </nav>
        </div>
        <div class="nav-right">
            <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
            <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a> 
            <span class="notification-bell">🔔</span>
        </div>
    </header>

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

    <main>
        <section class="main-content">
            <div class="middle" style="background-color:#ffffff;">
                <div class="confirmation-message">
                    <img src="tick.jpeg" alt="Confirmation"> 
                    <h2>Create Event Confirmed</h2>
                    <p>Thank you, Club ID <?php echo $club_id; ?>. Your Event has been Created.</p>
                    <p>Please view your event status <a href="viewstatus.php">here</a>.</p>
                    <p>Click <a href="organizerhome.php">here</a> to return to the dashboard.</p>
                </div>
            </div>
        </section>
     </aside>
   </main>
</body>
</html>
