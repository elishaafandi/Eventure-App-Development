<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventure Organizer Site</title>
    <link rel="stylesheet" href="{{ asset('build/assets/Homepage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-left">
            <div class="nav-right">
                <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
                <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a>
                <span class="notification-bell">🔔</span>
                <a href="{{ route('profilepage') }}" class="profile-icon">
                    <i class="fas fa-user-circle"></i>
                </a>
            </div>
        </div>

        <div class="header-center">
            <div class="welcome-section">
                <h2>Welcome Back, !</h2>
                <form>
                    <select name="club_id" class="club-role-dropdown" onchange="updateEvents(this.value)">
                        <option value="" selected >Select Club</option>
                        @foreach ($clubs as $club)
                        <option value="{{ $club->club_id }}"
                            {{ $selected_club_id == $club->club_id ? 'selected' : '' }}>
                            {{ $club->club_name }}
                        </option>
                        @endforeach
                    </select>
                
                <a class="add-club-button">Add Club</a>
                </form>

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
                <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <section class="main-content">

            <div class="create-event-section">
                <h2>Create New Program & Event</h2>
                <p>Elevate your membership status and indulge in rewards of luxury and exclusivity.</p>
                <a href="organizercreateeventcrew.php">
                    <div class="pill">For Crew</div>
                </a>
                <a href="organizercreateeventpart.php">
                    <div class="pill">For Participant</div>
                </a>
            </div>

            <div class="event-status">
                <h3>Event Status</h3>
                <table>
                    <thead>
                        <tr>
                            <!-- <th>Event Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Participants</th>
                            <th>Event Status</th>
                            <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <div id="eventsList">

                        </div>

                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>


<script>
    function updateEvents(clubId) {
        // Send AJAX request to fetch events for the selected club
        fetch(`{{ route('organizer') }}?club_id=` + clubId)
            .then(response => response.json())
            .then(data => {
                // Update the events table
                let eventsTable = `<table><thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Participants</th>
                                        <th>Event Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead><tbody>`;

                if (data.events.length === 0) {
                    eventsTable += `<tr><td colspan="6" style="text-align: center;">No events found for the selected club.</td></tr>`;
                } else {
                    data.events.forEach(event => {
                        eventsTable += `<tr>
                                            <td>${event.event_name}</td>
                                            <td>${new Date(event.start_date).toLocaleDateString()}</td>
                                            <td>${new Date(event.end_date).toLocaleDateString()}</td>
                                            <td>${event.participants}</td>
                                            <td>${event.event_status}</td>
                                            <td><a href="/event/details/${event.event_id}">View Details</a></td>
                                          </tr>`;
                    });
                }

                eventsTable += `</tbody></table>`;

                // Insert the updated table into the events section
                document.getElementById("eventsList").innerHTML = eventsTable;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>