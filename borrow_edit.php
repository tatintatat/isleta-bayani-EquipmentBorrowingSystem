<?php
// borrow_edit.php
include 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$rec = $conn->query("SELECT * FROM borrow_records WHERE id=$id")->fetch_assoc();
if (!$rec) { header("Location: borrowed.php"); exit; }

$equipment = $conn->query("SELECT * FROM equipment ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = clean($conn, $_POST['borrower_name']);
    $email   = clean($conn, $_POST['borrower_email']);
    $contact = clean($conn, $_POST['borrower_contact']);
    $dept    = clean($conn, $_POST['department']);
    $purpose = clean($conn, $_POST['purpose']);
    $bdate   = clean($conn, $_POST['borrow_date']);
    $rdate   = clean($conn, $_POST['expected_return']);
    $notes   = clean($conn, $_POST['notes']);
    $status  = clean($conn, $_POST['status']);

    $conn->query("UPDATE borrow_records SET borrower_name='$name',borrower_email='$email',borrower_contact='$contact',
        department='$dept',purpose='$purpose',borrow_date='$bdate',expected_return='$rdate',notes='$notes',status='$status'
        WHERE id=$id");
    header("Location: borrowed.php?msg=updated"); exit;
}

$pageTitle  = 'Edit Borrow Record';
$pageAction = '<a href="borrowed.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>';
include 'includes/header.php';
?>
<div class="card">
    <div class="card-header"><h2 class="card-title">Edit Borrow Details</h2></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Borrower Name</label>
                    <input type="text" name="borrower_name" value="<?= htmlspecialchars($rec['borrower_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="borrower_email" value="<?= htmlspecialchars($rec['borrower_email']) ?>">
                </div>
                <div class="form-group">
                    <label>Contact</label>
                    <input type="text" name="borrower_contact" value="<?= htmlspecialchars($rec['borrower_contact']) ?>">
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department" value="<?= htmlspecialchars($rec['department']) ?>">
                </div>
                <div class="form-group">
                    <label>Borrow Date</label>
                    <input type="date" name="borrow_date" value="<?= $rec['borrow_date'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Expected Return</label>
                    <input type="date" name="expected_return" value="<?= $rec['expected_return'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <?php foreach(['Borrowed','Returned','Overdue'] as $s): ?>
                            <option value="<?= $s ?>" <?= $rec['status']===$s?'selected':'' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group span-2">
                    <label>Purpose</label>
                    <textarea name="purpose"><?= htmlspecialchars($rec['purpose']) ?></textarea>
                </div>
                <div class="form-group span-2">
                    <label>Notes</label>
                    <textarea name="notes"><?= htmlspecialchars($rec['notes']) ?></textarea>
                </div>
            </div>
            <div class="form-actions" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Record</button>
                <a href="borrowed.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
