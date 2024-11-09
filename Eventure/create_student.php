<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp

$sql = "CREATE TABLE Student (
    user_id INT,
	first_name VARCHAR(100),
	last_name VARCHAR(100),
    ic VARCHAR(12),
    matric_no VARCHAR(8) NOT NULL,
	faculty_name VARCHAR(100),
    sem_of_study VARCHAR(3),
    college VARCHAR(4),
    email VARCHAR(100),
    gender BOOLEAN,
	FOREIGN KEY(user_id) REFERENCES User(user_id)
)";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table student created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
