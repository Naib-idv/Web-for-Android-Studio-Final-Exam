<?php
ob_start();
session_start();
include 'db/connect.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ bảng participant
$query = "SELECT * FROM participant WHERE UserID = '$user_id'";
$result = mysqli_query($conn, $query);
// Kiểm tra kết quả truy vấn
if (mysqli_num_rows($result) > 0) {
    $user_info = mysqli_fetch_assoc($result);
} else {
    echo "Không tìm thấy dữ liệu.";
}

// Lấy EntryNO từ bảng participate
$entry_query = "SELECT EntryNO FROM participate WHERE UserID = '$user_id' LIMIT 1";
$entry_result = mysqli_query($conn, $entry_query);
$entry_info = mysqli_fetch_assoc($entry_result);
$entry_no = $entry_info ? $entry_info['EntryNO'] : null;

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Hanoi Marathon</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Image/logo.jpg" alt="Hanoi Marathon Logo">
            <h1>
                <span>Hanoi</span>
                <span>Marathon</span>
                
            </h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home Page</a></li>
                <li><a href="races.php">Races</a></li>
                
                <li><a href="result.php">Result</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="account">
            <h2>Welcome, <?php echo $user_info['Name']; ?>!</h2>
            <p><strong>Email:</strong> <?php echo $user_info['E_mail']; ?></p>
            <p><strong>Nationality:</strong> <?php echo $user_info['Nationality']; ?></p>
            <p><strong>Passport No:</strong> <?php echo $user_info['PassportNO']; ?></p>
            <p><strong>Sex:</strong> <?php echo $user_info['Sex']; ?></p>
            <p><strong>Age:</strong> <?php echo $user_info['Age']; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $user_info['Phone_number']; ?></p>
            <p><strong>Address:</strong> <?php echo $user_info['Address']; ?></p>
                        <p><strong>Entry No:</strong> <?php echo $entry_no; ?></p> <!-- Display EntryNO -->
        </section>
    </main>

    <footer id="contact">
        <div class="organizer-info">
            <h2>Nguyen Ngoc Thuong</h2>
            <p>Tel: Don't call me</p>
            <p>Email: <a href="mailto:VietNamJapanUniversity@gmail.com">VietNamJapanUniversity@gmail.com</a></p>
            <p>Address: Ha Noi</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>
