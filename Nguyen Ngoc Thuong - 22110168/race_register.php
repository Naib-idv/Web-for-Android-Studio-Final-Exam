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
$race_id = $_GET['race_id']; // Lấy ID cuộc thi từ URL

// Lấy thông tin về cuộc thi từ bảng marathon
$query = "SELECT * FROM marathon WHERE MarathonID = '$race_id'";
$result = mysqli_query($conn, $query);

// Kiểm tra nếu truy vấn thành công và có kết quả
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Không tìm thấy thông tin cuộc thi.";
    exit();
}

$race_info = mysqli_fetch_assoc($result);

$raceName = $race_info['RaceName'];
$raceDate = $race_info['Date'];
$imagePath = "Image/map" . $race_id . ".jpg"; // Đường dẫn ảnh

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Race - Hanoi Marathon</title>
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
                <li><a href="account.php">Account</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="race-details" class="center-content">
            <h2>Register Race: <?php echo htmlspecialchars($raceName); ?></h2>
            <p>Race Date: <?php echo htmlspecialchars($raceDate); ?></p>
            <img src="Image/map<?php echo $race_id; ?>.jpg" alt="Race Image" class="race-image1">

            <form action="submit_participation.php" method="POST">
            <label for="hotel">Hotel (or "My home"):</label>
            <input type="text" name="hotel" id="hotel" required placeholder="Enter your hotel or 'My home'">

            <input type="hidden" name="race_id" value="<?php echo $race_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <button type="submit">Submit</button>

            <p>Pls check your account after submit and the entry number information is not null which means you have registered successfully!!</p>
            </form>
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
