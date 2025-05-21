<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php'); // Include your database connection

// Get the admin username from the URL parameter
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Prepare a query to fetch the admin details by username
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username); // Bind the username as a parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the admin details
        $row = $result->fetch_assoc();
    } else {
        echo "Admin not found.";
        exit();
    }
} else {
    echo "No admin username specified.";
    exit();
}

// Handle form submission to update admin details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    // Prepare the update query
    $updateQuery = "UPDATE admin SET username = ?, pass = ? WHERE username = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sss", $newUsername, $newPassword, $username); // Bind parameters

    if ($updateStmt->execute()) {
        echo "Admin details updated successfully.";
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard after updating
        exit();
    } else {
        echo "Error updating admin details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 28px;
            color: rgb(10, 159, 172);
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: rgb(10, 159, 172);
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
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
        <h1>Edit Admin</h1>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($row['pass']); ?>" required>
            </div>

            <input type="submit" value="Update Admin">
        </form>

        <div class="back-link">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
