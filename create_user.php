

<?php
 
require ("config.php"); //read up on php includes https://www.w3schools.com/php/php_includes.asp


$sql = "CREATE TABLE User (
 		 user_id INT AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(100) UNIQUE,
     email VARCHAR(100) UNIQUE,
     password VARCHAR(12),
 		 level int(3) /*level 1 - Participant, level 2 - Organizer, level 3- Administrator)*/
    )";

if (mysqli_query($conn, $sql)) {
  echo "<h3>Table user created successfully</h3>";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>