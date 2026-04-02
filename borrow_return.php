<?php
// borrow_return.php
include 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$rec = $conn->query("SELECT * FROM borrow_records WHERE id=$id")->fetch_assoc();
if ($rec && $rec['status'] !== 'Returned') {
    $today = date('Y-m-d');
    $conn->begin_transaction();
    try {
        $conn->query("UPDATE borrow_records SET status='Returned', actual_return='$today' WHERE id=$id");
        $conn->query("UPDATE equipment SET available_quantity = available_quantity + {$rec['quantity_borrowed']} WHERE id={$rec['equipment_id']}");
        $conn->commit();
    } catch(Exception $e) { $conn->rollback(); }
}
header("Location: borrowed.php?msg=returned"); exit;
