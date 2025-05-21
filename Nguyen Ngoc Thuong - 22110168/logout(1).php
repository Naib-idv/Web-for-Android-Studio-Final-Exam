<?php
session_start();
session_unset();  // Xóa tất cả session
session_destroy(); // Hủy phiên làm việc

// Chuyển hướng về trang login sau khi đăng xuất
header("Location: login.php");
exit();
?>
