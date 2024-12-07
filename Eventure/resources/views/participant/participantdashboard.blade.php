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
                        @if ($resultCrew->isNotEmpty())
                        @php $no = 1; @endphp
                        @foreach ($resultCrew as $event)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->organizer }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->created_at)->format('Y-m-d') }}</td>
                            <td>
                                @if ($event->application_status == 'applied')
                                <span class="status applied">Applied</span>
                                @elseif ($event->application_status == 'interview')
                                <span class="status interview">Interview</span>
                                @elseif ($event->application_status == 'rejected')
                                <span class="status rejected">Rejected</span>
                                @elseif ($event->application_status == 'pending')
                                <span class="status pending">Pending</span>
                                @elseif ($event->application_status == 'accepted')
                                <span class="status accepted">Accepted</span>
                                @endif
                            </td>
                            <td>
                                @if ($event->status == 'upcoming')
                                <span class="status pending">Upcoming</span>
                                @elseif ($event->status == 'ongoing')
                                <span class="status interview">Ongoing</span>
                                @elseif ($event->status == 'completed')
                                <span class="status applied">Completed</span>
                                @elseif ($event->status == 'cancelled')
                                <span class="status rejected">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <!-- View button -->
                                <a href="{{ route('participantviewcrew', ['event_id' => $event->event_id]) }}" class="btn view">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                <!-- Edit button enabled only if application status is 'pending' or 'applied' and event status is 'upcoming' or 'ongoing' -->
                                <a href="{{ route('editCrew', ['event_id' => $event->event_id])}}"
                                    class="btn edit {{ (in_array($event->application_status, ['pending', 'applied']) && in_array($event->status, ['upcoming', 'ongoing'])) ? '' : 'disabled' }}"
                                    {{ (in_array($event->application_status, ['pending', 'applied']) && in_array($event->status, ['upcoming', 'ongoing'])) ? '' : 'onclick="return false;"' }}>
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Cancel button enabled only if application status is 'pending' or 'applied' and event status is 'upcoming' or 'ongoing' -->
                                <!-- The Link (A tag) -->
                                <a href="#"
                                    class="btn delete {{ (in_array($event->application_status, ['pending', 'applied']) && in_array($event->status, ['upcoming', 'ongoing'])) ? '' : 'disabled' }}"
                                    onclick="event.preventDefault(); 
                                    if(confirm('Are you sure you want to cancel this application?')) {
                                        document.getElementById('delete-form-{{ $event->event_id }}').submit();
                                    }">
                                    <i class="fas fa-trash-alt"></i> Cancel
                                </a>

                                <!-- Hidden Form for POST request -->
                                <form id="delete-form-{{ $event->event_id }}" action="{{ route('deleteCrew', ['event_id' => $event->event_id]) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="crew_id" value="{{ $event->crew_id }}">
                                </form>



                                <a href="{{ route('feedback.event', ['eventId' => $event->event_id, 'clubId' => $event->club_id]) }}"
                                    class="btn rate {{ $event->status == 'completed' ? '' : 'disabled' }}">
                                    <i class="fas fa-star"></i> Rate
                                </a>




                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7">You have not registered for any crew events yet.</td>
                        </tr>
                        @endif


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
                        @if ($resultParticipant->isNotEmpty())
                        @php $no = 1; @endphp
                        @foreach ($resultParticipant as $event)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->organizer }}</td>
                            <td>{{ $event->created_at }}</td>
                            <td>
                                @if ($event->registration_status == 'registered')
                                <span class="status accepted">Registered</span>
                                @elseif ($event->registration_status == 'cancelled')
                                <span class="status rejected">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                @if ($event->status == 'upcoming')
                                <span class="status pending">Upcoming</span>
                                @elseif ($event->status == 'ongoing')
                                <span class="status interview">Ongoing</span>
                                @elseif ($event->status == 'completed')
                                <span class="status applied">Completed</span>
                                @elseif ($event->status == 'cancelled')
                                <span class="status rejected">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('participantviewparticipant', ['event_id' => $event->event_id]) }}" class="btn view">
                                    <i class="fas fa-eye"></i> View</a>

                                <a href="{{ route('editParticipant', ['event_id' => $event->event_id])}}"
                                    class="btn edit {{ $event->registration_status != 'registered' ? 'disabled' : '' }}"
                                    {{ $event->registration_status != 'registered' ? 'onclick="return false;"' : '' }}>
                                    <i class="fas fa-edit"></i>Edit
                                </a>


                                <a href="#"
                                    class="btn delete {{ $event->registration_status != 'registered' ? 'disabled' : '' }}"
                                    onclick="event.preventDefault(); 
                                        if(confirm('Are you sure you want to delete this application?')) {
                                            document.getElementById('delete-form-{{ $event->event_id }}').submit();
                                        }">
                                    <i class="fas fa-trash-alt"></i> Cancel
                                </a>

                                <!-- Hidden Form for POST request -->
                                <form id="delete-form-{{ $event->event_id }}" action="{{ route('deleteParticipant', $event->event_id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>


                                <!-- Rate button enabled only if event status is 'completed' -->
                                <a href="{{ route('feedback.form', ['eventId' => $event->event_id, 'clubId' => $event->club_id]) }}"
                                    class="btn rate {{ $event->status == 'completed' ? '' : 'disabled' }}"
                                    {{ $event->status == 'completed' ? '' : 'onclick="return false;"' }}>
                                    <i class="fas fa-star"></i> Rate
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7">You have not registered for any events yet.</td>
                        </tr>
                        @endif
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
                        @forelse ($feedback_organizer_crew as $index => $feedback)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Display serial number -->
                            <td>{{ $feedback->event_name }}</td>
                            <td>{{ $feedback->feedback }}</td>
                            <td>{{ $feedback->rating }}</td>
                            <td>{{ $feedback->feedback_date }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No feedback available</td>
                        </tr>
                        @endforelse
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
                        @forelse ($feedback_crew as $index => $feedback)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Display serial number -->
                            <td>{{ $feedback->event_name }}</td>
                            <td>{{ $feedback->feedback }}</td>
                            <td>{{ $feedback->rating }}</td>
                            <td>{{ $feedback->feedback_date }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No feedback available</td>
                        </tr>
                        @endforelse
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
                        @forelse ($feedback_participant as $index => $feedback)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Display serial number -->
                            <td>{{ $feedback->event_name }}</td>
                            <td>{{ $feedback->feedback }}</td>
                            <td>{{ $feedback->rating }}</td>
                            <td>{{ $feedback->feedback_date }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No feedback available</td>
                        </tr>
                        @endforelse
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