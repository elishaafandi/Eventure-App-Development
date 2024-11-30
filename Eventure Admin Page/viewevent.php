<?php
// Database connection
include('config.php');

// Get the event ID from the URL
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

if (!$event_id) {
    die("Event ID not specified.");
}

// Handle approve/reject action if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $new_status = $_POST['action'] === 'approve' ? 'approved' : 'rejected';

    // Update event status in the database
    $update_sql = "UPDATE events SET event_status = ?, updated_at = NOW() WHERE event_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_status, $event_id);
    $stmt->execute();

    echo "<p>Event has been " . htmlspecialchars($new_status) . ".</p>";
    $stmt->close();
}

// Fetch event details from the database
$stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$event) {
    die("Event not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        .buttons button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .approve {
            background-color: #28a745;
            color: #fff;
        }
        .reject {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Event Details</h1>
        <table>
            <?php foreach ($event as $key => $value): ?>
                <tr>
                    <th><?= ucfirst(str_replace('_', ' ', $key)) ?>:</th>
                    <td>
                        <?php
                        if ($key === 'event_photo' && $value) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($value) . '" alt="Event Photo">';
                        } elseif ($key === 'approval_letter' && $value) {
                            echo '<a href="view_file.php?event_id=' . $event_id . '&type=approval_letter">View Approval Letter</a>';
                        } else {
                            echo nl2br(htmlspecialchars($value));
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php if ($event['event_status'] === 'pending'): ?>
            <div class="buttons">
                <form method="POST" style="display:inline;">
                    <button type="submit" name="action" value="approve" class="approve">Approve</button>
                </form>
                <form method="POST" style="display:inline;">
                    <button type="submit" name="action" value="reject" class="reject">Reject</button>
                </form>
            </div>
        <?php else: ?>
            <p>This event has already been <?= htmlspecialchars($event['event_status']) ?>.</p>
        <?php endif; ?>
    </div>
</body>
</html>
