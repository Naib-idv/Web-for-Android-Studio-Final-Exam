<?php
$host = 'localhost';
$port = '4506';
$user = 'yk';
$password = '123456';
$database = 'hn_marathon'; // Thay thế bằng tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($host, $user, $password, $database, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>