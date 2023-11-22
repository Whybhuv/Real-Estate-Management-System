<?php
session_start();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Real Estate Management Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('index-background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            opacity: 1; /* Slight background image opacity */
        }
        .header {
            text-align: right;
            padding: 10px;
            background: green;
            padding: 30px;
            opacity: 1;
        }
        .header a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            margin-right: 10px; /* Add margin to separate the links */
        }
        .header a:hover {
            color: #33A1DE;
            background: black;
            padding: 10px 10px 25px; /* Adjust the padding to create a sliding-up effect */
        }
        .welcome {
            text-align: center;
            color: #33A1DE;
            font-size: 36px;
            margin-top: 20px; /* Centered heading and increased margin-top */
            background: black; /* Background color set to black */
            padding: 20px; /* Added padding for better visibility */
            opacity: 0.9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin-top: 20px;
        }
        .property {
            margin-bottom: 20px;
        }
        .property h3 {
            font-size: 24px;
            color: #33A1DE;
        }
        .property p {
            font-size: 16px;
        }
        /* Styles for the filter form */
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            margin-right: 10px;
        }
        select {
            padding: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background: #33A1DE;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        /* Styles for the agent details modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }
        .modal-content {
            background-color: #f4f4f4;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            position: relative;
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #888;
            cursor: pointer;
        }
        .details-button {
            background: #33A1DE;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        
        /* Styles for the feedback section */
        .feedback-section {
            margin-top: 20px;
        }

        .feedback-section h2 {
            font-size: 24px;
            color: black;
            background-color: white;
        }

        .feedback-section ul {
            list-style: none;
            padding: 0;
        }

        .feedback-section li {
            border: 1px solid #ccc;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            background-color: white;
            opacity: 0.9;
        }

        .feedback-section li strong {
            color: #33A1DE;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="Agent-page.php" style="text-align: left; margin-right: 1000px;">Find an Agent</a>
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="Logout.php">Logout</a>';
        } else {
            echo '<a href="Login.php">Login / Register</a>';
        }
        ?>
        <a href="UserProfile.php">User Profile</a>
    </div>
    <div class= "welcome">
        Welcome to Real Estate Management Website
    </div>
    <div class="container">
        <h2>Available Properties</h2>

        <!-- Filter Form -->
        <form method="post">
            <label for="propertyType">Filter by Type:</label>
            <select name="propertyType" id="propertyType">
                <option value="">All Types</option>
                <?php
                include 'config.php';
                $sql = "SELECT DISTINCT type FROM property"; // Query for distinct property types
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $propertyType = $row["type"];
                    echo '<option value="' . $propertyType . '">' . $propertyType . '</option>';
                }
                $conn->close();
                ?>
            </select>


            <label for="city">Filter by City:</label>
            <select name="city" id="city">
                <option value="">All Cities</option>
                <?php
                include 'config.php';
                $sql = "SELECT * FROM city";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["cid"] . '">' . $row["cname"] . '</option>';
                }
                $conn->close();
                ?>
            </select>

            <input type="submit" value="Apply Filters">
        </form>
        
        <!-- Search Form -->
        <form method="post">
            <label for="searchKeyword">Search for properties:</label>
            <input type="text" name="searchKeyword">
            <input type="submit" value="Search">
        </form>

        <!-- Property List -->
        <?php
        include 'config.php';

        // Check if a search keyword is provided
        if (isset($_POST['searchKeyword'])) {
            $searchKeyword = $_POST['searchKeyword'];
            $searchKeyword = mysqli_real_escape_string($conn, $searchKeyword);

            // Query properties matching the search keyword
            $sql = "SELECT * FROM property WHERE `description` LIKE '%$searchKeyword%'";
        } else {
            // Query properties with filters
            $propertyTypeFilter = isset($_POST['propertyType']) ? $_POST['propertyType'] : '';
            $cityFilter = isset($_POST['city']) ? $_POST['city'] : '';

            $sql = "SELECT * FROM property WHERE 1";

            if (!empty($propertyTypeFilter)) {
                $sql .= " AND type = '$propertyTypeFilter'";
            }

            if (!empty($cityFilter)) {
                $sql .= " AND cid = '$cityFilter'";
            }
    
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $propertyID = $row["pid"];
                $propertyTitle = $row["title"];
                $propertyDescription = $row["description"];
                $propertyBedrooms = $row["bedrooms"];
                $propertySize = $row["size"];
                $propertyType = $row["type"];
                $propertyPrice = number_format($row["price"]);
        
                $agentID = $row["aid"]; // Get the agent ID

                // Fetch agent details using the agent ID
                $agentQuery = "SELECT CONCAT(fname, ' ', lname) AS aname, aemail FROM agent WHERE aid = '$agentID'";
                $agentResult = $conn->query($agentQuery);

                if ($agentResult) {
                    $agentData = $agentResult->fetch_assoc();
                    $agentName = $agentData["aname"];
                    $agentEmail = $agentData["aemail"];
                } else {
                    $agentName = "N/A";
                    $agentEmail = "N/A";
                }
        
                echo '<div class="property">';
                echo '<h3>' . $propertyTitle . '</h3>';
                echo '<p>' . $propertyDescription . '</p>';
                echo '<p>Bedrooms: ' . $propertyBedrooms . '</p>';
                echo '<p>Size: ' . $propertySize . ' sq. ft.</p>';
                echo '<p>Type: ' . $propertyType . '</p>';
                echo '<p>Price: Rs.' . $propertyPrice . '</p>';
                echo '<button class="details-button" onclick="showAgentDetails(\'' . $agentName . '\', \'' . $agentEmail . '\', \'' . $propertyID . '\')">I\'m interested in this property</button>';
                echo '</div>';
            }
        } else {
            echo "No properties found.";
        }
        
        $sqlFeedback = "SELECT f.fid, CONCAT(u.fname, ' ', u.lname) AS username, f.fdescription, f.date, f.status
        FROM feedback f
        JOIN user u ON f.uid = u.uid";
        $resultFeedback = $conn->query($sqlFeedback);

        $conn->close();
        ?>

        <!-- Agent Details Modal -->
        <div id="agentModal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeAgentModal()">&times;</span>
                <div id="agentDetails"></div>
                <button id="buyButton" onclick="buyProperty()">Buy Property</button>
            </div>
        </div>
        <script>
            var currentPropertyID;

            function showAgentDetails(agentName, agentEmail, propertyID) {
                var agentDetails = "Agent Name: " + agentName + "<br>Email: " + agentEmail;
                document.getElementById("agentDetails").innerHTML = agentDetails;
                currentPropertyID = propertyID;
                var modal = document.getElementById("agentModal");
                modal.style.display = "block";
            }


            function buyProperty() {
                // Call a PHP script to delete the property
                if (currentPropertyID) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "buy_property.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = xhr.responseText;
                            if (response === "success") {
                                alert("Property bought successfully.");
                                var modal = document.getElementById("agentModal");
                                modal.style.display = "none";
                                // Reload the page or update the property list as needed
                            } else {
                                alert("Failed to buy the property.");
                            }
                        }
                    };
                    xhr.send("propertyID=" + currentPropertyID);
                }
            }

            function closeAgentModal() {
                var modal = document.getElementById("agentModal");
                modal.style.display = "none";
            }
            <!-- Add this JavaScript code at the end of your HTML body section -->
            function showFeedbackForm() {
                var feedbackForm = document.getElementById("feedbackForm");
                feedbackForm.style.display = "block";
            }

            function hideFeedbackForm() {
                var feedbackForm = document.getElementById("feedbackForm");
                feedbackForm.style.display = "none";
            }

        </script> 
    </div>
    <!-- Feedback Section -->
    <div class="feedback-section">
        <h2>User Feedback</h2>
        <button id="submitFeedbackButton" onclick="showFeedbackForm()">Submit Feedback</button>
        <!-- Add this HTML code below your User Feedback section -->
        <div id="feedbackForm" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close-button" onclick="hideFeedbackForm()">&times;</span>
                <h2>Submit Feedback</h2>
                <form method="post" action="submit-feedback.php">
                    
                    <label for="fbDescription">Description:</label>
                    <textarea name="fbDescription" required></textarea><br>

                    <label for="fbStatus">Status:</label>
                    <select name="fbStatus" required>
                        <option value="1">Positive</option>
                        <option value="0">Negative</option>
                    </select><br>

                    <label for="fbDate">Date:</label>
                    <input type="date" name="fbDate" required><br>

                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>

        <ul>
            <?php

            while ($rowFeedback = $resultFeedback->fetch_assoc()) {
                $feedbackID = $rowFeedback["fid"];
                $feedbackUsername = $rowFeedback["username"];
                $feedbackDescription = $rowFeedback["fdescription"];
                $feedbackDate = $rowFeedback["date"];
                $feedbackStatus = $rowFeedback["status"] == 1 ? 'Positive' : 'Negative';

                echo '<li>';
                echo '<strong>User: ' . $feedbackUsername . '</strong>';
                echo '<p>Feedback: ' . $feedbackDescription . '</p>';
                echo '<p>Date: ' . $feedbackDate . '</p>';
                echo '<p>Status: ' . $feedbackStatus . '</p>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>

</body>
</html>