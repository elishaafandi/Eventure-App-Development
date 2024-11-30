<?php
session_start();
require 'config.php';

$user_id = $_SESSION['ID'];
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : ''; // Get event_id from URL

if (!isset($_SESSION['ID'])) {
    echo "<script>alert('You must be logged in to submit feedback.');</script>";
    exit;
}

$participant_id = isset($_SESSION['participant_id']) ? intval($_SESSION['participant_id']) : null;
$crew_id = isset($_SESSION['crew_id']) ? intval($_SESSION['crew_id']) : null;

if (!$event_id) {
    echo "<script>alert('Invalid event ID.');</script>";
    exit;
}

if (isset($_GET['crew_id'])) {
    $crew_id = $_GET['crew_id']; 
}

if (isset($_GET['participant_id'])) {
    $participant_id = $_GET['participant_id'];
}

// Fetch student details to autofill form
$studentQuery = "SELECT * FROM students WHERE id = ?";
$studentStmt = $conn->prepare($studentQuery);
$studentStmt->bind_param("i", $user_id);
$studentStmt->execute();
$studentResult = $studentStmt->get_result();
$student = $studentResult->fetch_assoc();

$first_name = $student['first_name'];
$last_name = $student['last_name'];
$profile_pic = !empty($student['student_photo']) ? "data:image/jpeg;base64," . base64_encode($student['student_photo']) : 'default-profile.png';

// Fetch event details
$eventQuery = "SELECT event_name, description, location, start_date, end_date, event_type, event_format FROM events WHERE event_id = ?";
$eventStmt = $conn->prepare($eventQuery);
$eventStmt->bind_param("i", $event_id);
$eventStmt->execute();
$eventResult = $eventStmt->get_result();
$event = $eventResult->fetch_assoc();

if (!$event) {
    echo "<script>alert('Event not found.');</script>";
    exit;
}


$rating = isset($_POST['rating']) ? intval($_POST['rating']) : '';
$feedback = isset($_POST['feedback']) ? mysqli_real_escape_string($conn, $_POST['feedback']) : '';

