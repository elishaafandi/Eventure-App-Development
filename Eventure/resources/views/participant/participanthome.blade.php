<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Eventure') }}</title>
    <link rel="stylesheet" href="{{ asset('build/assets/participanthome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="{{ route('participanthome') }}" class="logo">EVENTURE</a> 
            <nav class="nav-left">
                <a href="{{ route('participanthome') }}" class="{{ request()->routeIs('participanthome') ? 'active' : '' }}">Home</a>
                <a href="" class="{{ request()->routeIs('participantdashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="" class="{{ request()->routeIs('participantcalendar') ? 'active' : '' }}">Calendar</a>
                <a href="{{ route('profilepage') }}" class="{{ request()->routeIs('profilepage') ? 'active' : '' }}">User Profile</a>
            </nav>
        </div>
        <div class="nav-right">
            <a href="{{ route('participanthome') }}" class="participant-site">PARTICIPANT SITE</a>
            <a href="" class="organizer-site">ORGANIZER SITE</a> 
            <span class="notification-bell">🔔</span>
            <div class="profile-menu">
                <!-- Ensure the profile image is fetched and rendered properly -->
                @if (!empty($student['student_photo']))
                    <img src="data:image/jpeg;base64,{{ base64_encode($student['student_photo']) }}" alt="Student Photo" class="profile-icon">
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

<script>
    /// Handle Profile Icon Click
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

