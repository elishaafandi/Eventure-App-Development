<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventure</title>
    <link rel="stylesheet" href="{{(asset('build/assets/participantdashboard.css'))}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-left">
            <a href="participanthome.php" class="logo">EVENTURE</a>
            <nav class="nav-left">
                <a href="participanthome.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participanthome.php' ? 'active' : ''; ?>"></i>Home</a></li>
                <a href="{{ route('participantdashboard') }}" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participantdashboard.php' ? 'active' : ''; ?>"></i>Dashboard</a></li>
                <a href="participantcalendar.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participantcalendar.php' ? 'active' : ''; ?>"></i>Calendar</a></li>
                <a href="{{ route('profilepage') }}" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profilepage.php' ? 'active' : ''; ?>"></i>User Profile</a></li>
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
                    <a href="{{ route('profilepage') }}">Profile</a>
                    <hr>
                    <a href="{{ route('logout') }}" class="sign-out">Sign Out</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="main-content">
            <div class="event-dashboard">
                <h2>Welcome {{ $username }} !</h2>
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
                        @foreach($resultCrew as $index => $event)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ htmlspecialchars($event->event_name) }}</td>
                            <td>{{ htmlspecialchars($event->organizer) }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->created_at)->format('Y-m-d') }}</td>
                            <td>
                                @switch($event->application_status)
                                @case('applied')
                                <span class="status applied">Applied</span>
                                @break
                                @case('interview')
                                <span class="status interview">Interview</span>
                                @break
                                @case('rejected')
                                <span class="status rejected">Rejected</span>
                                @break
                                @case('pending')
                                <span class="status pending">Pending</span>
                                @break
                                @case('accepted')
                                <span class="status accepted">Accepted</span>
                                @break
                                @endswitch
                            </td>
                            <td>
                                @switch($event->status)
                                @case('upcoming')
                                <span class="status pending">Upcoming</span>
                                @break
                                @case('ongoing')
                                <span class="status interview">Ongoing</span>
                                @break
                                @case('completed')
                                <span class="status applied">Completed</span>
                                @break
                                @case('cancelled')
                                <span class="status rejected">Cancelled</span>
                                @break
                                @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
             

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

                    </tbody>
                </table>
            </div>

            <div class="event-status">
                <h2>Feedbacks Made By Organizer</h2><br>

                <!-- Crew Feedback Section -->
                <h3>Events Joined As Crew</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Event Name</th>
                            <th>Feedback</th>
                            <th>Rating</th>
                            <th>Feedback Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table><br>
            </div>

            <div class="event-status">
                <h2>Feedbacks Made By You</h2><br>

                <!-- Crew Feedback Section -->
                <h3>Events Joined As Crew</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Event Name</th>
                            <th>Feedback</th>
                            <th>Rating</th>
                            <th>Feedback Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table><br>

                <!-- Participant Feedback Section -->
                <h3>Events Joined As Participant</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Event Name</th>
                            <th>Feedback</th>
                            <th>Rating</th>
                            <th>Feedback Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>


        </section>
    </main>

    <!-- JavaScript to handle modal functionality -->
    <script>
        /// Handle Profile Icon Click
        document.addEventListener("DOMContentLoaded", function() {
            const profileMenu = document.querySelector(".profile-menu");
            const profileIcon = document.querySelector(".profile-icon");

            // Toggle dropdown on profile icon click
            profileIcon.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent event from bubbling
                profileMenu.classList.toggle("open");
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", function(event) {
                if (!profileMenu.contains(event.target)) {
                    profileMenu.classList.remove("open");
                }
            });
        });
    </script>

</body>

</html>