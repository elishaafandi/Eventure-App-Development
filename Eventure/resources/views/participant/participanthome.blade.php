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
                <a href="{{ route('participantdashboard') }}">Dashboard</a>
                <a href="" class="{{ request()->routeIs('participantcalendar') ? 'active' : '' }}">Calendar</a>
                <a href="{{ route('profilepage') }}" class="{{ request()->routeIs('profilepage') ? 'active' : '' }}">User Profile</a>
            </nav>
        </div>
        <div class="nav-right">
            <a href="{{ route('participanthome') }}" class="participant-site">PARTICIPANT SITE</a>
            <a href="{{ route('Homepage') }}" class="organizer-site">ORGANIZER SITE</a> 
            <span class="notification-bell">🔔</span>
            <div class="profile-menu">
                @if (!empty($user->photo))
                    <img src="{{ asset('storage/' . $students->photo) }}" alt="Student Photo" class="profile-icon">
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

<main>

<div class="search-section">
    <h1>Find Your Event!</h1>
    <form method="GET" action="{{ route('participanthome') }}" class="search-bar">
        <input type="text" name="club_name" placeholder="Enter Club Name" value="{{ old('club_name', $club_name) }}">
        
        <select name="club_type">
            <option value="0" {{ $club_type === '0' ? 'selected' : '' }}>Choose Club Type</option>
            <option value="sports" {{ $club_type === 'sports' ? 'selected' : '' }}>Sports</option>
            <option value="volunteer" {{ $club_type === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
            <option value="academic" {{ $club_type === 'academic' ? 'selected' : '' }}>Academic</option>
            <option value="social" {{ $club_type === 'social' ? 'selected' : '' }}>Social</option>
            <option value="cultural" {{ $club_type === 'cultural' ? 'selected' : '' }}>Cultural</option>
            <option value="college" {{ $club_type === 'college' ? 'selected' : '' }}>College</option>
            <option value="uniform" {{ $club_type === 'uniform' ? 'selected' : '' }}>Uniform Bodies</option>
        </select>
        
        <button type="submit" class="search-button"><i class="fas fa-search"></i> Search</button>
        <button type="button" onclick="clearSearch()" class="clear-button"><i class="fas fa-times"></i> Clear Search</button>
    </form>
</div>

    <main class="main-content">
        <aside class="filter-section">
        <form action="{{ route('participanthome') }}" method="GET">
            <h3>Filter Event <span class="clear-all">Clear all</span></h3>
            <div class="filter-option">
                <label for="date-post">Date Post</label>
                <select id="date-post" name="start_date">
                    <option value="anytime" {{ $start_date == 'anytime' ? 'selected' : '' }}>Anytime</option>
                    <option value="last-week" {{ $start_date == 'last-week' ? 'selected' : '' }}>This Week</option>
                    <option value="this-month" {{ $start_date == 'this-month' ? 'selected' : '' }}>This Month</option>
                </select>
            </div>
            <div class="filter-option">
                <label>Location</label>
                <label>
                    <input type="checkbox" class="location-filter" name="location" value="on-campus" {{ $location === 'on-campus' ? 'checked' : '' }}> On-Campus
                </label>
                <label>
                    <input type="checkbox" class="location-filter" name="location" value="off-campus" {{ $location === 'off-campus' ? 'checked' : '' }}> Off-Campus
                </label>
            </div>
            <div class="filter-option">
                <label>Role</label>
                <label>
                    <input type="checkbox" name="event_role" value="crew" {{ $event_role === 'crew' ? 'checked' : '' }}> Crew
                </label>
                <label>
                    <input type="checkbox" name="event_role" value="participant" {{ $event_role === 'participant' ? 'checked' : '' }}> Participant
                </label>
            </div>
            <div class="filter-option">
                <label>Format</label>
                <label>
                    <input type="checkbox" name="event_format" value="in-person" {{ $event_format === 'in-person' ? 'checked' : '' }}> In-Person
                </label>
                <label>
                    <input type="checkbox" name="event_format" value="online" {{ $event_format === 'online' ? 'checked' : '' }}> Online
                </label>
            </div>
            <button id="filter-btn">Apply Filters</button>
        </form>
        </aside>

        <section class="event-list">
            @if ($isFiltered)
                <p>{{ count($events) }} results found</p>
            @else
                <p>Showing all events</p>
            @endif

            @foreach ($events as $event)
                <div class="event-card">
                    <div class="event-header">
                        <div class="event-title-organizer">
                            <h2>{{ $event['event_name'] }}</h2>
                            <span class="event-organizer">{{ $event['organizer'] }}</span>
                        </div>
                        <div class="event-icons">
                            <button class="notification-button"><i class="fas fa-bell"></i></button>
                            <button class="heart-button"><i class="fas fa-heart"></i></button>
                        </div>
                    </div>
                    <p>{{ $event['description'] }}</p>
                    <div class="event-footer">
                        <span class="event-location">{{ $event['location'] }}</span>
                        <span class="event-role">{{ $event['event_role'] }}</span>
                        <span class="event-status">{{ $event['status'] }}</span>
                        <div class="event-buttons">
                            <button class="find-out-more-button"
                                data-event-id="{{ $event['event_id'] }}"
                                data-title="{{ $event['event_name'] }}" 
                                data-organizer="{{ $event['organizer'] }}" 
                                data-date="{{ date('d/m/Y', strtotime($event['start_date'])) }}" 
                                data-time="{{ date('H:i', strtotime($event['start_date'])) }}" 
                                data-location="{{ $event['location'] }}" 
                                data-description="{{ $event['description'] }}" 
                                data-role="{{ $event['event_role'] }}"  
                                data-total-slots="{{ $event['total_slots'] }}"
                                data-available-slots="{{ $event['available_slots'] }}"
                                data-event-status="{{ $event['status'] }}"
                                data-event-type="{{ $event['event_type'] }}"
                                data-event-format="{{ $event['event_format'] }}"
                                data-created-at="{{ date('d/m/Y H:i', strtotime($event['created_at'])) }}"
                                data-event-photo="{{ $event['event_photo'] }}">
                                Find Out More
                            </button>
                            <button class="join-button" 
                                data-role="{{ $event['event_role'] }}" 
                                data-event-id="{{ $event['event_id'] }}">
                                Join Event
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

</main>

<div id="eventModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <div id="modal-details">
            <h1 id="modal-title">{{ $event['event_name'] ?? '' }}</h1>
            <p><strong>Organizer:</strong> <span id="modal-organizer">{{ $event['organizer'] ?? '' }}</span></p>
            <p><strong>Date:</strong> <span id="modal-date">{{ \Carbon\Carbon::parse($event['start_date'] ?? '')->format('d/m/Y') }}</span></p>
            <p><strong>Time:</strong> <span id="modal-time">{{ \Carbon\Carbon::parse($event['start_date'] ?? '')->format('H:i') }}</span></p>
            <p><strong>Location:</strong> <span id="modal-location">{{ $event['location'] ?? '' }}</span></p>
            <p><strong>Description:</strong> <span id="modal-description">{{ $event['description'] ?? '' }}</span></p>
            <p><strong>Total Slots:</strong> <span id="modal-total-slots">{{ $event['total_slots'] ?? '' }}</span></p>
            <p><strong>Available Slots:</strong> <span id="modal-available-slots">{{ $event['available_slots'] ?? '' }}</span></p>
            <p><strong>Status:</strong> <span id="modal-event-status">{{ $event['status'] ?? '' }}</span></p>
            <p><strong>Event Type:</strong> <span id="modal-event-type">{{ $event['event_type'] ?? '' }}</span></p>
            <p><strong>Format:</strong> <span id="modal-event-format">{{ $event['event_format'] ?? '' }}</span></p>
            <p><strong>Event Photo:</strong> <span id="modal-event-photo">{{ $event['event_photo'] ?? '' }}</span></p>
            <div class="event-actions">
                <button class="register-button" 
                    data-role="{{ $event['event_role'] ?? '' }}"
                    data-event-id="{{ $event['event_id'] }}">
                Register Now
                </button>
                <button class="view-participant-button">View Participant</button>
            </div>
        </div>
    </div>
</div>  

<script>

function clearSearch() {
    // Clear input fields
    document.querySelector('input[name="club_name"]').value = '';
    document.querySelector('select[name="club_type"]').value = '0';
    // Submit the form to refresh and show all events
    document.querySelector('.search-bar').submit();
}

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('eventModal');
            const closeButton = document.querySelector('.close-button');

            // Function to open modal
            function openModal(eventData) {
                document.getElementById('modal-title').textContent = eventData.title;
                document.getElementById('modal-organizer').textContent = eventData.organizer;
                document.getElementById('modal-date').textContent = eventData.date;
                document.getElementById('modal-time').textContent = eventData.time;
                document.getElementById('modal-location').textContent = eventData.location;
                document.getElementById('modal-description').textContent = eventData.description;
                document.getElementById('modal-total-slots').textContent = eventData.totalSlots;
                document.getElementById('modal-available-slots').textContent = eventData.availableSlots;
                document.getElementById('modal-event-status').textContent = eventData.eventStatus;
                document.getElementById('modal-event-type').textContent = eventData.eventType;
                document.getElementById('modal-event-format').textContent = eventData.eventFormat;
                document.getElementById('modal-event-photo').textContent = eventData.eventPhoto;

                const eventPhoto = document.getElementById('modal-event-photo');
                if (eventData.eventPhoto) {
                eventPhoto.innerHTML = `<img src="${eventData.eventPhoto}" alt="Event Photo" style="width: 100%; height: auto;">`;
                } else {
                    eventPhoto.innerHTML = 'No image available';
                }

                document.querySelector('.register-button').setAttribute('data-role', eventData.role); // Set the role attribute
                document.querySelector('.register-button').setAttribute('data-event-id', eventData.eventId); // Set the event_id attribute

                modal.style.display = 'flex'; // Set to flex to enable centering
            }

            // Event listener to close modal
            closeButton.onclick = function () {
                modal.style.display = 'none';
            };

            // Close modal when clicking outside of it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };

            // Attach click event to each "Find Out More" button
            document.querySelectorAll('.find-out-more-button').forEach(button => {
                button.addEventListener('click', function () {
                    const eventData = {
                        title: button.getAttribute('data-title'),
                        organizer: button.getAttribute('data-organizer'),
                        date: button.getAttribute('data-date'),
                        time: button.getAttribute('data-time'),
                        location: button.getAttribute('data-location'),
                        description: button.getAttribute('data-description'),
                        role: button.getAttribute('data-role'),
                        eventId: button.getAttribute('data-event-id'),
                        totalSlots: button.getAttribute('data-total-slots'),
                        availableSlots: button.getAttribute('data-available-slots'),
                        eventStatus: button.getAttribute('data-event-status'),
                        eventType: button.getAttribute('data-event-type'),
                        eventFormat: button.getAttribute('data-event-format'),
                        eventPhoto: button.getAttribute('data-photo')
                    };
                    openModal(eventData);
                });
            });

            // Event listener for register button
            document.querySelector('.register-button').addEventListener('click', function () {
                const role = this.getAttribute('data-role').trim();
                const eventId = this.getAttribute('data-event-id'); // Get the event_id
                const crewFormRoute = "{{ route('crewform') }}";
                const participantFormRoute = "{{ route('participantform') }}"; 
                if (role === 'Crew') {
                    window.location.href = `${crewFormRoute}?event_id=${eventId}`; // Redirect to crew form
                } else {
                    window.location.href = `${participantFormRoute}?event_id=${eventId}`;; // Redirect to participant registration
                }
            });

            document.querySelectorAll('.join-button').forEach(button => {
            button.addEventListener('click', function () {
                const role = this.getAttribute('data-role').trim();
                const eventId = this.getAttribute('data-event-id'); // Get the event_id
                const crewFormRoute = "{{ route('crewform') }}";
                const participantFormRoute = "{{ route('participantform') }}"; 
                if (role === 'Crew') {
                    window.location.href = `${crewFormRoute}?event_id=${eventId}`; // Redirect to crew form
                } else {
                    window.location.href = `${participantFormRoute}?event_id=${eventId}`; // Redirect to participant registration
                }
            });
        });
    });

    document.getElementById("filter-btn").addEventListener("click", () => {
    const datePost = document.getElementById("date-post").value;

    // Get selected location filters (can have multiple values)
    const locationFilters = Array.from(
        document.querySelectorAll(".location-filter:checked")
    ).map((checkbox) => checkbox.value);

    // Get selected role filters (can have multiple values)
    const roleFilters = Array.from(
        document.querySelectorAll(".role-filter:checked")
    ).map((checkbox) => checkbox.value);

    // Get selected format filters (can have multiple values)
    const formatFilters = Array.from(
        document.querySelectorAll(".format-filter:checked")
    ).map((checkbox) => checkbox.value);

    // Call a function to apply filters
    applyFilters(datePost, locationFilters, roleFilters, formatFilters);
});

