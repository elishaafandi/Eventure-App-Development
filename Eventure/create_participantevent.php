<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql = "CREATE TABLE Event_Participants (
        participant_id INT AUTO_INCREMENT PRIMARY KEY,
        event_id INT,
        user_id INT,
        registration_status ENUM('registered','cancelled'),
        attendance_status ENUM('present', 'absent', 'pending'),
        feedback TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (event_id) REFERENCES Event(event_id),
        FOREIGN KEY (user_id) REFERENCES User(user_id)
    )";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table Participant created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>