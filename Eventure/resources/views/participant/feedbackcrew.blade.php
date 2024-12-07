<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="{{ asset('build/assets/ratecrew.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
    <h2>Rate Your Crew</h2>
    <div class="header-left">
        <div class="nav-right">
            <a href="{{ route('participanthome') }}" class="participant-site">PARTICIPANT SITE</a>
            <a href="" class="organizer-site">ORGANIZER SITE</a> 
            <span class="notification-bell">🔔</span>
            <a href="" class="profile-icon"><i class="fas fa-user-circle"></i></a>
        </div>
    </div>
</header>

<main>
    <aside class="sidebar">
        <div class="logo-container">
            <a href="{{ route('participanthome') }}" class="logo">EVENTURE</a>
        </div>
        <ul>
            <li><a href=""><i class="fas fa-home-alt"></i> Dashboard</a></li>
            <li><a href=""><i class="fas fa-calendar-alt"></i> Event Hosted</a></li>
            <li><a href=""><i class="fas fa-user-friends"></i> Participant Listing</a></li>
            <li><a href=""><i class="fas fa-users"></i> Crew Listing</a></li>
            <li><a href=""><i class="fas fa-chart-line"></i> Reports</a></li>
            <li><a href="" class="active"><i class="fas fa-star"></i> Feedback</a></li>
        </ul>
        <ul style="margin-top: 60px;">
            <li><a href=""><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <div class="main-content">
        <h2>Feedback Collection Page</h2>
        <p>View feedback from participants to understand the strengths and weaknesses of your events.</p>

        <!-- Events Feedback Section -->
        <div class="feedback-list">
            <h3>Feedback for Events</h3>
            @if ($allEvents->isNotEmpty())
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allEvents as $event)
                            <tr>
                                <td>{{ $event->event_name }}</td>
                                <td>
                                    <a href="{{ route('feedback.crew.submit', $event->event_id, $clubId->club_id) }}" class="btn-view-feedback">View Feedback</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No events available under the selected club.</p>
            @endif
        </div>

        <!-- Crew Feedback Section -->
        <div class="feedback-list">
            <h3>Select an Event to Rate Your Crew Members</h3>
            <form method="POST" action="{{ route('feedback.crew.submit') }}">
                @csrf
                <label for="event_id">Event:</label>
                <select name="event_id" id="event_id" onchange="fetchCrews(this.value)">
                    <option value="">-- Select Event --</option>
                    @foreach ($crewEvents as $event)
                        <option value="{{ $event->event_id }}">{{ $event->event_name }}</option>
                    @endforeach
                </select>
            </form>

            <div id="crew-feedback-form" style="display: none;">
                <h4>Rate a Crew Member</h4>
                <form method="POST" action="{{ route('feedback.crew.submit') }}">
                    @csrf
                    <input type="hidden" name="event_id" id="selected_event_id">

                    <label for="crew_id">Crew Member:</label>
                    <select name="crew_id" id="crew_id"></select>

                    <label for="rating">Rating:</label>
                    <input type="number" name="rating" min="1" max="5" required>

                    <label for="feedback">Feedback:</label>
                    <textarea name="feedback" rows="4" required></textarea>

                    <button type="submit" class="btn-submit-feedback">Submit Feedback</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    function fetchCrews(eventId) {
        if (!eventId) return;

        document.getElementById('selected_event_id').value = eventId;
        fetch('{{ route('feedback.crews') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ event_id: eventId })
        })
        .then(response => response.json())
        .then(data => {
            const crewSelect = document.getElementById('crew_id');
            crewSelect.innerHTML = '<option value="">-- Select Crew --</option>';
            data.forEach(crew => {
                crewSelect.innerHTML += `<option value="${crew.crew_id}">${crew.name} - Role: ${crew.role}</option>`;
            });
            document.getElementById('crew-feedback-form').style.display = 'block';
        })
        .catch(error => console.error('Error fetching crews:', error));
    }
</script>

</body>
</html>
