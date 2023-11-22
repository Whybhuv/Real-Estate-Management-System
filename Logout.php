<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, destroy the session to log them out
    session_destroy();

    // Redirect the user to the login page after logging out
    header("Location: Index.php");
    exit();
} else {
    // User is not logged in, redirect them to the login page
    header("Location: Login.php");
    exit();
}
