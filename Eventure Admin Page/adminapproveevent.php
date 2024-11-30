
<?php 
// Start the session
include 'config.php';
session_start();

// Check if user is logged in and role is 'Admin'
if (!isset($_SESSION['ID']) || $_SESSION['ROLE'] != 1) {
    // Redirect to login page if not an admin
    header("Location: login.php");
    exit();
}

// Query to select events with "pending" events at the top, then order by start_date
$events = $conn->query("
    SELECT * FROM events 
    ORDER BY 
        CASE WHEN event_status = 'pending' THEN 1 ELSE 2 END, 
        start_date DESC
");

// Function to search and sort if needed
function searchAndSort($query, $sortColumn = 'created_at') {
    global $conn;
    return $conn->query("SELECT * FROM {$query} ORDER BY {$sortColumn} DESC");
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventure Admin Site</title>
    <link rel="stylesheet" href="adminevent.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-left">
            <div class="nav-right">
                <span class="notification-bell">🔔</span>
                <a href="profilepage.php" class="profile-icon">
                    <i class="fas fa-user-circle"></i> 
                </a>
            </div>
        </div>
    </header>

    <main>
        <aside class="sidebar">
            <div class="logo-container">
                <a href="adminhome.php" class="logo">EVENTURE</a>
            </div>
            <ul>
                <li><a href="adminhome.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'adminhome.php' ? 'active' : ''; ?>"><i class="fas fa-home-alt"></i> Dashboard</a></li>
                <li><a href="adminadduser.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'adminadduser.php' ? 'active' : ''; ?>"><i class="fa-solid fa-user-plus"></i> Add user</a></li>
                <li><a href="adminapproveclub.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'adminapproveclub.php' ? 'active' : ''; ?>"><i class="fa-solid fa-users"></i> Club approval</a></li>
                <li><a href="adminapproveevent.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'adminapproveevent.php' ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i> Event approval</a></li>
            </ul>
            <ul style="margin-top: 60px;">
                <li><a href="logout.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : ''; ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <!-- Admin content goes here -->
            <h1>Approve/Reject Events</h1>
            <p>Manage events here.</p>
            <!-- Search and Sort functionality -->
    <div class="search-sort">
        <input type="text" id="searchInput" placeholder="Search...">
        <select id="sortSelect">
            <option value="created_at">Latest</option>
            <option value="username">Username</option>
            <option value="email">Email</option>
        </select>
    </div>

    <!-- Events Table -->
<h2>Events</h2>
<table class="data-table" id="eventsTable">
    <thead>
        <tr>
            <th>Event ID</th>
            <th>Event Name</th>
            <th>Organizer</th>
            <th>Location</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Event Status</th> <!-- Added Event Status column -->
            <th>Actions</th> <!-- Added Actions column -->
        </tr>
    </thead>
    <tbody>
        <?php while ($event = $events->fetch_assoc()): ?>
            <tr>
                <td><?= $event['event_id'] ?></td>
                <td><?= $event['event_name'] ?></td>
                <td><?= $event['organizer'] ?></td>
                <td><?= $event['location'] ?></td>
                <td><?= $event['start_date'] ?></td>
                <td><?= $event['end_date'] ?></td>
                <td><?= $event['status'] ?></td>
                <td><?= $event['event_status'] ?></td> <!-- Displaying Event Status -->
                <td>
                    <!-- View button -->
                    <a href="viewevent.php?event_id=<?= $event['event_id'] ?>" class="view-button">View</a>

                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</div>

<script>
// JavaScript for search and sort functionality
document.getElementById('searchInput').addEventListener('input', function () {
    let searchValue = this.value.toLowerCase();
    document.querySelectorAll('.data-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(searchValue) ? '' : 'none';
    });
});

document.getElementById('sortSelect').addEventListener('change', function () {
    let sortValue = this.value;
    // Call PHP backend to sort based on the selected value or use JavaScript to rearrange the rows
});
</script>
        </div>
    </main>
</body>

</html>
