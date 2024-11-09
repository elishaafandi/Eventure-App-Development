<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql = "CREATE TABLE crew (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    id_number VARCHAR(20) NOT NULL,
    matric_number VARCHAR(20) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    year_course VARCHAR(50) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    past_experience TEXT,
    resume LONGBLOB, -- Stores the PDF file
    role ENUM('Protocol Unit', 'Multimedia Unit', 'Food Unit') NOT NULL,
    commitment ENUM('Yes', 'No') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table Crew Details created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>