<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'eventure';
$username = 'root';
$password = '';

try {
    // Establish the PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL statement to create the `events` table if it doesn't already exist
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS events (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            organizer VARCHAR(255) NOT NULL,
            description TEXT,
            location VARCHAR(255),
            date DATE,
            time TIME,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ";

    // Execute the create table statement
    $pdo->exec($createTableSQL);

} catch (PDOException $e) {
    // Display the error if the connection or table creation fails
    die("Database connection failed: " . $e->getMessage());
}
?>

