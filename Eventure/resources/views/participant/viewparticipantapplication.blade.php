<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Recruitment Form</title>
    <link rel="stylesheet" href="{{ asset('css/viewapplicationdetails.css') }}">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="{{ route('participanthome') }}" class="logo">EVENTURE</a> 
            <nav class="nav-left">
                <a href="{{ route('participanthome') }}" class="active">Home</a>
                <a href="#">Calendar</a>
                <a href="#">User Profile</a>
                <a href="#">Dashboard</a>
            </nav>
        </div>
        <div class="nav-right">
            <a href="#" class="participant-site">PARTICIPANT SITE</a>
            <a href="#" class="organizer-site">ORGANIZER SITE</a>
            <span class="notification-bell">🔔</span>
            <div class="profile-menu">
                <!-- Display profile image -->
                @if (!empty($student->student_photo))
                    <img src="data:image/jpeg;base64,{{ base64_encode($student->student_photo) }}" alt="Student Photo" class="profile-icon">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile" class="profile-icon">
                @endif

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
        <section>
            <h2>Participant Application Details</h2>
            <p><strong>Participant ID:</strong> {{ $student->participant_id }}</p>
            <p><strong>Full Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Identification Number:</strong> {{ $student->ic }}</p>
            <p><strong>Matric Number:</strong> {{ $student->matric_no }}</p>
            <p><strong>Phone:</strong> {{ $student->phone }}</p>
            <p><strong>College Address:</strong> {{ $student->college }}</p>
            <p><strong>Year/Course (24/25):</strong> {{ $student->year_course }}</p>
            <p><strong>Gender:</strong> {{ $student->gender }}</p>
            <p><strong>Special Requirements:</strong> {{ $student->requirements }}</p>
        </section>
        
        <section>
            <h2>Event Application Details</h2>
            <p><strong>Event ID:</strong> {{ $event->event_id }}</p>
            <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
            <p><strong>Organizer:</strong> {{ $event->organizer }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
        </section>
        
        <button onclick="window.location.href='{{ route('participantdashboard') }}';">Back</button>
    </main>

<!-- JavaScript to handle modal functionality -->
<script>
   // Handle Profile Icon Click
   document.addEventListener("DOMContentLoaded", function () {
       const profileMenu = document.querySelector(".profile-menu");
       const profileIcon = document.querySelector(".profile-icon");
   
       // Toggle dropdown on profile icon click
       profileIcon.addEventListener("click", function (event) {
           event.stopPropagation(); // Prevent event from bubbling
           profileMenu.classList.toggle("open");
       });
   
       // Close dropdown when clicking outside
       document.addEventListener("click", function (event) {
           if (!profileMenu.contains(event.target)) {
               profileMenu.classList.remove("open");
           }
       });
   });
</script>

</body>
</html>
