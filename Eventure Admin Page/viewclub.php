<?php
// Include database connection and start session
include 'config.php';
session_start();

// Check if the user is an admin
if (!isset($_SESSION['ID']) || $_SESSION['ROLE'] != 1) {
    header("Location: login.php");
    exit();
}

// Get club ID from URL
$club_id = isset($_GET['club_id']) ? $_GET['club_id'] : null;

if (!$club_id) {
    echo "Club ID is required.";
    exit();
}

// Fetch club details from the database
$stmt = $conn->prepare("SELECT * FROM clubs WHERE club_id = ?");
$stmt->bind_param("i", $club_id);
$stmt->execute();
$club = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$club) {
    echo "Club not found.";
    exit();
}

// Handle approval or rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'approve') {
        $status = 'approved';
    } elseif ($action === 'reject') {
        $status = 'rejected';
    } else {
        echo "Invalid action.";
        exit();
    }

    // Update the club status
    $updateStmt = $conn->prepare("UPDATE clubs SET club_status = ?, updated_at = NOW() WHERE club_id = ?");
    $updateStmt->bind_param("si", $status, $club_id);
    if ($updateStmt->execute()) {
        echo "Club status updated successfully.";
        header("Location: adminapproveclub.php");
        exit();
    } else {
        echo "Error updating club status.";
    }
    $updateStmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Club</title>
    <link rel="stylesheet" href="adminhome.css">
    <style>
        img {
            max-width: 100%;
            height: auto;
        }
        /* General button styles for pill shape */
        .buttons button {
            padding: 12px 30px; /* Adjusted padding for a more elongated pill shape */
            margin: 10px;
            border: none;
            border-radius: 50px; /* Makes the button pill-shaped */
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            font-size:10px;
        }

        /* Hover effect for buttons */
        .buttons button:hover {
            transform: scale(1.05);
        }

        /* Approve button styling */
        .approve-button {
            background-color: #28a745; /* Green for approval */
            color: white;
        }

        .approve-button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        /* Reject button styling */
        .reject-button {
            background-color: #dc3545; /* Red for rejection */
            color: white;
        }

        .reject-button:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        /* Back button styling */
            .back-button {
                padding: 12px 50px; /* Adjusted padding for pill shape */
                background-color: #007bff; /* Blue for back */
                color: white;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border-radius: 50px; /* Makes the button pill-shaped */
                transition: background-color 0.3s ease, transform 0.2s ease;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                font-size:10px;
            }

            .back-button:hover {
                background-color: #0056b3; /* Darker blue on hover */
            }

            .back-button:active {
                transform: scale(0.98); /* Slight scale on click */
            }


        /* Styling for the download link */
        .download-link {
            color: #007bff;
            text-decoration: none;
        }

        .download-link:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <a href="adminhome.php" class="logo">EVENTURE</a>
        </div>
    </header>
    <main>
        <div class="main-content">
            <h1>Club Details</h1>
            <table class="data-table">
                <tr>
                    <th>Club Name:</th>
                    <td><?= htmlspecialchars($club['club_name']) ?></td>
                </tr>
                <tr>
                    <th>Description:</th>
                    <td><?= nl2br(htmlspecialchars($club['description'])) ?></td>
                </tr>
                <tr>
                    <th>Founded Date:</th>
                    <td><?= htmlspecialchars($club['founded_date']) ?></td>
                </tr>
                <tr>
                    <th>President ID:</th>
                    <td><?= htmlspecialchars($club['president_id']) ?></td>
                </tr>
                <tr>
                    <th>Status:</th>
                    <td><?= ucfirst(htmlspecialchars($club['club_status'])) ?></td>
                </tr>
                <tr>
                    <th>Club Photo:</th>
                    <td>
                        <?php if ($club['club_photo']): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($club['club_photo']) ?>" alt="Club Photo" style="max-width: 300px; max-height: 300px;">
                        <?php else: ?>
                            No photo available.
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Approval Letter:</th>
                    <td>
                        <?php if ($club['approval_letter']): ?>
                            <a href="view_approval_letter.php?club_id=<?= $club['club_id'] ?>" class="download-link">Download Approval Letter</a>
                        <?php else: ?>
                            No approval letter available.
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <?php if ($club['club_status'] === 'pending'): ?>
            <form method="POST" class="buttons"> <!-- Added 'buttons' class here for styling -->
                <button type="submit" name="action" value="approve" class="approve-button">Approve</button>
                <button type="submit" name="action" value="reject" class="reject-button">Reject</button>
            </form>
        <?php else: ?>
            <p>This club has already been <?= htmlspecialchars($club['club_status']) ?>.</p>
        <?php endif; ?>

        <a href="adminhome.php" class="back-button">Back to Dashboard</a>

       
    </main>
</body>
</html>
