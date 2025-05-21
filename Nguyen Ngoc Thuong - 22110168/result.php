<?php
include 'db/connect.php';

// Lấy ngày hiện tại
$current_date = date('Y-m-d');

// Lấy danh sách các cuộc thi đã diễn ra (so sánh ngày diễn ra với ngày hiện tại)
$query = "SELECT MarathonID, RaceName, Date FROM marathon WHERE Date < '$current_date' ORDER BY Date";
$result = mysqli_query($conn, $query);

// Kiểm tra kết quả truy vấn
if (!$result) {
    echo "Lỗi khi truy vấn cơ sở dữ liệu.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race Results - Hanoi Marathon</title>
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
        <section id="race-list">
            <h2>RACE</h2>
            <div class="race-container">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="race-item">
                        <h3><a href="result_details.php?race_id=<?php echo $row['MarathonID']; ?>"><?php echo htmlspecialchars($row['RaceName']); ?></a></h3>
                        <p><?php echo htmlspecialchars($row['Date']); ?></p>
                    </div>
                <?php } ?>
            </div>
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
</body>
</html>
