<?php
include 'config.php'; // Include your database connection settings

// Function to sanitize input data
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Login form handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = sanitizeData($_POST["email"]);
    $password = sanitizeData($_POST["password"]);
    
    // Call the SQL login function to get the user ID
    $sql = "SELECT LoginUser('$email', '$password') AS user_uid";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user_uid = $row["user_uid"];
            
            if ($user_uid) {
                // Check the user type (rtype)
                $sqlCheckUserType = "SELECT rtype FROM user WHERE uid = '$user_uid'";
                $resultUserType = $conn->query($sqlCheckUserType);

                if ($resultUserType) {
                    $rowUserType = $resultUserType->fetch_assoc();
                    $userType = $rowUserType["rtype"];
                    
                    // Set the session to store user information
                    session_start();
                    $_SESSION['user_id'] = $user_uid;

                    // Redirect to different pages based on the user type
                    if ($userType === 'Admin') {
                        header("Location: admin-page.php");
                    } else {
                        header("Location: Index.php");
                    }
                    exit();
                } else {
                    echo "SQL Error: " . mysqli_error($conn);
                }
            } else {
                echo "Login failed. Incorrect email or password.";
            }
        } else {
            echo "Login failed. User not found.";
        }
    } else {
        echo "SQL Error: " . mysqli_error($conn);
    }
}

// Register user form handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $aid = sanitizeData($_POST["aid"]);
    $fname = sanitizeData($_POST["fname"]);
    $lname = sanitizeData($_POST["lname"]);
    $password = sanitizeData($_POST["password"]);
    $email = sanitizeData($_POST["email"]);

    // Call the RegisterUser stored procedure
    $stmt = $conn->prepare("CALL RegisterUser(?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $aid, $fname, $lname, $password, $email);

    if ($stmt->execute()) {
        // Registration was successful
        echo "User registered successfully. You can now <a href='Login.php'>login</a>.";
    } else {
        echo "Registration failed. Please try again or contact the administrator.";
    }
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Real Estate Website</title>
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
        h2 {
            text-align: center;
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
    <h1>Real Estate Website</h1>

    <h2>Login</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="login" value="Login">
    </form>

    <h2>Register User</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="text" name="fname" placeholder="First Name" required><br>
        <input type="text" name="lname" placeholder="Last Name" required><br>
        <input type="text" name="aid" placeholder="Agent ID" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>
