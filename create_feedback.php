<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql = "CREATE TABLE Feedback (
        feedback_id INT AUTO_INCREMENT PRIMARY KEY,
        event_id INT,
        from_user_id INT,
        to_user_id INT NULL,
        feedback_text TEXT,
        rating INT,
        feedback_type ENUM('event', 'participant', 'crew'),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (event_id) REFERENCES Event(event_id),
        FOREIGN KEY (from_user_id) REFERENCES User(user_id),
        FOREIGN KEY (to_user_id) REFERENCES User(user_id)
    )";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table feedback created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>