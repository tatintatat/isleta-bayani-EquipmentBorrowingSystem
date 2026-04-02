<?php
// config.php - Database Connection
// Equipment Borrowing System | ITEL 203

$host     = "sql313.infinityfree.com";
$user     = "if0_41554928";
$password = "arEbjCfg1vT";
$dbname   = "if0_41554928_db_equipment_borrowing";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Helper: sanitize input
function clean($conn, $data) {
    return $conn->real_escape_string(htmlspecialchars(strip_tags(trim($data))));
}

// Helper: format date
function formatDate($date) {
    if (!$date) return '—';
    return date('M d, Y', strtotime($date));
}

// Helper: status badge HTML
function statusBadge($status) {
    $map = [
        'Borrowed' => 'badge-borrowed',
        'Returned' => 'badge-returned',
        'Overdue'  => 'badge-overdue',
    ];
    $cls = $map[$status] ?? 'badge-borrowed';
    return "<span class=\"badge $cls\">$status</span>";
}

// Helper: condition badge
function conditionBadge($cond) {
    $map = [
        'Excellent'    => 'badge-excellent',
        'Good'         => 'badge-good',
        'Fair'         => 'badge-fair',
        'Needs Repair' => 'badge-repair',
    ];
    $cls = $map[$cond] ?? 'badge-good';
    return "<span class=\"badge $cls\">$cond</span>";
}
?>
