
<?php
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql = "CREATE TABLE Event (
     event_id INT AUTO_INCREMENT PRIMARY KEY,
     club_id INT,
     event_role VARCHAR(255),
     organizer_id INT,
     organizer VARCHAR(255),
     event_name VARCHAR(255),
     description TEXT,
     location VARCHAR(255),
     total_slots INT,                         -- Maximum slots available for the event
     available_slots INT,                     -- Slots remaining for participants
     event_status ENUM('pending', 'approved', 'rejected', 'completed') DEFAULT 'pending',  -- Approval status by admin
     event_type ENUM('academic', 'sports', 'cultural', 'social','volunteer', 'college'), 
     event_format ENUM('in-person', 'online', 'hybrid') NOT NULL, 
     start_date DATETIME,
     end_date DATETIME,
     status ENUM('upcoming', 'ongoing', 'completed', 'canceled'),
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     FOREIGN KEY (organizer_id) REFERENCES User(user_id),
     FOREIGN KEY (club_id) REFERENCES Club(club_id)
     )";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table event created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>