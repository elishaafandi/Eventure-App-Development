<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Listing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="organizerparticipant.css">
</head>
<body>
    <header>
        <h1>Participant Listing</h1>
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
                <li><a href="organizerhome.php">Dashboard</a></li>
                <li><a href="organizerevent.php">Event Hosted</a></li>
                <li><a href="organizerparticipant.php" class="active">Participant Listing</a></li>
                <li><a href="organizercrew.php">Crew Listing</a></li>
                <li><a href="organizerreport.php">Reports</a></li>
                <li><a href="organizerfeedback.php">Feedback</a></li>
            </ul>
            <ul style="margin-top: 60px;">
                <li><a href="organizersettings.php">Settings</a></li>
                <li><a href="organizerlogout.php">Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="event-info">
                <div class="event-header">
                    <div class="event-details">
                        <h2>CGMA MPC'24 CREW</h2>
                        <p>Post Ends: 16 Oct 2024 </p>
                        <p>Program Date: 24 Oct 2024</p>
                        <p>Location: New York Hotel, Johor Bahru </p>
                        <p>Farewell Dinner for 4th-year Computer Graphics Student</p>
                        <p>Performance and Prize Giving Ceremony</p>
                        <p>Photo and Video Montage</p>
                    </div>
                    <div class="event-buttons">
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </div>
            </div>

            <div class="search-filter-container">
                <input type="text" class="search-bar" placeholder="Search participants...">
                <div class="filter-container">
                    <label for="participant-filter">Filter by Status:</label>
                    <select id="participant-filter">
                        <option value="all">All</option>
                        <option value="attend">Attend</option>
                        <option value="absent">Absent</option>
                    </select>
                </div>
            </div>

            <script>
                // JavaScript to handle crew filtering
                document.addEventListener("DOMContentLoaded", () => {
                const participantFilter = document.getElementById("participant-filter");
                const participantList = document.querySelectorAll(".participant-member");

                // Event listener for filter dropdown
                participantFilter.addEventListener("change", () => {
                const filterValue = participantFilter.value;

                participantList.forEach((row) => {
                    if (filterValue === "all") {
                    row.style.display = ""; // Show all rows
                } else if (row.dataset.status === filterValue) {
                    row.style.display = ""; // Show matching rows
                } else {
                    row.style.display = "none"; // Hide non-matching rows
                }
            });
        });
    });
            </script>

            <!-- Participant Applications Table -->
            <h3 class="application-heading">Participant Applications</h3>
            <table class="participant-table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Name</th>
                        <th>IC Number</th>
                        <th>Mobile Number</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Attendance Status </th>
                        <th>Special Requirements</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="participant-member">
                        <td><input type="checkbox" class="participant-checkbox"></td>
                        <td>Alicia Tan</td>
                        <td>001-23-3456</td>
                        <td>0172234567</td>
                        <td>alicia@example.com</td>
                        <td>15 October 2024</td>
                        <td>Attend </td>
                        <td>Meal Option</td>
                    </tr>
                    <tr class="participant-member">
                        <td>Daniel Lim</td> 
                        <td>560721-02-3456</td>
                        <td>0192234567</td>
                        <td>daniel@example.com</td>
                        <td>10 October 2024</td>
                        <td>Absent </td>
                        <td>Vegetarian</td>
                    </tr>
                    
                </tbody>
            </table>

            <!-- Action Buttons -->
            <div class="action-container">
                <button class="attend-btn">Attend</button>
                <button class="absent-btn">Absent</button>
            </div>
        </div>
    </main>
</body>
</html>
