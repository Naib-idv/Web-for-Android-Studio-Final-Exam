<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['Name'];
    $email = $_POST['E_mail'];
    $nationality = $_POST['Nationality'];
    $passport_no = $_POST['PassportNO'];
    $sex = $_POST['Sex'];
    $age = $_POST['Age'];
    $phone_num = $_POST['Phone_number'];
    $address = $_POST['Address'];

    // Prepare SQL to insert participant
    $query = "INSERT INTO participant (Name, E_mail, Nationality, PassportNO, Sex, Age, Phone_number, Address) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssssiis", $name, $email, $nationality, $passport_no, $sex, $age, $phone_num, $address);

        if ($stmt->execute()) {
            echo "Participant added successfully!";
        } else {
            echo "Error adding participant: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Participant</title>
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
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color: rgb(10, 159, 172);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 18px;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: rgb(10, 159, 172);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .cancel {
            text-align: center;
            margin-top: 20px;
        }

        .cancel a {
            text-decoration: none;
            font-size: 16px;
            color: rgb(10, 159, 172);
        }

        .cancel a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Add New Participant</h1>

        <form method="POST">
            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" id="Name" name="Name" required>
            </div>

            <div class="form-group">
                <label for="E_mail">Email:</label>
                <input type="email" id="E_mail" name="E_mail" required>
            </div>

            <div class="form-group">
                <label for="Nationality">Nationality:</label>
                <input type="text" id="Nationality" name="Nationality" required>
            </div>

            <div class="form-group">
                <label for="PassportNO">Passport No:</label>
                <input type="text" id="PassportNO" name="PassportNO" required>
            </div>

            <div class="form-group">
                <label for="Sex">Sex:</label>
                <select id="Sex" name="Sex" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Age">Age:</label>
                <input type="number" id="Age" name="Age" required>
            </div>

            <div class="form-group">
                <label for="Phone_number">Phone Number:</label>
                <input type="text" id="Phone_number" name="Phone_number" required>
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" id="Address" name="Address" required>
            </div>

            <input type="submit" value="Add Participant">
        </form>

        <div class="cancel">
            <a href="admin_dashboard.php">Cancel and Return to Dashboard</a>
        </div>
    </div>

</body>
</html>
