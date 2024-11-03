<?php
    include 'createevent.php'; 
    $sql = "SELECT * FROM events ORDER BY date ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>www.eventureutm.com</title>
    <link rel="stylesheet" href="participanthome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="participanthome.html" class="logo">EVENTURE</a> 
            <nav class="nav-left">
                <a href="participanthome.html" class="active">Home</a>
                <a href="#">Calendar</a>
                <a href="#">User Profile</a>
                <a href="#">Dashboard</a>
            </nav>
        </div>
        <div class="nav-right">
            <a href="#" class="participant-site">PARTICIPANT SITE</a>
            <a href="#" class="organizer-site">ORGANIZER SITE</a>
            <span class="notification-bell">🔔</span>
        </div>
    </header>

    <main>
        <div class="search-section">
            <h1>Find Your Event!</h1>
            <div class="search-bar">
                <input type="text" placeholder="Enter Club Name">
                <select>
                    <option value="0">Choose Category</option>
                    <option value="1">Sports</option>
                    <option value="2">Volunteerism</option>
                    <option value="3">Academic</option>
                    <option value="4">Entrepreneur</option>
                    <option value="5">Cultural and Art</option>
                    <option value="6">Religious</option>
                    <option value="7">Uniform Bodies</option>
                </select>
                <button class="search-button"><i class="fas fa-search"></i> Search</button>
            </div>
        </div>

        <main class="main-content">
            <aside class="filter-section">
                <h3>Filter Event</h3>
                <div class="filter-option">
                    <label>Date Post</label>
                    <select>
                        <option value="anytime">Anytime</option>
                        <!-- More options -->
                    </select>
                </div>
                <div class="filter-option">
                    <label>Location</label>
                    <label><input type="checkbox"> On-Campus</label>
                    <label><input type="checkbox"> Off-Campus</label>
                </div>
                <div class="filter-option">
                    <label>Role</label>
                    <label><input type="checkbox"> Crew Committee</label>
                    <label><input type="checkbox"> Participant</label>
                </div>
                <div class="filter-option">
                    <label>On-Site/Remote</label>
                    <label><input type="checkbox"> On-Site</label>
                    <label><input type="checkbox"> Remote/Virtual</label>
                    <label><input type="checkbox"> Hybrid</label>
                </div>
            </aside>
        
            <section class="event-list">
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <div class="event-header">
                            <div class="event-title-organizer">
                                <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                                <span class="event-organizer"><?php echo htmlspecialchars($event['organizer']); ?></span>
                            </div>
                            <div class="event-icons">
                                <button class="notification-button"><i class="fas fa-bell"></i></button>
                                <button class="heart-button"><i class="fas fa-heart"></i></button>
                            </div>
                        </div>
                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                        <div class="event-footer">
                            <span class="event-location"><?php echo htmlspecialchars($event['location']); ?></span>
                            <span class="event-date"><?php echo date("d/m/Y", strtotime($event['date'])); ?></span>
                            <span class="event-time"><?php echo date("H:i", strtotime($event['time'])); ?></span>
                            <div class="event-buttons">
                                <button class="find-out-more-button">Find Out More</button>
                                <button class="join-button">Join Event</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
    </main>
        <!-- Modal Structure for Event Details -->
        <div id="eventModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div id="modal-details">
                <h1 id="modal-title"></h1>
                <p><strong>Organizer:</strong> <span id="modal-organizer"></span></p>
                <p><strong>Date:</strong> <span id="modal-date"></span></p>
                <p><strong>Time:</strong> <span id="modal-time"></span></p>
                <p><strong>Location:</strong> <span id="modal-location"></span></p>
                <p><strong>Description:</strong> <span id="modal-description"></span></p>
                
                <div class="event-actions">
                    <button class="register-button">Register Now</button>
                    <button class="view-participant-button">View Participant</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle modal functionality -->
    <script>
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
                        description: button.getAttribute('data-description')
                    };
                    openModal(eventData);
                });
            });
        });
    </script>
</body>
</html>
