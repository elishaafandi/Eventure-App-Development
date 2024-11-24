<?php

include 'config.php';
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $idNumber = $_POST['id_number'];
        $matricNumber = $_POST['matric_number'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $yearCourse = $_POST['year_course'];
        $gender = $_POST['gender'];

        $sql = "INSERT INTO crew (full_name, email, id_number, matric_number, phone, address, year_course, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$fullName, $email, $idNumber, $matricNumber, $phone, $address, $yearCourse, $gender]);

        echo "<script>alert('Registration successful!'); window.location.href='participanthome.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Recruitment Form</title>
    <link rel="stylesheet" href="crewform.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="participanthome.php" class="logo">EVENTURE</a> 
            <nav class="nav-left">
                <a href="participanthome.php" class="active">Home</a>
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

    <main class="form-container">
        <h2>Crew Recruitment Form</h2>
        <p>Please fill in all the information below.</p>
        <form method="POST" action="crewform.php">
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
            </fieldset>

            <fieldset>
                <legend>Requirements</legend>
                <div class="form-group">
                    <label for="past_experience">Please list your past experiences in previous programs (e.g., OPERA23 - Technical Unit)</label>
                    <textarea id="past_experience" name="past_experience" required></textarea>
                </div>
                <div class="form-group">
                    <label for="resume">Please compile your past experiences and works into a single PDF file (max size: 10 MB)</label>
                    <input type="file" id="resume" name="resume" accept=".pdf" required>
                </div>
                <div class="form-group">
                    <label for="role">Choose your desired role</label>
                    <select id="role" name="role" required>
                        <option value="">Select a role</option>
                        <option value="Protocol Unit">Protocol Unit</option>
                        <option value="Multimedia Unit">Multimedia Unit</option>
                        <option value="Food Unit">Food Unit</option>
                        <option value="Food Unit">Technical Unit</option>
                        <option value="Food Unit">Special Task Unit</option>
                        <option value="Food Unit">Multimedia Task Unit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>I hereby acknowledge that all information provided is accurate, and I commit to give 100% dedication to this program.</label>
                    <div class="commitment-options">
                        <input type="radio" id="commit_yes" name="commitment" value="Yes" required>
                        <label for="commit_yes">Yes</label>
                        <input type="radio" id="commit_no" name="commitment" value="No" required>
                        <label for="commit_no">No</label>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Interview</legend>
                <p>An interview session will be scheduled on a later date and will be sent to your email. Check your calendar for the interview date. For more enquiries, feel free to contact us on our email. Thank you.</p>
            </fieldset>

            <div class="button-group">
                <button type="submit" class="submit-button">Submit</button>
                <button type="button" class="cancel-button" onclick="window.location.href='participanthome.php';">Cancel</button>
            </div>

        </form>
    </main>
</body>
</html>


