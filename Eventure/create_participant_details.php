<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql = "CREATE TABLE participant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    id_number VARCHAR(50) NOT NULL,
    matric_number VARCHAR(50) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    year_course VARCHAR(50) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    attendance ENUM('Yes', 'Maybe') NOT NULL,
    requirements VARCHAR(50) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table Participant Details created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>