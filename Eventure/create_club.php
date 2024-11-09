<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql = "CREATE TABLE Club(
		club_id INT AUTO_INCREMENT PRIMARY KEY,
        club_name VARCHAR(255) UNIQUE,
        description TEXT,
        founded_date DATE,
        club_type ENUM('academic', 'nonacademic', 'collegecouncil', 'uniform'), 
        president_id INT,
		FOREIGN KEY (president_id) REFERENCES User(user_id)
)";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table club created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>