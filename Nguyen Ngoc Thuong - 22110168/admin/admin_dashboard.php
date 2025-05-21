<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Lấy dữ liệu từ các bảng
$marathonQuery = "SELECT * FROM marathon";
$participantQuery = "SELECT * FROM participant";
$participateQuery = "SELECT * FROM participate";
$adminQuery = "SELECT * FROM admin";

$marathons = $conn->query($marathonQuery);
$participants = $conn->query($participantQuery);
$participates = $conn->query($participateQuery);
$admins = $conn->query($adminQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color:rgb(10, 159, 172);
        }

        h2 {
            font-size: 24px;
            margin-top: 40px;
            color: rgb(10, 159, 172);
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: rgb(10, 159, 172);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            color: rgb(10, 159, 172);
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #45a049;
        }

        .logout {
            text-align: center;
            margin-top: 40px;
        }

        .logout a {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .logout a:hover {
            background-color: #d32f2f;
        }

        .table-container {
            margin-bottom: 40px;
        }

        .add-marathon-button {
            text-align: center;
            margin-bottom: 20px;
        }

        .add-marathon-button a {
            background-color: rgb(10, 159, 172);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            border: 2px solid rgb(10, 159, 172); /* Adding border */
        }

        .add-marathon-button a:hover {
            background-color: #45a049;
            border-color: #45a049; /* Change border color on hover */
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Marathons Table -->
        <div class="table-container">
            <h2>Marathons</h2>
            <table>
                <tr>
                    <th>MarathonID</th>
                    <th>RaceName</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $marathons->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['MarathonID']; ?></td>
                    <td><?php echo $row['RaceName']; ?></td>
                    <td><?php echo $row['Date']; ?></td>
                    <td><a href="edit_marathon.php?id=<?php echo $row['MarathonID']; ?>">Edit</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Add Marathon Button -->
        <div class="add-marathon-button">
            <a href="add_marathon.php">Add New Marathon</a>
        </div>

        <!-- Participants Table -->
        <div class="table-container">
            <h2>Participants</h2>
            <table>
                <tr>
                    <th>UserID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $participants->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['UserID']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['E_mail']; ?></td>
                    <td><a href="edit_participant.php?id=<?php echo $row['UserID']; ?>">Edit</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Add Marathon Button -->
        <div class="add-marathon-button">
            <a href="add_participant.php">Add New Participant</a>
        </div>
        
        <!-- Participates Table -->
        <div class="table-container">
            <h2>Participates</h2>
            <table>
                <tr>
                    <th>MarathonID</th>
                    <th>UserID</th>
                    <th>EntryNO</th>
                    <th>TimeRecord</th>
                    <th>Standings</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $participates->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['MarathonID']; ?></td>
                    <td><?php echo $row['UserID']; ?></td>
                    <td><?php echo $row['EntryNO']; ?></td>
                    <td><?php echo $row['TimeRecord']; ?></td>
                    <td><?php echo $row['Standings']; ?></td>
                    <td><a href="edit_participate.php?marathon_id=<?php echo $row['MarathonID']; ?>&user_id=<?php echo $row['UserID']; ?>">Edit</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Admins Table -->
        <div class="table-container">
            <h2>Admins</h2>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $admins->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['pass']; ?></td>
                    <td><a href="edit_admin.php?username=<?php echo $row['username']; ?>&user_id=<?php echo $row['username']; ?>">Edit</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Logout Button -->
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>

</body>
</html>