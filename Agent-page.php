<!DOCTYPE html>
<html>
<head>
    <title>Real Estate Management Website - Agents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            background: url('index-background.jpg') fixed;
            background-size: cover;
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
        .agent {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            background: #f9f9f9;
        }
        h2 {
            font-size: 20px;
        }
        h3 {
            font-size: 16px;
            color: #33A1DE;
        }
        p {
            font-size: 14px;
        }
        .agent-phones {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Take your pick from our select set of agents</h1>
    </div>
    <div class="container">
        <!-- List of Agents -->
        <?php
        include 'config.php';

        $sql = "SELECT agent.*, GROUP_CONCAT(agent_phone.aphone) AS phones 
                FROM agent
                LEFT JOIN agent_phone ON agent.aid = agent_phone.aid
                GROUP BY agent.aid";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Check if agent name is not "NA NA"
                if ($row["fname"] !== 'NA' || $row["lname"] !== 'NA') {
                    echo '<div class="agent">';
                    echo '<h2>' . $row["fname"] . ' ' . $row["lname"] . '</h2>';
                    echo '<h3>Email: ' . $row["aemail"] . '</h3>';
                    echo '<h3>Phone Numbers:</h3>';
                    if (!empty($row["phones"])) {
                        $phones = explode(',', $row["phones"]);
                        foreach ($phones as $phone) {
                            echo '<p class="agent-phones">' . $phone . '</p>';
                        }
                    }
                    echo '</div>';
                }
            }
        } else {
            echo "No agents found.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