// Check if feedback already exists
$existing_feedback_query = "SELECT * FROM feedbackevent WHERE event_id = ? AND (participant_id = ? OR crew_id = ?)";
$stmt = $conn->prepare($existing_feedback_query);
$stmt->bind_param("iii", $event_id, $participant_id, $crew_id);
$stmt->execute();
$existing_feedback = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($rating) || empty($feedback)) {
        echo "<script>alert('Please fill out both the rating and feedback fields before submitting.');</script>";
    } else {
        if (!$existing_feedback) {
            // Insert feedback if it does not exist
            if (!empty($crew_id)) {
                $query = "INSERT INTO feedbackevent (crew_id, event_id, rating, feedback) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiis", $crew_id, $event_id, $rating, $feedback);
                if (!$stmt->execute()) {
                    echo "<script>alert('Error: " . $stmt->error . "');</script>";
                    exit;
                }
            } elseif (!empty($participant_id)) {
                $query = "INSERT INTO feedbackevent (participant_id, event_id, rating, feedback) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiis", $participant_id, $event_id, $rating, $feedback);
                if (!$stmt->execute()) {
                    echo "<script>alert('Error: " . $stmt->error . "');</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Error: Neither crew_id nor participant_id is set.');</script>";
                exit;
            }

            echo "<script>alert('Feedback submitted successfully.');</script>";
        } else {
            echo "<script>alert('You have already submitted feedback for this event.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>www.eventureutm.com</title>
    <link rel="stylesheet" href="rate_event.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="participanthome.php" class="logo">EVENTURE</a> 
            <nav class="nav-left">
                <a href="participanthome.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participanthome.php' ? 'active' : ''; ?>">Home</a>
                <a href="participantdashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participantdashboard.php' ? 'active' : ''; ?>">Dashboard</a>
                <a href="participantcalendar.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'participantcalendar.php' ? 'active' : ''; ?>">Calendar</a>
                <a href="profilepage.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profilepage.php' ? 'active' : ''; ?>">User Profile</a>
            </nav>
        </div>
        <div class="nav-right">
            <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
            <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a> 
            <span class="notification-bell">🔔</span>
            <div class="profile-menu">
                <!-- Ensure the profile image is fetched and rendered properly -->
                <?php if (!empty($student['student_photo'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($student['student_photo']); ?>" alt="Student Photo" class="profile-icon">
                <?php else: ?>
                    <img src="default-profile.png" alt="Default Profile" class="profile-icon">
                <?php endif; ?>

                <!-- Dropdown menu -->
                <div class="dropdown-menu">
                    <a href="profilepage.php">Profile</a>
                    <hr>
                    <a href="logout.php" class="sign-out">Sign Out</a>
                </div>
            </div>
        </div>
    </header>

    <main>
    <section class="main-content">

            <div class="event-feedback">
                <!--Display existing feedback-->
                <?php if ($existing_feedback): ?>
                    <section class="feedback-section">
                    <div class="feedback-container">
                        <h1>View What You Think Of This Event!</h1>
                        <h2>Here are the feedback you've made on this previous event</h2>
                        <p><?php if ($event): ?>
                        <section class="event-details">
                            <h2>Event Details</h2>
                            <p><strong>Event Name:</strong> <?php echo htmlspecialchars($event['event_name']); ?></p>
                            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                            <p><strong>Start Date:</strong> <?php echo date("F j, Y, g:i A", strtotime($event['start_date'])); ?></p>
                            <p><strong>End Date:</strong> <?php echo date("F j, Y, g:i A", strtotime($event['end_date'])); ?></p>
                            <p><strong>Type:</strong> <?php echo ucfirst(htmlspecialchars($event['event_type'])); ?></p>
                            <p><strong>Format:</strong> <?php echo ucfirst(htmlspecialchars($event['event_format'])); ?></p>
                        </section>
                    <?php endif; ?></p>
                    </div>
                    <div class="form-container">
                    <h1>FEEDBACK YOU'VE MADE</h>

                    <div class="form-group">
                        <img src="<?php echo $profile_pic; ?>" alt="Student Photo" class="profile-pic">
                    </div>


                    <div class="form-group">
                    <label for ="student-name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" readonly>
                    </div>

                    <div class="form-group">
                    <label for ="student-name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" readonly>
                    </div>

                    
                    <div class="form-group">
                    <label for ="rating">Rating:
                    <div class="rating-stars">
                        <?php 
                            $rating = $existing_feedback['rating'];
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $rating ? '<span class="star filled">★</span>' : '<span class="star">☆</span>';
                            }
                        ?>
                    <?php echo $existing_feedback['rating']; ?> out of 5 stars</p></label>
                    </div>
                    </div>

                    <div class="form-group">
                    <label for ="feedback">Your Feedback:</label>
                    <input type="text" id="feedback" name="feedback" value="<?php echo nl2br($existing_feedback['feedback']); ?>" readonly>
                    </div>

                <?php else: ?>
                    <section class="feedback-section">
                    <div class="feedback-container">
                        <h1>Your Feedback Matters!</h1>
                        <h2>Enter what you feel about the event you've participated here</h2>
                        <p><?php if ($event): ?>
                        <section class="event-details">
                            <h2>Event Details</h2>
                            <p><strong>Event Name:</strong> <?php echo htmlspecialchars($event['event_name']); ?></p>
                            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                            <p><strong>Start Date:</strong> <?php echo date("F j, Y, g:i A", strtotime($event['start_date'])); ?></p>
                            <p><strong>End Date:</strong> <?php echo date("F j, Y, g:i A", strtotime($event['end_date'])); ?></p>
                            <p><strong>Type:</strong> <?php echo ucfirst(htmlspecialchars($event['event_type'])); ?></p>
                            <p><strong>Format:</strong> <?php echo ucfirst(htmlspecialchars($event['event_format'])); ?></p>
                        </section>
                    <?php endif; ?></p>
                        
                    </div>
                    <!-- Show the feedback form if no feedback exists -->
                    <div class="form-container">
                     <h2>PROVIDE EVENT FEEDBACK HERE</h2>
                    <form method="POST" action="" onsubmit="return validateForm()">

                    <div class="form-group">
                        <img src="<?php echo $profile_pic; ?>" alt="Student Photo" class="profile-pic">
                    </div>


                    <div class="form-group">
                    <label for ="student-name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" readonly>
                    </div>

                    <div class="form-group">
                    <label for ="student-name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating (1 to 5):</label>
                        <div class="rating-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star" data-value="<?php echo $i; ?>">☆</span>
                               
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="rating" value="" required />
                        <br><br>
                    </div>


                    <div class="form-group">
                        <label for="feedback">Feedback:</label>
                        <textarea name="feedback" id="feedback" rows="5" required placeholder="Share your thoughts about the event..."></textarea>
                        <br><br>
                    </div>

                        <button type="submit">Submit Feedback</button>
                    </form>
                <?php endif; ?>
                </div>
            </div>
        </section>


        <!-- Modal -->
    <div id="feedbackModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modalMessage"></p>
        </div>
    </div>

    <script>
        function openModal(message) {
            document.getElementById("modalMessage").innerText = message;
            document.getElementById("feedbackModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("feedbackModal").style.display = "none";
        }

        // Check if there's a message to display
        <?php if (isset($feedbackMessage)) : ?>
            openModal('<?php echo $feedbackMessage; ?>');
        <?php endif; ?>
    </script>

    </main>

    <script>
        function validateForm() {
            var rating = document.getElementById('rating').value;
            var feedback = document.getElementById('feedback').value;

            if (rating == "" || feedback.trim() == "") {
                alert("Please fill out both the rating and feedback fields before submitting.");
                return false;
            }
            return true;
        }
    </script>

    <script>
            document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.rating-stars .star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = this.getAttribute('data-value');
                    
                    // Set the rating input value
                    ratingInput.value = rating;

                    // Update the stars' visual state
                    stars.forEach(star => {
                if (star.getAttribute('data-value') <= rating) {
                    star.classList.add('filled'); // Add 'filled' class to change color
                } else {
                    star.classList.remove('filled'); // Remove 'filled' class for empty stars
                }
            });
                });
            });
        });
    </script>



</body>
</html> 