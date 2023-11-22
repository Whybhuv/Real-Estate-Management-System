<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['propertyID'])) {
        $propertyID = $_POST['propertyID'];

        // Add appropriate SQL code here to delete the property from the database
        $sql = "DELETE FROM property WHERE pid = '$propertyID'";
        $result = $conn->query($sql);

        if ($result) {
            echo "success";
        } else {
            echo "error";
        }
    }
}

$conn->close();
?>
