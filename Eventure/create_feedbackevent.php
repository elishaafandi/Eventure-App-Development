<?php 
require("config.php"); // Including the config file

$sql = "CREATE TABLE FeedbackEvent (
    feedback_event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    from_id INT,
    feedback_text TEXT,
    rating INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES event(event_id),
    FOREIGN KEY (from_id) REFERENCES User(user_id)
)";

if (mysqli_query($conn, $sql)) {
    echo "<h3>Table FeedbackEvent created successfully</h3>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
