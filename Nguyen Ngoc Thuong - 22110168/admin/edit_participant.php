<?php
// Include the database connection
include('db_connection.php');

// Check if an ID is passed in the URL
if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Prepare the SQL query to fetch the participant details based on UserID
    $query = "SELECT * FROM participant WHERE UserID = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the participant is found, fetch the data
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Participant not found.";
            exit;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
} else {
    echo "No participant ID specified.";
    exit;
}

// Handle the form submission to update participant details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new data from the form
    $name = $_POST['Name'];
    $email = $_POST['E_mail'];
    $nationality = $_POST['Nationality'];
    $passportNo = $_POST['PassportNO'];
    $sex = $_POST['Sex'];
    $age = $_POST['Age'];
    $phoneNum = $_POST['Phone_number'];
    $address = $_POST['Address'];

    // Prepare the update query
    $updateQuery = "UPDATE participant SET Name = ?, E_mail = ?, Nationality = ?, PassportNO = ?, Sex = ?, Age = ?, Phone_number = ?, Address = ? WHERE UserID = ?";
    
    if ($updateStmt = $conn->prepare($updateQuery)) {
        $updateStmt->bind_param("ssssiisssi", $name, $email, $nationality, $passportNo, $sex, $age, $phoneNum, $address, $userID);

        // Execute the update query
        if ($updateStmt->execute()) {
            echo "Participant updated successfully.";
        } else {
            echo "Error updating participant: " . $updateStmt->error;
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
    <title>Edit Participant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
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
        input[type="email"],
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
        <h1>Edit Participant</h1>

        <form method="post">
            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($row['Name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="E_mail">Email:</label>
                <input type="email" id="E_mail" name="E_mail" value="<?php echo htmlspecialchars($row['E_mail']); ?>" required>
            </div>

            <div class="form-group">
                <label for="Nationality">Nationality:</label>
                <input type="text" id="Nationality" name="Nationality" value="<?php echo htmlspecialchars($row['Nationality']); ?>">
            </div>

            <div class="form-group">
                <label for="PassportNO">Passport No:</label>
                <input type="text" id="PassportNO" name="PassportNO" value="<?php echo htmlspecialchars($row['PassportNO']); ?>">
            </div>

            <div class="form-group">
                <label for="Sex">Sex:</label>
                <input type="text" id="Sex" name="Sex" value="<?php echo htmlspecialchars($row['Sex']); ?>">
            </div>

            <div class="form-group">
                <label for="Age">Age:</label>
                <input type="number" id="Age" name="Age" value="<?php echo htmlspecialchars($row['Age']); ?>">
            </div>

            <div class="form-group">
                <label for="Phone_number">Phone Number:</label>
                <input type="text" id="Phone_number" name="Phone_number" value="<?php echo htmlspecialchars($row['Phone_number']); ?>">
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" id="Address" name="Address" value="<?php echo htmlspecialchars($row['Address']); ?>">
            </div>

            <input type="submit" value="Update Participant">
        </form>

        <div class="back-link">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
