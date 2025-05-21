<?php
// Include the database connection
include('db_connection.php');

// Fetch the marathon and user IDs from the URL parameters
if (isset($_GET['marathon_id']) && isset($_GET['user_id'])) {
    $marathonID = $_GET['marathon_id'];
    $userID = $_GET['user_id'];

    // Prepare the SQL query to fetch the participation details for the given MarathonID and UserID
    $query = "SELECT * FROM participate WHERE MarathonID = ? AND UserID = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ii", $marathonID, $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        // If a record is found, fetch the data
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Participation not found.";
            exit;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
} else {
    echo "No MarathonID or UserID specified.";
    exit;
}

// Handle the form submission to update participation details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new data from the form
    $entryNO = $_POST['EntryNO'];
    $timeRecord = $_POST['TimeRecord'];
    $standings = $_POST['Standings'];
    $hotel = $_POST['Hotel'];

    // Prepare the update query
    $updateQuery = "UPDATE participate SET EntryNO = ?, TimeRecord = ?, Standings = ?, Hotel = ? WHERE MarathonID = ? AND UserID = ?";

    if ($updateStmt = $conn->prepare($updateQuery)) {
        $updateStmt->bind_param("isssii", $entryNO, $timeRecord, $standings, $hotel, $marathonID, $userID);

        // Execute the update query
        if ($updateStmt->execute()) {
            echo "Participation updated successfully.";
        } else {
            echo "Error updating participation: " . $updateStmt->error;
        }
    } else {
        echo "Error preparing update statement: " . $conn->error;
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Participation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color:rgb(91, 245, 248);
            font-size: 28px;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color:rgb(110, 255, 233);
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: rgb(91, 245, 248);
            font-size: 16px;
            font-weight: bold;
        }

        .back-link a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Edit Participation</h1>

        <form method="post">
            <div class="form-group">
                <label for="EntryNO">Entry Number:</label>
                <input type="text" id="EntryNO" name="EntryNO" value="<?php echo htmlspecialchars($row['EntryNO']); ?>" required>
            </div>

            <div class="form-group">
                <label for="TimeRecord">Time Record:</label>
                <input type="text" id="TimeRecord" name="TimeRecord" value="<?php echo htmlspecialchars($row['TimeRecord']); ?>" required>
            </div>

            <div class="form-group">
                <label for="Standings">Standings:</label>
                <input type="text" id="Standings" name="Standings" value="<?php echo htmlspecialchars($row['Standings']); ?>" required>
            </div>

            <div class="form-group">
                <label for="Hotel">Hotel:</label>
                <input type="text" id="Hotel" name="Hotel" value="<?php echo htmlspecialchars($row['Hotel']); ?>">
            </div>

            <input type="submit" value="Update Participation">
        </form>

        <div class="back-link">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
