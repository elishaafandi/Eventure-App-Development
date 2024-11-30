<?php
// Start the session
session_start();

// Include the database connection
require("config.php");

// Ensure the user is logged in
if (!isset($_SESSION['ID'])) {
    echo "You must be logged in to access this page.";
    exit;
}

// Get the club ID from the URL (you can change this as per your requirements)
$club_id = isset($_GET['club_id']) ? (int)$_GET['club_id'] : 0;

if ($club_id === 0) {
    echo "Invalid Club ID.";
    exit;
}

// Query to get the approval letter (LONGBLOB) from the database
$query = "SELECT approval_letter FROM clubs WHERE club_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $club_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($approval_letter);
$stmt->fetch();

// Check if the approval letter exists
if ($approval_letter) {
    // Set the header to display PDF
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=approval_letter.pdf");

    // Output the file content
    echo $approval_letter;
} else {
    echo "No approval letter found for this club.";
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
