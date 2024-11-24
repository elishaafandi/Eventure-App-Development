<?php
// Include the config file to establish the database connection
include 'config.php';
session_start();

$user_id = $_SESSION['id'];

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in to access this page.'); window.location.href='login.php';</script>";
    exit;
}

// Build the base query
$sql = "SELECT * FROM events WHERE event_status = 'approved' AND application = 'open'";

// Initialize variables for organizer and event_type from user input
$organizer = isset($_GET['organizer']) ? trim($_GET['organizer']) : '';
$event_type = isset($_GET['event_type']) ? trim($_GET['event_type']) : '0'; // Set event_type to '0' by default

// Check if filters are applied to modify the query
$isFiltered = !empty($organizer) || ($event_type !== '0') ;

if ($isFiltered) {
    if (!empty($organizer)) {
        $sql .= " AND organizer LIKE '%" . mysqli_real_escape_string($conn, $organizer) . "%'";
    }
    if ($event_type !== '0') {
        $sql .= " AND event_type = '" . mysqli_real_escape_string($conn, $event_type) . "'";
    }
}

// Always order by start date
$sql .= " ORDER BY start_date ASC";

// Execute the query
$result = mysqli_query($conn, $sql);

$events = [];
if ($result) {
    // Fetch all rows as an associative array
    $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>www.eventureutm.com</title>
    <link rel="stylesheet" href="participanthome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="participanthome.php" class="logo">EVENTURE</a> 
            <nav class="nav-left">
                <a href="participanthome.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participanthome.php' ? 'active' : ''; ?>"></i>Home</a>
                <a href="participantdashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participantdashboard.php' ? 'active' : ''; ?>"></i>Dashboard</a>
                <a href="participantcalendar.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participantcalendar.php' ? 'active' : ''; ?>"></i>Calendar</a>
                <a href="profilepage.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profilepage.php' ? 'active' : ''; ?>"></i>User Profile</a>
            </nav>
        </div>
        <div class="nav-right">
            <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
            <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a> 
            <span class="notification-bell">🔔</span>
        </div>
    </header>

    <main>
        <div class="search-section">
            <h1>Find Your Event!</h1>
            <form method="GET" action="participanthome.php" class="search-bar">
                <input type="text" name="organizer" placeholder="Enter Club Name" value="<?php echo htmlspecialchars($organizer); ?>">
                <select name="event_type">
                    <option value="0" <?php echo $event_type === '0' ? 'selected' : ''; ?>>Choose Category</option>
                    <option value="sports" <?php echo $event_type === '1' ? 'selected' : ''; ?>>Sports</option>
                    <option value="volunteer" <?php echo $event_type === '2' ? 'selected' : ''; ?>>Volunteer</option>
                    <option value="academic" <?php echo $event_type === '3' ? 'selected' : ''; ?>>Academic</option>
                    <option value="social" <?php echo $event_type === '4' ? 'selected' : ''; ?>>Social</option>
                    <option value="cultural" <?php echo $event_type === '5' ? 'selected' : ''; ?>>Cultural</option>
                    <option value="college" <?php echo $event_type === '6' ? 'selected' : ''; ?>>College</option>
                    <option value="7" <?php echo $event_type === '7' ? 'selected' : ''; ?>>Uniform Bodies</option>
                </select>
                <button type="submit" class="search-button"><i class="fas fa-search"></i> Search</button>
                <button type="button" onclick="clearSearch()" class="clear-button"><i class="fas fa-times"></i> Clear Search</button>
            </form>
        </div>

    <main class="main-content">
    <aside class="filter-section">
        <h3>Filter Event <span class="clear-all">Clear all</span></h3>
        <div class="filter-option">
            <label for="date-post">Date Post</label>
            <select id="date-post">
                <option value="anytime">Anytime</option>
                <option value="last-week">Last Week</option>
                <option value="this-month">This Month</option>
            </select>
        </div>
        <div class="filter-option">
            <label>Location</label>
            <label><input type="checkbox" class="location-filter" value="on-campus"> On-Campus</label>
            <label><input type="checkbox" class="location-filter" value="off-campus"> Off-Campus</label>
        </div>
        <div class="filter-option">
            <label>Role</label>
            <label><input type="checkbox" class="role-filter" value="crew"> Crew Committee</label>
            <label><input type="checkbox" class="role-filter" value="participant"> Participant</label>
        </div>
        <div class="filter-option">
            <label>Format</label>
            <label><input type="checkbox" class="format-filter" value="in-person"> In-Person</label>
            <label><input type="checkbox" class="format-filter" value="online"> Online</label>
        </div>
        <button id="filter-btn">Apply Filters</button>
    </aside>

        <section class="event-list">
            <?php if ($isFiltered): ?>
                <p><?php echo count($events); ?> results found</p>
            <?php else: ?>
                <p>Showing all events</p>
            <?php endif; ?>

            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <div class="event-header">
                        <div class="event-title-organizer">
                            <h2><?php echo htmlspecialchars($event['event_name']); ?></h2>
                            <span class="event-organizer"><?php echo htmlspecialchars($event['organizer']); ?></span>
                        </div>
                        <div class="event-icons">
                            <button class="notification-button"><i class="fas fa-bell"></i></button>
                            <button class="heart-button"><i class="fas fa-heart"></i></button>
                        </div>
                    </div>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <div class="event-footer">
                        <span class="event-location"><?php echo htmlspecialchars($event['location']); ?></span>
                        <span class="event-role"><?php echo htmlspecialchars($event['event_role']); ?></span>
                        <span class="event-status"><?php echo htmlspecialchars($event['status']); ?></span>
                        <div class="event-buttons">
                            <button class="find-out-more-button"
                            data-event-id="<?php echo htmlspecialchars($event['event_id']); ?>"
                            data-title="<?php echo htmlspecialchars($event['event_name']); ?>" 
                            data-organizer="<?php echo htmlspecialchars($event['organizer']); ?>" 
                            data-date="<?php echo date("d/m/Y", strtotime($event['start_date'])); ?>" 
                            data-time="<?php echo date("H:i", strtotime($event['start_date'])); ?>" 
                            data-location="<?php echo htmlspecialchars($event['location']); ?>" 
                            data-description="<?php echo htmlspecialchars($event['description']); ?>" 
                            data-role="<?php echo htmlspecialchars($event['event_role']); ?>"  
                            data-total-slots="<?php echo htmlspecialchars($event['total_slots']); ?>"
                            data-available-slots="<?php echo htmlspecialchars($event['available_slots']); ?>"
                            data-event-status="<?php echo htmlspecialchars($event['status']); ?>"
                            data-event-type="<?php echo htmlspecialchars($event['event_type']); ?>"
                            data-event-format="<?php echo htmlspecialchars($event['event_format']); ?>"
                            data-created-at="<?php echo date("d/m/Y H:i", strtotime($event['created_at'])); ?>">
                            Find Out More
                            </button>
                            <button class="join-button" 
                            data-role="<?php echo htmlspecialchars($event['event_role']); ?>" 
                            data-event-id="<?php echo htmlspecialchars($event['event_id']); ?>">
                            Join Event
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
 <!-- Modal Structure for Event Details -->
 <div id="eventModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div id="modal-details">
            <h1 id="modal-title"><?php echo isset($event['event_name']) ? htmlspecialchars($event['event_name']) : ''; ?></h1>
            <p><strong>Organizer:</strong> <span id="modal-organizer"><?php echo isset($event['organizer']) ? htmlspecialchars($event['organizer']) : ''; ?></span></p>
            <p><strong>Date:</strong> <span id="modal-date"><?php echo isset($event['start_date']) ? date("d/m/Y", strtotime($event['start_date'])) : ''; ?></span></p>
            <p><strong>Time:</strong> <span id="modal-time"><?php echo isset($event['start_date']) ? date("H:i", strtotime($event['start_date'])) : ''; ?></span></p>
            <p><strong>Location:</strong> <span id="modal-location"><?php echo isset($event['location']) ? htmlspecialchars($event['location']) : ''; ?></span></p>
            <p><strong>Description:</strong> <span id="modal-description"><?php echo isset($event['description']) ? htmlspecialchars($event['description']) : ''; ?></span></p>
            <p><strong>Total Slots:</strong> <span id="modal-total-slots"><?php echo isset($event['total_slots']) ? htmlspecialchars($event['total_slots']) : ''; ?></span></p>
            <p><strong>Available Slots:</strong> <span id="modal-available-slots"><?php echo isset($event['available_slots']) ? htmlspecialchars($event['available_slots']) : ''; ?></span></p>
            <p><strong>Status:</strong> <span id="modal-event-status"><?php echo isset($event['status']) ? htmlspecialchars($event['status']) : ''; ?></span></p>
            <p><strong>Event Type:</strong> <span id="modal-event-type"><?php echo isset($event['event_type']) ? htmlspecialchars($event['event_type']) : ''; ?></span></p>
            <p><strong>Format:</strong> <span id="modal-event-format"><?php echo isset($event['event_format']) ? htmlspecialchars($event['event_format']) : ''; ?></span></p>
                <div class="event-actions">
                    <button class="register-button" 
                        data-role="<?php echo isset($event['event_role']) ? htmlspecialchars($event['event_role']) : ''; ?>">
                        Register Now
                    </button>
                    <button class="view-participant-button">View Participant</button>
                </div>
            </div>
        </div>
    </div>

<!-- JavaScript to handle modal functionality -->
<script>
        function clearSearch() {
    // Clear input fields
    document.querySelector('input[name="organizer"]').value = '';
    document.querySelector('select[name="event_type"]').value = '0';
    // Submit the form to refresh and show all events
    document.querySelector('.search-bar').submit();
}

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('eventModal');
            const closeButton = document.querySelector('.close-button');

            // Function to open modal
            function openModal(eventData) {
                document.getElementById('modal-title').textContent = eventData.title;
                document.getElementById('modal-organizer').textContent = eventData.organizer;
                document.getElementById('modal-date').textContent = eventData.date;
                document.getElementById('modal-time').textContent = eventData.time;
                document.getElementById('modal-location').textContent = eventData.location;
                document.getElementById('modal-description').textContent = eventData.description;
                document.querySelector('.register-button').setAttribute('data-role', eventData.role); // Set the role attribute
                document.querySelector('.register-button').setAttribute('data-event-id', eventData.eventId); // Set the event_id attribute

                modal.style.display = 'flex'; // Set to flex to enable centering
            }

            // Event listener to close modal
            closeButton.onclick = function () {
                modal.style.display = 'none';
            };

            // Close modal when clicking outside of it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };

            // Attach click event to each "Find Out More" button
            document.querySelectorAll('.find-out-more-button').forEach(button => {
                button.addEventListener('click', function () {
                    const eventData = {
                        title: button.getAttribute('data-title'),
                        organizer: button.getAttribute('data-organizer'),
                        date: button.getAttribute('data-date'),
                        time: button.getAttribute('data-time'),
                        location: button.getAttribute('data-location'),
                        description: button.getAttribute('data-description'),
                        role: button.getAttribute('data-role'), // Get role from button
                        eventId: button.getAttribute('data-event-id') // Get event_id from button
                    };
                    openModal(eventData);
                });
            });

            // Event listener for register button
            document.querySelector('.register-button').addEventListener('click', function () {
                const role = this.getAttribute('data-role').trim();
                const eventId = this.getAttribute('data-event-id'); // Get the event_id
                if (role === 'Crew') {
                    window.location.href = `crewform.php?event_id=${eventId}`; // Redirect to crew form
                } else {
                    window.location.href = `participantform.php?event_id=${eventId}`; // Redirect to participant registration
                }
            });

            document.querySelectorAll('.join-button').forEach(button => {
            button.addEventListener('click', function () {
                const role = this.getAttribute('data-role').trim();
                const eventId = this.getAttribute('data-event-id'); // Get the event_id
                if (role === 'Crew') {
                    window.location.href = `crewform.php?event_id=${eventId}`; // Redirect to crew form
                } else {
                    window.location.href = `participantform.php?event_id=${eventId}`; // Redirect to participant registration
                }
            });
        });
    });

    </script>
</body>
</html>
s