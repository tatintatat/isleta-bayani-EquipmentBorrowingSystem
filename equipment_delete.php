<?php
include 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $conn->query("DELETE FROM equipment WHERE id=$id");
}
header("Location: equipment.php?msg=deleted");
exit;
