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

// Query to select clubs with "pending" clubs at the top, then order by founded_date
$clubs = $conn->query("
    SELECT * FROM clubs 
    ORDER BY 
        CASE WHEN club_status = 'pending' THEN 1 ELSE 2 END, 
        founded_date DESC
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
            <h1>Approve/Reject Clubs</h1>
            <p>Manage clubs here.</p>
            <!-- Search and Sort functionality -->
            <div class="search-sort">
                <input type="text" id="searchInput" placeholder="Search...">
                <select id="sortSelect">
                    <option value="created_at">Latest</option>
                    <option value="club_name">Club Name</option>
                    <option value="president_id">President</option>
                </select>
            </div>

            <!-- Clubs Table -->
            <h2>Clubs</h2>
            <table class="data-table" id="clubsTable">
                <thead>
                    <tr>
                        <th>Club ID</th>
                        <th>Club Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Founded Date</th>
                        <th>Status</th>
                        <th>Club Status</th> <!-- Added Club Status column -->
                        <th>Actions</th> <!-- Added Actions column -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($club = $clubs->fetch_assoc()): ?>
                        <tr>
                            <td><?= $club['club_id'] ?></td>
                            <td><?= $club['club_name'] ?></td>
                            <td><?= $club['description'] ?></td>
                            <td><?= $club['club_type'] ?></td>
                            <td><?= $club['founded_date'] ?></td>
                            <td><?= $club['club_status'] ?></td>
                            <td><?= $club['club_status'] ?></td> <!-- Displaying Club Status -->
                            <td>
                                <!-- View button -->
                                <a href="viewclub.php?club_id=<?= $club['club_id'] ?>" class="view-button">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

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

</body>

</html>
