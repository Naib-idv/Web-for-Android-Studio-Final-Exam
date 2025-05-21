<?php
$servername = "localhost";
$username = "yk";
$password = "123456";
$dbname = "hn_marathon";
$port = 4506; // Thêm cổng kết nối

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>