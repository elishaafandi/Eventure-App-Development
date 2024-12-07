
<header>
    <div class="header-left">
        <a href="" class="logo">EVENTURE</a> 
        <nav class="nav-left">
            <a href="{{ route('Homepage') }}" class="{{ request()->routeIs('participant.home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('participantdashboard') }}" class="{{ request()->routeIs('participant.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="" class="{{ request()->routeIs('participant.calendar') ? 'active' : '' }}">Calendar</a>
            <a href="{{ route('profilepage') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">User Profile</a>
        </nav>
    </div>
    <div class="nav-right">
        <a href="" class="participant-site">PARTICIPANT SITE</a>
        <a href="" class="organizer-site">ORGANIZER SITE</a> 
        <span class="notification-bell">🔔</span>
        <div class="profile-menu">
            @if($student->student_photo)
                <img src="{{ 'data:image/jpeg;base64,' . base64_encode($student->student_photo) }}" alt="Student Photo" class="profile-icon">
            @else
                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile" class="profile-icon">
            @endif
        </div>
    </div>
</header>

<main class="form-container">
    <h2>Update Crew Recruitment Form</h2>
    <p>Update the information below.</p>
    <form method="POST" action="{{ route('editCrew', $event_id) }}">
        @csrf

        <fieldset>
            <legend>Personal Details</legend>
            <!-- Display read-only student details -->
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
        </fieldset>

        <fieldset>
            <legend>Requirements</legend>

            <div class="form-group">
                <label for="past_experience">Past Experiences</label>
                <textarea id="past_experience" name="past_experience" required>{{ old('past_experience', $crew->past_experience ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="role">Choose your desired role</label>
                <select id="role" name="role" required>
                    <option value="">Select a role</option>
                    <option value="Protocol" {{ old('role', $crew->role) == 'Protocol' ? 'selected' : '' }}>Protocol</option>
                    <option value="Technical" {{ old('role', $crew->role) == 'Technical' ? 'selected' : '' }}>Technical</option>
                    <option value="Gift" {{ old('role', $crew->role) == 'Gift' ? 'selected' : '' }}>Gift</option>
                    <option value="Food" {{ old('role', $crew->role) == 'Food' ? 'selected' : '' }}>Food</option>
                    <option value="Multimedia" {{ old('role', $crew->role) == 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                </select>
            </div>

            <div class="form-group">
                <label>Commitment</label>
                <div class="commitment-options">
                    <input type="radio" id="commit_yes" name="commitment" value="Yes" {{ old('commitment', $crew->commitment) == 'Yes' ? 'checked' : '' }}>
                    <label for="commit_yes">Yes</label>
                    <input type="radio" id="commit_no" name="commitment" value="No" {{ old('commitment', $crew->commitment) == 'No' ? 'checked' : '' }}>
                    <label for="commit_no">No</label>
                </div>
            </div>
        </fieldset>

        <div class="button-group">
            <button type="submit" class="submit-button">Submit</button>
            <button type="button" class="cancel-button" onclick="window.location='{{ route('participantdashboard') }}'">Cancel</button>
        </div>
    </form>
</main>

