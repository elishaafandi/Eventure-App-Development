<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Recruitment Form</title>
    <link rel="stylesheet" href="{{ asset('css/participantform.css') }}">
</head>
<body>
<header>
    <div class="header-left">
        <a href="{{ route('participanthome') }}" class="logo">EVENTURE</a> 
        <nav class="nav-left">
            <a href="{{ route('participanthome') }}" class="{{ request()->routeIs('participanthome') ? 'active' : '' }}">Home</a>
            <a href="{{ route('participantdashboard') }}" class="{{ request()->routeIs('participantdashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="" class="{{ request()->routeIs('participantcalendar') ? 'active' : '' }}">Calendar</a>
            <a href="{{ route('profilepage') }}" class="{{ request()->routeIs('profilepage') ? 'active' : '' }}">User Profile</a>
        </nav>
    </div>
    <div class="nav-right">
        <a href="{{ route('participanthome') }}" class="participant-site">PARTICIPANT SITE</a>
        <a href="" class="organizer-site">ORGANIZER SITE</a>
        <span class="notification-bell">🔔</span>
        <div class="profile-menu">
            @if (!empty($student->student_photo))
                <img src="data:image/jpeg;base64,{{ base64_encode($student->student_photo) }}" alt="Student Photo" class="profile-icon">
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
    <h2>Update Participant Form</h2>
    <p>Update the information below.</p>
    <form method="POST" action="{{ route('editParticipant', ['event_id' => $event_id]) }}">
        @csrf

        <fieldset>
            <legend>Personal Details</legend>

            <div class="form-group">
                <label for="photo">Participant Photo</label>
                @if (!empty($student->student_photo))
                    <img src="data:image/jpeg;base64,{{ base64_encode($student->student_photo) }}" alt="Student Photo">
                @else
                    <p>No photo available</p>
                @endif
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" value="{{ $student->first_name }}" readonly>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" value="{{ $student->last_name }}" readonly>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" value="{{ $student->email }}" readonly>
            </div>

            <div class="form-group">
                <label for="ic">Identification Number</label>
                <input type="text" value="{{ $student->ic }}" readonly>
            </div>

            <div class="form-group">
                <label for="matric_no">Matric Number</label>
                <input type="text" value="{{ $student->matric_no }}" readonly>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" value="{{ $student->phone }}" readonly>
            </div>

            <div class="form-group">
                <label for="address">College Address</label>
                <input type="text" value="{{ $student->college }}" readonly>
            </div>

            <div class="form-group">
                <label for="year_course">Year/Course (in 24/25)</label>
                <input type="text" value="{{ $student->year_course }}" readonly>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <div class="gender-options">
                    <input type="radio" id="male" name="gender" value="Male" {{ $student->gender == 'Male' ? 'checked' : '' }} disabled>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" {{ $student->gender == 'Female' ? 'checked' : '' }} disabled>
                    <label for="female">Female</label>
                </div>
            </div>

            <div class="form-group">
                <label>Will you be able to attend the event?</label>
                <div class="attendance-options">
                    <input type="radio" id="yes" name="attendance" value="Yes" {{ $registration && $registration->attendance == 'Yes' ? 'checked' : '' }} required>
                    <label for="yes">Yes</label>
                    <input type="radio" id="maybe" name="attendance" value="Maybe" {{ $registration && $registration->attendance == 'Maybe' ? 'checked' : '' }} required>
                    <label for="maybe">Maybe</label>
                </div>
            </div>

            <div class="form-group">
                <label for="requirements">Special Requirements</label>
                <select id="requirements" name="requirements" required>
                    <option value="" disabled>Select one</option>
                    <option value="Meal Option" {{ $registration && $registration->requirements == 'Meal Option' ? 'selected' : '' }}>Meal Option</option>
                    <option value="Vegetarian" {{ $registration && $registration->requirements == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                    <option value="Others" {{ $registration && $registration->requirements == 'Others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>
        </fieldset>

        <div class="button-group">
            <button type="submit" class="submit-button">Submit</button>
            <button type="button" class="cancel-button" onclick="window.location.href='{{ route('participantdashboard') }}';">Cancel</button>
        </div>
    </form>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const profileMenu = document.querySelector(".profile-menu");
        const profileIcon = document.querySelector(".profile-icon");

        profileIcon.addEventListener("click", function (event) {
            event.stopPropagation();
            profileMenu.classList.toggle("open");
        });

        document.addEventListener("click", function (event) {
            if (!profileMenu.contains(event.target)) {
                profileMenu.classList.remove("open");
            }
        });
    });
</script>

</body>
</html>
