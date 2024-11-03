<?php
// Include the configuration file for database connection
require("config.php"); 

$sql = "CREATE TABLE Club_Membership (
    user_id INT,
    club_id INT,
    position VARCHAR(50),
    join_date DATE,
    status ENUM('active', 'inactive'),
    FOREIGN KEY (user_id) REFERENCES User(user_id),
    FOREIGN KEY (club_id) REFERENCES Club(club_id)  -- Ensure club_id is the correct reference
)";

if (mysqli_query($conn, $sql)) {
    echo "<h3>Table Club_Membership created successfully</h3>";  // Updated message
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
