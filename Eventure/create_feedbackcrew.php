<?php 
require("config.php"); // Including the config file

$sql = "CREATE TABLE FeedbackCrew (
    feedback_crew_id INT AUTO_INCREMENT PRIMARY KEY,
    crew_id INT,
    crew_name VARCHAR(255),
    from_id INT,
    feedback_text TEXT,
    rating INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (crew_id) REFERENCES Event_Crew(crew_id), -- Adjust 'Crew' table name as needed
    FOREIGN KEY (from_id) REFERENCES Club(club_id)
)";

if (mysqli_query($conn, $sql)) {
    echo "<h3>Table FeedbackCrew created successfully</h3>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
