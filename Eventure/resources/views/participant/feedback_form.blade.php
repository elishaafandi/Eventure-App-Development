<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Feedback</title>
    <link rel="stylesheet" href="{{ asset('build/assets/rateevent.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-left">
            <a href="/participanthome" class="logo">EVENTURE</a>
            <nav class="nav-left">
                <a href="/participanthome">Home</a>
                <a href="/participantdashboard">Dashboard</a>
                <a href="/participantcalendar">Calendar</a>
                <a href="/profilepage">User Profile</a>
            </nav>
        </div>
    </header>

    <main>
    <section class="main-content">
        @if (session('error'))
            <p class="error">{{ session('error') }}</p>
        @elseif (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <div class="feedback-row">
            <!-- Event Details Section -->
            <div class="event-details">
                <h2>Event Details</h2>
                @if ($event)
                    <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
                    <p><strong>Description:</strong> {{ $event->description }}</p>
                    <p><strong>Location:</strong> {{ $event->location }}</p>
                    <p><strong>Start Date:</strong> {{ date('F j, Y, g:i A', strtotime($event->start_date)) }}</p>
                    <p><strong>End Date:</strong> {{ date('F j, Y, g:i A', strtotime($event->end_date)) }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($event->event_type) }}</p>
                    <p><strong>Format:</strong> {{ ucfirst($event->event_format) }}</p>
                @endif
            </div>

            <!-- Feedback Form Section -->
            <div class="feedback-form">
                @if ($existing_feedback)
                    <h2>Your Previous Feedback</h2>
                    <p><strong>Rating:</strong> {{ $existing_feedback->rating }} out of 5 stars</p>
                    <p><strong>Feedback:</strong> {{ $existing_feedback->feedback }}</p>
                @else
                    <h2>Provide Feedback</h2>
                    <form method="POST" action="{{ route('feedback.submit') }}" onsubmit="return validateForm()">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ request('event_id') }}">

                        <div class="form-group">
                            @if($student && $student->student_photo)
                                <img src="data:image/jpeg;base64,{{ base64_encode($student->student_photo) }}" alt="Student Photo" class="profile-pic">
                            @else
                                <p>No photo available.</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="{{ $student->first_name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" value="{{ $student->last_name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="rating">Rating (1 to 5):</label>
                            <div class="rating-stars" id="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star" data-value="{{ $i }}">☆</span>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating" required>
                        </div>

                        <div class="form-group">
                            <label for="feedback">Feedback:</label>
                            <textarea name="feedback" id="feedback" rows="5" required placeholder="Share your thoughts..."></textarea>
                        </div>

                        <button type="submit">Submit Feedback</button>
                    </form>
                @endif
            </div>
        </div>
    </section>
</main>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-stars .star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-value');
                    ratingInput.value = rating;

                    stars.forEach(star => {
                        star.classList.toggle('filled', star.getAttribute('data-value') <= rating);
                    });
                });
            });
        });

        function validateForm() {
            const rating = document.getElementById('rating').value;
            const feedback = document.getElementById('feedback').value.trim();
            if (!rating || !feedback) {
                alert("Please fill out both the rating and feedback fields.");
                return false;
            }
            return true;
        }
    </script>

</body>

</html>