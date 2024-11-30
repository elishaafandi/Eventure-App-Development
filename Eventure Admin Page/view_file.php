<?php
include('config.php');

$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

if (!$event_id || !$type) {
    die("Invalid request.");
}

$field = $type === 'approval_letter' ? 'approval_letter' : null;

if (!$field) {
    die("Invalid file type.");
}

$stmt = $conn->prepare("SELECT $field FROM events WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($file_data);
$stmt->fetch();
$stmt->close();

if ($file_data) {
    header("Content-Type: application/pdf");
    echo $file_data;
} else {
    echo "File not found.";
}
?>
