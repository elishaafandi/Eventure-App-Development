<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql =  "CREATE TABLE IF NOT EXISTS Event_Club (
  association_id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT,
  club_id INT,
  role VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES Event(event_id),
  FOREIGN KEY (club_id) REFERENCES Club(club_id)
)";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table event club created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>