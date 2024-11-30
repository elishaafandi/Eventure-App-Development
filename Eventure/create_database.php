<?php

// Database connection settings
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'Eventure';

// Connect to MySQL Server
$conn = mysqli_connect($db_host, $db_user, $db_pass);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL to create the Eventure database
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";

if (mysqli_query($conn, $sql)) {
    echo "Database '$db_name' created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);

?>
