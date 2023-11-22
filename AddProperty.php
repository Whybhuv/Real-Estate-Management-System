<?php
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_property"])) {
    // Initialize variables with default values
    $cityName = $stateName = $propTitle = $propDescription = $propBedrooms = $propSize = $propType = $propPrice = "";

    // Check if the form fields are set before using them
    if (isset($_POST["cityName"])) {
        $cityName = sanitizeData($_POST["cityName"]);
    }
    if (isset($_POST["stateName"])) {
        $stateName = sanitizeData($_POST["stateName"]);
    }
    if (isset($_POST["propTitle"])) {
        $propTitle = sanitizeData($_POST["propTitle"]);
    }
    if (isset($_POST["propDescription"])) {
        $propDescription = sanitizeData($_POST["propDescription"]);
    }
    if (isset($_POST["propBedrooms"])) {
        $propBedrooms = sanitizeData($_POST["propBedrooms"]);
    }
    if (isset($_POST["propSize"])) {
        $propSize = sanitizeData($_POST["propSize"]);
    }
    if (isset($_POST["propType"])) {
        $propType = sanitizeData($_POST["propType"]);
    }
    if (isset($_POST["propPrice"])) {
        $propPrice = sanitizeData($_POST["propPrice"]);
    }

    // Get user and agent IDs from the session, or from your authentication system
    session_start();
    $uid = $_SESSION['user_id'];
    $aid = "A01"; // Replace with the actual agent ID (you may have a method to retrieve it)

    // Call the stored procedure to add the property
    $sql = "CALL AddProperty('$uid', '$aid', '$cityName', '$stateName', '$propTitle', '$propDescription', $propBedrooms, $propSize, '$propType', $propPrice)";
    
    if ($conn->query($sql)) {
        // Property added successfully, redirect to Index.php
        header("Location: Index.php");
        exit;
    } else {
        // Error in adding property
        echo "Error adding property: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            padding: 20px;
            background: #33A1DE;
            color: white;
            font-size: 24px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            opacity:0.9;
        }

    </style>
</head>
<body>
    <h1>Add a New Property Listing</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="cityName">City Name:</label>
        <input type="text" name="cityName" required><br>

        <label for="stateName">State Name:</label>
        <input type="text" name="stateName" required><br>

        <label for="propTitle">Property Title:</label>
        <input type="text" name="propTitle" required><br>

        <label for="propDescription">Property Description:</label>
        <input type="text" name="propDescription" required><br>

        <label for="propBedrooms">Bedrooms:</label>
        <input type="number" name="propBedrooms" required><br>

        <label for="propSize">Size (in sq. ft.):</label>
        <input type="number" name="propSize" required><br>

        <label for="propType">Property Type:</label>
        <input type="text" name="propType" required><br>

        <label for="propPrice">Price:</label>
        <input type="number" name="propPrice" required><br>

        <input type="submit" name="add_property" value="Add Property">
    </form>
</body>
</html>
