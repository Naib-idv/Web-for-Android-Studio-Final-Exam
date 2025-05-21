<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Handle the form submission to add a new marathon
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raceName = $_POST['RaceName'];
    $date = $_POST['Date'];

    // Prepare the insert query
    $insertQuery = "INSERT INTO marathon (RaceName, Date) VALUES (?, ?)";

    if ($stmt = $conn->prepare($insertQuery)) {
        $stmt->bind_param("ss", $raceName, $date);

        // Execute the insert query
        if ($stmt->execute()) {
            echo "Marathon added successfully.";
        } else {
            echo "Error adding marathon: " . $stmt->error;
        }
    } else {
        echo "Error preparing insert statement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Marathon</title>
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: rgb(10, 159, 172);
            font-size: 28px;
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
            color: #4CAF50;
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
        <h1>Add Marathon</h1>

        <form method="post">
            <label for="RaceName">Race Name:</label>
            <input type="text" id="RaceName" name="RaceName" required>

            <label for="Date">Date:</label>
            <input type="date" id="Date" name="Date" required>

            <input type="submit" value="Add Marathon">
        </form>

        <div class="back-link">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
