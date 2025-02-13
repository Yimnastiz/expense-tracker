<?php
include 'connection.php';
include 'functions.php';

// ตรวจสอบการบันทึกข้อมูล
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $date = $_POST['date'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];

    if (addRecord($date, $description, $amount, $type)) {
        echo "<script>alert('บันทึกข้อมูลสำเร็จ!');</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด!');</script>";
    }
}

// ตรวจสอบการลบข้อมูล
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    deleteRecord($id);
    header("Location: record.php");
    exit();
}

// ดึงข้อมูลทั้งหมด
$records = getAllRecords();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>บันทึกรายรับรายจ่าย</title>
</head>
<body>
    <h2>📒 บันทึกรายรับรายจ่าย</h2>

    <!-- ฟอร์มบันทึกรายรับรายจ่าย -->
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

    <!-- แสดงรายการที่บันทึก -->
    <h3>📊 ประวัติการบันทึก</h3>
    <table>
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
            <td><?php echo $record['type'] == 'income' ? 'รายรับ' : 'รายจ่าย'; ?></td>
            <td>
                <a href="record.php?delete=<?php echo $record['id']; ?>" class="delete-btn" onclick="return confirm('ยืนยันการลบข้อมูลนี้?')">ลบ</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="record.php" class="btn">บันทึกรายรับรายจ่าย</a>

    <a href="summary.php" class="btn">สรุปรายรับรายจ่าย</a>

</body>
</html>
