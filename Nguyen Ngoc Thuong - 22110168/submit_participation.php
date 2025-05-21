<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
session_start();
include 'db/connect.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$race_id = $_POST['race_id']; // Lấy ID cuộc thi từ form
$hotel = mysqli_real_escape_string($conn, $_POST['hotel']); // Lấy thông tin khách sạn

// Kiểm tra nếu thông tin hợp lệ
if (empty($hotel)) {
    echo "Vui lòng nhập tên khách sạn.";
    exit();
}

// Truy vấn để chèn thông tin vào bảng 'participate'
$query = "INSERT INTO participate (MarathonID, UserID, EntryNO, Hotel) 
          VALUES ('$race_id', '$user_id', NULL, '$hotel')";

// Thực thi truy vấn và kiểm tra kết quả
if (mysqli_query($conn, $query)) {
    // Nếu thành công, chuyển hướng về trang account
    header("Location: account.php");
    exit();
} else {
    // Nếu có lỗi, hiển thị lỗi
    echo "Có lỗi khi đăng ký cuộc thi. Vui lòng thử lại! " . mysqli_error($conn);
    exit();
}

ob_end_flush(); // Xả bộ đệm đầu ra
?>