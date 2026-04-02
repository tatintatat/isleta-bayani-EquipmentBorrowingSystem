<?php
include 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $rec = $conn->query("SELECT * FROM borrow_records WHERE id=$id")->fetch_assoc();
    if ($rec && $rec['status'] !== 'Returned') {
        $conn->query("UPDATE equipment SET available_quantity = available_quantity + {$rec['quantity_borrowed']} WHERE id={$rec['equipment_id']}");
    }
    $conn->query("DELETE FROM borrow_records WHERE id=$id");
}
header("Location: borrowed.php?msg=deleted"); exit;
