<?php
include 'config.php'; // Include your database connection settings

session_start(); // Start the session (if not already started)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $userID = $_SESSION['user_id']; // Retrieve the user ID from the session
        $fbDescription = $_POST['fbDescription'];
        $fbStatus = $_POST['fbStatus'];
        $fbDate = $_POST['fbDate'];

        // Call the InsertFeedback stored procedure
        $stmt = $conn->prepare("CALL InsertFeedback(?, ?, ?, ?)");
        $stmt->bind_param("ssis", $userID, $fbDescription, $fbStatus, $fbDate);

        if ($stmt->execute()) {
            // Feedback submitted successfully
            header("Location: Index.php"); // Redirect the user to Index.php
            exit;
        } else {
            // Error occurred while inserting feedback
            echo "Failed to submit feedback.";
        }
        $stmt->close();
    } else {
        // User is not logged in, handle accordingly
        echo "You must be logged in to submit feedback.";
    }
} else {
    // Handle the case where this script is not accessed via a POST request.
    echo "Invalid request.";
}

$conn->close(); // Close the database connection
?>
