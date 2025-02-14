<?php
include 'connection.php';
include 'functions.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM records WHERE id = '$id'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();

    // เมื่อกดบันทึกการแก้ไข
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $date = $_POST['date'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $type = $_POST['type'];

        if (updateRecord($id, $date, $description, $amount, $type)) {
            header("Location: record.php");
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
        }
    }
} else {
    echo "ไม่พบ ID ที่จะทำการแก้ไข";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูล</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h3>📒 Expense Tracker</h3>
        <a href="record.php">บันทึกรายรับรายจ่าย</a>
        <a href="summary.php">สรุปรายรับรายจ่าย</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">แก้ไขข้อมูล</div>
        <form method="POST">
            <label>วันที่:</label>
            <input type="date" name="date" value="<?php echo $data['date']; ?>" required><br>

            <label>รายละเอียด:</label>
            <input type="text" name="description" value="<?php echo $data['description']; ?>" required><br>

            <label>จำนวนเงิน:</label>
            <input type="number" step="0.01" name="amount" value="<?php echo $data['amount']; ?>" required><br>

            <label>ประเภท:</label>
            <select name="type" required>
                <option value="income" <?php if($data['type'] == 'income') echo 'selected'; ?>>รายรับ</option>
                <option value="expense" <?php if($data['type'] == 'expense') echo 'selected'; ?>>รายจ่าย</option>
            </select><br><br>

            <button type="submit">บันทึกการแก้ไข</button>
        </form>
    </div>
</body>
</html>