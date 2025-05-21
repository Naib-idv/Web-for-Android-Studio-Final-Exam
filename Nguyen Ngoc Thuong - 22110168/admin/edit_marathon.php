<?php
// Assuming a connection to the database is already established
include('db_connection.php');

// Fetch the marathon details based on the 'id' passed in the URL
if (isset($_GET['id'])) {
    $marathonID = $_GET['id'];
    $query = "SELECT * FROM marathon WHERE MarathonID = ?";

    // Check if the prepare statement works
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $marathonID);
        $stmt->execute();
        $result = $stmt->get_result();

        // If a marathon is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Marathon not found.";
            exit;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
} else {
    echo "No marathon ID specified.";
    exit;
}

// Handle form submission to update marathon details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raceName = $_POST['RaceName'];
    $date = $_POST['Date'];

    $updateQuery = "UPDATE marathon SET RaceName = ?, Date = ? WHERE MarathonID = ?";

    // Check if the update prepare statement works
    if ($updateStmt = $conn->prepare($updateQuery)) {
        $updateStmt->bind_param("ssi", $raceName, $date, $marathonID);

        if ($updateStmt->execute()) {
            echo "Marathon updated successfully.";
        } else {
            echo "Error updating marathon: " . $updateStmt->error;
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
    <title>Edit Marathon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 28px;
            color: rgb(10, 159, 172);
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="date"] {
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: rgb(10, 159, 172);
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
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
            color: rgb(10, 159, 172);
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
        <h1>Edit Marathon</h1>

        <form method="post">
            <div class="form-group">
                <label for="RaceName">Race Name:</label>
                <input type="text" id="RaceName" name="RaceName" value="<?php echo htmlspecialchars($row['RaceName']); ?>" required>
            </div>

            <div class="form-group">
                <label for="Date">Date:</label>
                <input type="date" id="Date" name="Date" value="<?php echo htmlspecialchars($row['Date']); ?>" required>
            </div>

            <input type="submit" value="Update Marathon">
        </form>

        <div class="back-link">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>