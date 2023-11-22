<?php
// Include database connection settings
include 'config.php';

// Function to sanitize input data
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle form submission to add an admin
// Handle form submission to add an admin
if (isset($_POST['addAdmin'])) {
    $adminFname = sanitizeData($_POST['adminFname']);
    $adminLname = sanitizeData($_POST['adminLname']);
    $adminPassword = sanitizeData($_POST['adminPassword']);
    $adminEmail = sanitizeData($_POST['adminEmail']);

    // Insert the user as an admin
    $insertAdminSql = "CALL RegisterAdmin('$adminFname', '$adminLname', '$adminPassword', '$adminEmail')";
    if ($conn->query($insertAdminSql)) {
        echo "Admin added successfully.";
    } else {
        echo "Failed to add admin: " . mysqli_error($conn);
    }
}

// Handle form submission to delete a user and their properties
if (isset($_POST['deleteUser'])) {
    $userUidToDelete = sanitizeData($_POST['userUidToDelete']);

    // Temporarily disable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Begin a transaction
    $conn->begin_transaction();

    // Delete the user's feedback
    $deleteFeedbackSql = "DELETE FROM `feedback` WHERE uid = '$userUidToDelete'";
    if ($conn->query($deleteFeedbackSql)) {
        // Delete the user's properties
        $deletePropertiesSql = "DELETE FROM `property` WHERE uid = '$userUidToDelete'";
        if ($conn->query($deletePropertiesSql)) {
            // Delete the user
            $deleteUserSql = "DELETE FROM `user` WHERE uid = '$userUidToDelete'";
            if ($conn->query($deleteUserSql)) {
                // Commit the transaction if everything is successful
                $conn->commit();
                echo "User, their properties, and feedback deleted successfully.";
            } else {
                // Rollback the transaction if deleting the user fails
                $conn->rollback();
                echo "Failed to delete user: " . mysqli_error($conn);
            }
        } else {
            // Rollback the transaction if deleting properties fails
            $conn->rollback();
            echo "Failed to delete user properties: " . mysqli_error($conn);
        }
    } else {
        // Rollback the transaction if deleting feedback fails
        $conn->rollback();
        echo "Failed to delete user feedback: " . mysqli_error($conn);
    }

    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS=1");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background: url('index-background.jpg') fixed;
            background-size: cover;
            
        }
        h1 {
            text-align: center;
            background-color: #007BFF;
            color: #fff;
            padding: 20px;
        }
        form {
            background-color: #fff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Admin Page</h1>

    <!-- Form to add an admin -->
    <form method="post" action="admin-page.php">
        <h2>Add Admin</h2>
        <input type="text" name="adminFname" placeholder="First Name" required><br>
        <input type="text" name="adminLname" placeholder="Last Name" required><br>
        <input type="password" name="adminPassword" placeholder="Password" required><br>
        <input type="email" name="adminEmail" placeholder="Email" required><br>
        <input type="submit" name="addAdmin" value="Add Admin">
    </form>

    <!-- Form to delete a user and their properties -->
    <form method="post" action="admin-page.php">
        <h2>Delete User and Their Properties</h2>
        <input type="text" name="userUidToDelete" placeholder="User ID to Delete" required><br>
        <input type="submit" name="deleteUser" value="Delete User">
    </form>

    <!-- Add more forms for altering users and properties as needed -->

</body>
</html>
