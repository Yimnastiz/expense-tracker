<?php
// connection.php
$servername = "localhost";
$username = "root";      // เปลี่ยนตาม MySQL ของคุณ
$password = "";          // เปลี่ยนตาม MySQL ของคุณ
$dbname = "income_expense_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
