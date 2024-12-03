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

function clearSearch() {
    // Clear input fields
    document.querySelector('input[name="organizer"]').value = '';
    document.querySelector('select[name="event_type"]').value = '0';
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
                if (role === 'Crew') {
                    window.location.href = `crewform.php?event_id=${eventId}`; // Redirect to crew form
                } else {
                    window.location.href = `participantform.php?event_id=${eventId}`; // Redirect to participant registration
                }
            });

            document.querySelectorAll('.join-button').forEach(button => {
            button.addEventListener('click', function () {
                const role = this.getAttribute('data-role').trim();
                const eventId = this.getAttribute('data-event-id'); // Get the event_id
                if (role === 'Crew') {
                    window.location.href = `crewform.php?event_id=${eventId}`; // Redirect to crew form
                } else {
                    window.location.href = `participantform.php?event_id=${eventId}`; // Redirect to participant registration
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

