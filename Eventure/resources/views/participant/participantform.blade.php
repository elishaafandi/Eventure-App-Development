<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Recruitment Form</title>
    <link rel="stylesheet" href="{{ asset('build/assets/participantform.css') }}">
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
        <a href="{{ route('Homepage') }}" class="organizer-site">ORGANIZER SITE</a>
        <span class="notification-bell">🔔</span>
        <div class="profile-menu">
            @if (!empty($students->photo))
                <img src="{{ asset('storage/' . $students->photo) }}" alt="User Photo" class="profile-icon">
            @else
                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile" class="profile-icon">
            @endif

            <div class="dropdown-menu">
                <a href="{{ route('profilepage') }}">Profile</a>
                <hr>
                <a href="{{ route('logout') }}" class="sign-out">Sign Out</a>
            </div>
        </div>
    </div>
</header>

<main class="form-container">
    <h2>Participant Form</h2>
    <p>Please fill in all the information below.</p>
    <form method="POST" action="{{ route('participantform.submit') }}">
        @csrf
        <input type="hidden" name="event_id" value="{{ request('event_id', '') }}">
        
        <fieldset>
            <legend>Personal Details</legend>

            <div class="form-group">
                <label for="photo">Crew Photo</label>
                @if (!empty($students->photo))
                    <img src="{{ asset('storage/' . $students->photo) }}" alt="User Photo">
                @else
                    <p>No photo available</p>
                @endif
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" value="{{ $students->first_name }}" readonly>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" value="{{ $students->last_name }}" readonly>
            </div>

            <div class="form-group">
                <label for="ic">Identification Number</label>
                <input type="text" value="{{ $students->ic }}" readonly>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" value="{{ $students->email }}" readonly>
            </div>

            <div class="form-group">
                <label for="matric_no">Matric Number</label>
                <input type="text" value="{{ $students->matric_no }}" readonly>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" value="{{ $students->phone }}" readonly>
            </div>

            <div class="form-group">
                <label for="address">College Address</label>
                <input type="text" value="{{ $students->college }}" readonly>
            </div>

            <div class="form-group">
                <label for="year_course">Year/Course (in 24/25)</label>
                <input type="text" value="{{ $students->year_course }}" readonly>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <div class="gender-options">
                    <input type="radio" id="male" name="gender" value="Male" {{ $students->gender == 'Male' ? 'checked' : '' }} disabled>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" {{ $students->gender == 'Female' ? 'checked' : '' }} disabled>
                    <label for="female">Female</label>
                </div>
            </div>

            <div class="form-group">
                    <label>Will you be able to attend the event?</label>
                    <div class="attendance-options">
                        <input type="radio" id="yes" name="attendance" value="Yes" required>
                        <label for="male">Yes</label>
                        <input type="radio" id="maybe" name="attendance" value="Maybe" required>
                        <label for="female">Maybe</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="requirements">Special Requirements</label>
                    <select id="requirements" name="requirements" required>
                        <option value="">Select one</option>
                        <option value="Meal Option">Meal Options</option>
                        <option value="Vegetarian">Vegetarian</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
        </fieldset>

        <div class="button-group">
            <button type="submit" class="submit-button">Submit</button>
            <button type="button" class="cancel-button" onclick="window.location.href='{{ route('participanthome') }}';">Cancel</button>
        </div>
    </form>
</main>

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