function applyFilters(datePost, locationFilters, roleFilters, formatFilters) {
    // Assuming events are dynamically loaded with a specific class or container
    const events = document.querySelectorAll(".event-card");

    events.forEach((event) => {
        // Read attributes or data tags from events
        const eventDate = event.getAttribute("data-date");
        const eventLocation = event.getAttribute("data-location"); // e.g., "on-campus, off-campus"
        const eventRole = event.getAttribute("data-role");
        const eventFormat = event.getAttribute("data-event-format");

        // Logic to determine if event should be visible
        const matchesDate =
            datePost === "anytime" || eventDate === datePost;

        // Check if event matches selected location filters (handle multiple locations)
        const matchesLocation =
            locationFilters.length === 0 || locationFilters.some(location => eventLocation.includes(location));

        // Check if event matches selected role filters (handle multiple roles)
        const matchesRole =
            roleFilters.length === 0 || roleFilters.some(role => eventRole.includes(role));

        const matchesFormat =
            formatFilters.length === 0 || formatFilters.includes(eventFormat);

        // Show or hide based on matches
        if (matchesDate && matchesLocation && matchesRole && matchesFormat) {
            event.style.display = "block";
        } else {
            event.style.display = "none";
        }
    });
}

// Clear all filters
document.querySelector(".clear-all").addEventListener("click", () => {
    document.getElementById("date-post").value = "anytime";
    document.querySelectorAll("input[type='checkbox']").forEach((checkbox) => {
        checkbox.checked = false;
    });

    // Reset filters to show all events
    applyFilters("anytime", [], [], []);
});

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

