<?php
include 'connection.php';

// เพิ่มรายการรายรับรายจ่าย
function addRecord($date, $description, $amount, $type) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO records (date, description, amount, type) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ssds", $date, $description, $amount, $type);
    $result = $stmt->execute();
    if (!$result) {
        die("Error executing statement: " . $stmt->error);
    }
    return $result;
}

// ดึงรายการทั้งหมด
function getAllRecords() {
    global $conn;
    $result = $conn->query("SELECT * FROM records ORDER BY date DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// ลบรายการ
function deleteRecord($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM records WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// แก้ไขรายการ
function updateRecord($id, $date, $description, $amount, $type) {
    global $conn;
    $stmt = $conn->prepare("UPDATE records SET date=?, description=?, amount=?, type=? WHERE id=?");
    $stmt->bind_param("ssdsi", $date, $description, $amount, $type, $id);
    return $stmt->execute();
}
?>
