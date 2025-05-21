<?php
include 'db/connect.php';

// Kiểm tra nếu có tham số race_id trong URL
if (isset($_GET['race_id'])) {
    $race_id = $_GET['race_id'];

    // Lấy thông tin về cuộc thi từ bảng marathon
    $query_race = "SELECT * FROM marathon WHERE MarathonID = '$race_id'";
    $result_race = mysqli_query($conn, $query_race);
    $race_info = mysqli_fetch_assoc($result_race);

    if (!$race_info) {
        echo "Không tìm thấy thông tin cuộc thi.";
        exit();
    }

    // Lấy danh sách thí sinh tham gia cuộc thi từ bảng participate, sắp xếp theo Standings
    $query_participants = "SELECT p.UserID, p.EntryNO, p.Hotel, p.TimeRecord, p.Standings, u.Name
                           FROM participate p
                           JOIN participant u ON p.UserID = u.UserID
                           WHERE p.MarathonID = '$race_id'
                           ORDER BY p.Standings ASC";

    $result_participants = mysqli_query($conn, $query_participants);

    if (!$result_participants) {
        echo "Lỗi khi truy vấn bảng tham gia.";
        exit();
    }
} else {
    echo "Không có ID cuộc thi.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race Details - Hanoi Marathon</title>
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
            <h2>Race: <?php echo htmlspecialchars($race_info['RaceName']); ?></h2>
            <p>Race Date: <?php echo htmlspecialchars($race_info['Date']); ?></p>

            <h3>Stadings Table</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Standing</th>
                            <th>Participant Name</th>
                            <th>Entry Number</th>
                            <th>Hotel</th>
                            <th>Time Record</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rank = 1;
                        while ($participant = mysqli_fetch_assoc($result_participants)) {
                        ?>
                            <tr>
                                <td><?php echo $rank++; ?></td>
                                <td><?php echo htmlspecialchars($participant['Name']); ?></td>
                                <td><?php echo htmlspecialchars($participant['EntryNO']); ?></td>
                                <td><?php echo htmlspecialchars($participant['Hotel']); ?></td>
                                <td><?php echo htmlspecialchars($participant['TimeRecord']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
