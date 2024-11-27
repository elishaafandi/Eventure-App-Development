<?php

include 'config.php';
// Start the session to access session variables
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['ID'])) {
    echo "You must be logged in to access this page.";
    exit;
}

// Fetch student details to autofill form
$studentQuery = "SELECT * FROM students WHERE id = ?";
$studentStmt = $conn->prepare($studentQuery);
$studentStmt->bind_param("i", $user_id);
$studentStmt->execute();
$studentResult = $studentStmt->get_result();
$student = $studentResult->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $idNumber = $_POST['id_number'];
        $matricNumber = $_POST['matric_number'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $yearCourse = $_POST['year_course'];
        $gender = $_POST['gender'];
        $attendance = $_POST['attendance'];
        $requirements = $_POST['requirements'];
    
        $sql = "INSERT INTO participant (full_name, email, id_number, matric_number, phone, address, year_course, gender, attendance, requirements) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$fullName, $email, $idNumber, $matricNumber, $phone, $address, $yearCourse, $gender, $attendance, $requirements]);
        
        echo "<script>alert('Registration successful!'); window.location.href='participanthome.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Recruitment Form</title>
    <link rel="stylesheet" href="participantform.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="participanthome.php" class="logo">EVENTURE</a> 
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

    <main class="form-container">
        <h2>Participant Form</h2>
        <p>Please fill in all the information below.</p>
        <form method="POST" action="participantform.php">
        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
            <fieldset>
                <legend>Personal Details</legend>

                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="id_number">Identification Number</label>
                    <input type="text" id="id_number" name="id_number" required>
                </div>

                <div class="form-group">
                    <label for="matric_number">Matric Number</label>
                    <input type="text" id="matric_number" name="matric_number" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="address">College Address</label>
                    <input type="text" id="address" name="address" required>
                </div>

                <div class="form-group">
                    <label for="year_course">Year/Course (in 24/25)</label>
                    <input type="text" id="year_course" name="year_course" required>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <div class="gender-options">
                        <input type="radio" id="male" name="gender" value="Male" required>
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="Female" required>
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
                <button type="button" class="cancel-button" onclick="window.location.href='participanthome.php';">Cancel</button>
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


