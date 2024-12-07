<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Recruitment Form</title>
    <link rel="stylesheet" href="{{ asset('css/viewapplicationdetails.css') }}">
</head>
<body>

    <main>
        <section>
            <h2>Crew Application Details</h2>
            <p><strong>Crew ID:</strong> {{ $student->crew_id }}</p>
            <p><strong>Full Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Identification Number:</strong> {{ $student->ic }}</p>
            <p><strong>Matric Number:</strong> {{ $student->matric_no }}</p>
            <p><strong>Phone:</strong> {{ $student->phone }}</p>
            <p><strong>College Address:</strong> {{ $student->college }}</p>
            <p><strong>Year/Course (24/25):</strong> {{ $student->year_course }}</p>
            <p><strong>Gender:</strong> {{ $student->gender }}</p>
            <p><strong>Past Experience:</strong> {{ $student->past_experience }}</p>
            <p><strong>Role:</strong> {{ $student->role }}</p>
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
        
        <button onclick="window.location.href='{{ route('participantdashboard') }}';">Back to Home</button>
    </main>

</body>
</html>

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
