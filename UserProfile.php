<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
<?php
// Check if the user is logged in
session_start();
if (isset($_SESSION['user_id'])) {
    // User is logged in, retrieve user properties from the database
    include 'config.php';
    $uid = $_SESSION['user_id'];

    $sql = "SELECT * FROM property WHERE uid = '$uid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User owns properties, display them
        echo '<h2>Here is the list of Properties you have Listed for Sale</h2>';
        echo '<table border="1">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Bedrooms</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Price</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["title"] . '</td>';
            echo '<td>' . $row["description"] . '</td>';
            echo '<td>' . $row["bedrooms"] . '</td>';
            echo '<td>' . $row["size"] . '</td>';
            echo '<td>' . $row["type"] . '</td>';
            echo '<td>' . $row["price"] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        // User doesn't own any properties
        echo "You don't own any properties. ";
        echo 'Go to the <a href="Index.php">home page</a> to buy one now.';
    }

    // Add a button to add a new property
    echo '<br><br>';
    echo '<form method="post" action="AddProperty.php">';
    echo '<input type="submit" name="add_property" value="Add a New Listing">';
    echo '</form>';

    $conn->close();
} else {
    // User is not logged in, show a pop-up message
    echo '<script>alert("Please log in to view your profile.");</script>';
}
?>
</body>
</html>
