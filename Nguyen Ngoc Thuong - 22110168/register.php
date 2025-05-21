<?php
session_start(); // Bắt đầu phiên làm việc
include 'db/connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra nếu khóa 'REQUEST_METHOD' tồn tại trong mảng $_SERVER
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xử lý yêu cầu POST
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Lấy thông tin từ form và loại bỏ các ký tự đặc biệt
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $passportno = mysqli_real_escape_string($conn, $_POST['passportno']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Xác thực các trường dữ liệu
    $error_message = '';

    // Kiểm tra các trường có trống hay không
    if (empty($name) || empty($nationality) || empty($passportno) || empty($sex) || empty($age) || empty($email) || empty($phone_num) || empty($address) || empty($password)) {
        $error_message = "All fields are required.";
    }

    // Kiểm tra giá trị của sex có hợp lệ không
    if ($sex != 'Male' && $sex != 'Female' && $sex != 'Others') {
        $error_message = "Invalid value for Sex. Please choose Male, Female or Others.";
    }

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    }

    // Kiểm tra độ dài mật khẩu (tối thiểu 6 ký tự)
    if (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    }

    // Kiểm tra tuổi từ 15 đến 100
    if ($age < 15 || $age > 100) {
        $error_message = "Age must be between 15 and 100.";
    }

    // Kiểm tra passportno và phone_num là số
    if (!is_numeric($passportno)) {
        $error_message = "Passport number must be numeric.";
    } elseif (strlen($passportno) != 8) {
        $error_message = "Passport number must be exactly 8 digits.";
    }

    if (!is_numeric($phone_num)) {
        $error_message = "Phone number must be numeric.";
    }

    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
    if (empty($error_message)) {
        // Sử dụng prepared statements để tránh SQL injection
        $check_query = $conn->prepare("SELECT * FROM account WHERE E_mail = ?");
        $check_query->bind_param("s", $email);
        $check_query->execute();
        $check_result = $check_query->get_result();

        if ($check_result->num_rows > 0) {
            $error_message = "Email already exists. Please choose another one.";
        } else {
            // Thêm vào bảng account
            $account_query = $conn->prepare("INSERT INTO account (Password, E_mail) VALUES (?, ?)");
            $account_query->bind_param("ss", $password, $email);
            if ($account_query->execute()) {
                // Lấy ID người dùng vừa chèn vào
                $user_id = $conn->insert_id; // ID của người dùng vừa được tạo

                // Thêm vào bảng participant
                $participant_query = $conn->prepare("INSERT INTO participant (UserID, Name, Nationality, PassportNO, Sex, Age, E_mail, Phone_number, Address) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if ($participant_query === false) {
                    echo "Lỗi chuẩn bị câu lệnh: " . $conn->error;
                    exit();
                }
                $participant_query->bind_param("issssisss", $user_id, $name, $nationality, $passportno, $sex, $age, $email, $phone_num, $address);
                if ($participant_query->execute()) {
                    $_SESSION['register_success'] = "Register successfully!"; // Thông báo thành công
                    header("Location: login.php"); // Chuyển hướng đến trang login sau khi đăng ký thành công
                    exit();
                } else {
                    $error_message = "Error in participant table: " . $conn->error;
                }
            } else {
                $error_message = "Error in account table: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hanoi Marathon</title>
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
        <section id="register">
            <h2>Create a New Account</h2>
            <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
            <form method="POST" action="register.php">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" value="<?php echo isset($name) ? $name : ''; ?>" required>

                <label for="nationality">Nationality:</label>
                <input type="text" name="nationality" id="nationality" value="<?php echo isset($nationality) ? $nationality : ''; ?>" required>

                <label for="passportno">Passport Number:</label>
                <input type="text" name="passportno" id="passportno" value="<?php echo isset($passportno) ? $passportno : ''; ?>" required>

                <label for="sex">Sex:</label>
                <select name="sex" id="sex" required>
                    <option value="Male" <?php echo (isset($sex) && $sex == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo (isset($sex) && $sex == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Others" <?php echo (isset($sex) && $sex == 'Others') ? 'selected' : ''; ?>>Others</option>
                </select>

                <label for="age">Age:</label>
                <input type="number" name="age" id="age" value="<?php echo isset($age) ? $age : ''; ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>" required>

                <label for="phone_num">Phone Number:</label>
                <input type="text" name="phone_num" id="phone_num" value="<?php echo isset($phone_num) ? $phone_num : ''; ?>" required>

                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo isset($address) ? $address : ''; ?>" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
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
