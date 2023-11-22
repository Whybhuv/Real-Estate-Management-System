<?php
$server = "localhost";
$username = "root";
$password = "CrashCourseChem@123";
$dbname = "real_estate";

// Create a connection to the database
$conn = new mysqli($server, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
