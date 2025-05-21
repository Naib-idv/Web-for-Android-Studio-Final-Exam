<?php
session_start(); // Bắt đầu session
include 'db/connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng đã đăng nhập thì chuyển hướng đến trang account.php
if (isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

// Kiểm tra xem REQUEST_METHOD có tồn tại không
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Kiểm tra tài khoản
    $query = "SELECT * FROM account WHERE E_mail = '$email' AND Password = '$password'";
    $result = mysqli_query($conn, $query);

    $result = mysqli_query($conn, $query);

    if ($result === false) {
    // Xử lý lỗi truy vấn SQL
    $error_message = "Database query failed: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            // Đăng nhập thành công
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['email'] = $user['E_mail'];

            header("Location: account.php"); // Chuyển hướng đến trang account.php
            exit();
    } else {
        $error_message = "Invalid email or password.";
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hanoi Marathon</title>
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
        <section id="login">
            <h2>Login to Your Account</h2>
            <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
            <form method="POST" action="login.php">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
            <p>If you have click Register and return to this page, it mean you successfully!!</p>
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
