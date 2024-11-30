<?php
// Include database configuration and start the session
include 'config.php';
session_start();

// Check if user is logged in and role is 'Admin'
if (!isset($_SESSION['ID']) || $_SESSION['ROLE'] != 1) {
    header("Location: login.php");
    exit();
}

// Check if 'id' is present in the URL query string
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Prepare and execute the query to fetch user data by ID
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId); // 'i' stands for integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // If the user role is 'student', fetch additional student data from the 'students' table
        if ($user['Role'] == 0) {
            $studentStmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
            $studentStmt->bind_param("i", $userId);
            $studentStmt->execute();
            $studentResult = $studentStmt->get_result();

            if ($studentResult->num_rows > 0) {
                $student = $studentResult->fetch_assoc();
            } else {
                $student = null; // No student data found
            }
        } else {
            $student = null; // No student data for non-students
        }
    } else {
        // If no user is found, redirect back to admin home
        header("Location: adminhome.php");
        exit();
    }
} else {
    // If no ID is passed, redirect to admin home
    header("Location: adminhome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User - Eventure Admin</title>
    <link rel="stylesheet" href="adminhome.css">
    <link rel="stylesheet" href="adminviewuser.css">
</head>

<body>
    <header>
        <div class="header-left">
            <div class="nav-right">
                <span class="notification-bell">🔔</span>
                <a href="profilepage.php" class="profile-icon">
                    <i class="fas fa-user-circle"></i>
                </a>
            </div>
        </div>
    </header>

    <main>
        <aside class="sidebar">
            <div class="logo-container">
                <a href="adminhome.php" class="logo">EVENTURE</a>
            </div>
            <ul>
                <li><a href="adminhome.php"><i class="fas fa-home-alt"></i> Dashboard</a></li>
                <li><a href="adminadduser.php"><i class="fa-solid fa-user-plus"></i> Add User</a></li>
                <li><a href="adminapproveclub.php"><i class="fa-solid fa-users"></i> Club Approval</a></li>
                <li><a href="adminapproveevent.php"><i class="fas fa-calendar-alt"></i> Event Approval</a></li>
            </ul>
            <ul style="margin-top: 60px;">
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <h1>View User</h1>

            <!-- Display user details -->
            <div class="user-details">
                <p><strong>ID:</strong> <?= htmlspecialchars($user['id']) ?></p>
                <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Role:</strong> <?= $user['Role'] == 1 ? 'Admin' : 'Student' ?></p>
                <p><strong>Created At:</strong> <?= htmlspecialchars($user['created_at']) ?></p>
            </div>

            <!-- Display additional student details if role is student -->
            <?php if ($student): ?>
                <h2>Student Details</h2>
                <div class="student-details">
                    <p><strong>First Name:</strong> <?= htmlspecialchars($student['first_name']) ?></p>
                    <p><strong>Last Name:</strong> <?= htmlspecialchars($student['last_name']) ?></p>
                    <p><strong>IC Number:</strong> <?= htmlspecialchars($student['ic']) ?></p>
                    <p><strong>Matric No:</strong> <?= htmlspecialchars($student['matric_no']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($student['phone']) ?></p>
                    <p><strong>Faculty:</strong> <?= htmlspecialchars($student['faculty_name']) ?></p>
                    <p><strong>Year/Course:</strong> <?= htmlspecialchars($student['year_course']) ?></p>
                    <p><strong>College:</strong> <?= htmlspecialchars($student['college']) ?></p>
                    <p><strong>Gender:</strong> <?= htmlspecialchars($student['gender']) ?></p>
                    <!-- Display photo if available -->
                    <?php if ($student['student_photo']): ?>
                        <p><strong>Photo:</strong><br><img src="data:image/jpeg;base64,<?= base64_encode($student['student_photo']) ?>" alt="Student Photo" width="100"></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Back to Dashboard Button -->
            <a href="adminhome.php" class="back-button">Back to Dashboard</a>
        </div>
    </main>
</body>

</html>
