<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql =  "CREATE TABLE IF NOT EXISTS Student_Experience (
    experience_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    event_id INT,
    role ENUM('protocol', 'technical', 'gift', 'food', 'special_task', 'multimedia', 'sponsorship', 'documentation', 'transportation', 'activity'),
    feedback_given BOOLEAN DEFAULT FALSE,  -- Indicates if feedback was given for this experience
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(user_id),
    FOREIGN KEY (event_id) REFERENCES Event(event_id)
)";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table experience created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>