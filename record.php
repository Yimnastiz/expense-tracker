<?php
include 'connection.php';
include 'functions.php';

// ตรวจสอบการลบข้อมูล (ถ้ามีการส่งค่าผ่าน GET)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteRecord($id)) {
        echo "<script>alert('ลบข้อมูลสำเร็จ!'); window.location.href='record.php';</script>";
        exit();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล!');</script>";
    }
}

// ตรวจสอบการบันทึกข้อมูล (ถ้ามีการส่งค่าผ่าน POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $date = $_POST['date'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];

    if (addRecord($date, $description, $amount, $type)) {
        echo "<script>alert('บันทึกข้อมูลสำเร็จ!'); window.location.href='record.php';</script>";
        exit();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>รายรับรายจ่าย</title>
</head>
<body>

<div class="sidebar">
    <h3>📒 Expense Tracker</h3>
    <a href="record.php">บันทึกรายรับรายจ่าย</a>
    <a href="summary.php">สรุปรายรับรายจ่าย</a>
</div>

<div class="main-content">
    <div class="header">📊 หน้าบันทึกรายรับรายจ่าย</div>

    <!-- เนื้อหาฟอร์มและตารางบันทึก -->
    <?php 
    // ดึงข้อมูลทั้งหมด
    $records = getAllRecords();
    ?>
    
    <form method="POST">
        <label>วันที่:</label>
        <input type="date" name="date" required>
        <label>รายละเอียด:</label>
        <input type="text" name="description" required>
        <label>จำนวนเงิน:</label>
        <input type="number" step="0.01" name="amount" required>
        <label>ประเภท:</label>
        <select name="type" required>
            <option value="income">รายรับ</option>
            <option value="expense">รายจ่าย</option>
        </select>
        <button type="submit" name="add">บันทึก</button>
    </form>

    <h3>📈 ประวัติการบันทึก</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>วันที่</th>
            <th>รายละเอียด</th>
            <th>จำนวนเงิน</th>
            <th>ประเภท</th>
            <th>จัดการ</th>
        </tr>

        <?php foreach ($records as $record): ?>
        <tr>
            <td><?php echo $record['id']; ?></td>
            <td><?php echo $record['date']; ?></td>
            <td><?php echo $record['description']; ?></td>
            <td><?php echo number_format($record['amount'], 2); ?></td>
            <td><?php echo ($record['type'] == 'income') ? 'รายรับ' : 'รายจ่าย'; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $record['id']; ?>">แก้ไข</a> | 
                <a href="record.php?delete=<?php echo $record['id']; ?>" onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>

