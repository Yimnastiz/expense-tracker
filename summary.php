<?php
include 'connection.php';
include 'functions.php';

// ดึงข้อมูลสรุปรายสัปดาห์
function getWeeklySummary() {
    global $conn;
    $sql = "
        SELECT 
            YEAR(date) AS year, 
            WEEK(date, 1) AS week, 
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expense
        FROM records
        GROUP BY YEAR(date), WEEK(date, 1)
        ORDER BY YEAR(date) DESC, WEEK(date, 1) DESC
    ";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// ดึงข้อมูลสรุปรายเดือน
function getMonthlySummary() {
    global $conn;
    $sql = "
        SELECT 
            YEAR(date) AS year, 
            MONTH(date) AS month, 
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expense
        FROM records
        GROUP BY YEAR(date), MONTH(date)
        ORDER BY YEAR(date) DESC, MONTH(date) DESC
    ";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$weeklySummary = getWeeklySummary();
$monthlySummary = getMonthlySummary();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>สรุปรายรับรายจ่าย</title>

</head>
<body>

    <h2>📊 สรุปรายรับรายจ่าย</h2>

    <!-- สรุปรายสัปดาห์ -->
    <h3>สรุปรายสัปดาห์</h3>
    <table>
        <tr>
            <th>ปี</th>
            <th>สัปดาห์ที่</th>
            <th>รายรับ (฿)</th>
            <th>รายจ่าย (฿)</th>
        </tr>
        <?php foreach ($weeklySummary as $week): ?>
        <tr>
            <td><?php echo $week['year']; ?></td>
            <td><?php echo $week['week']; ?></td>
            <td class="income"><?php echo number_format($week['total_income'], 2); ?></td>
            <td class="expense"><?php echo number_format($week['total_expense'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- สรุปรายเดือน -->
    <h3>สรุปรายเดือน</h3>
    <table>
        <tr>
            <th>ปี</th>
            <th>เดือน</th>
            <th>รายรับ (฿)</th>
            <th>รายจ่าย (฿)</th>
        </tr>
        <?php foreach ($monthlySummary as $month): ?>
        <tr>
            <td><?php echo $month['year']; ?></td>
            <td><?php echo $month['month']; ?></td>
            <td class="income"><?php echo number_format($month['total_income'], 2); ?></td>
            <td class="expense"><?php echo number_format($month['total_expense'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="button-group">

    <a href="record.php" class="btn">บันทึกรายรับรายจ่าย</a>

    <a href="summary.php" class="btn">สรุปรายรับรายจ่าย</a>

    </div>


</body>
</html>