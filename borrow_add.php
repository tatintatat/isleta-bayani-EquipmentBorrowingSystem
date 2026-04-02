<?php
include 'config.php';

$equipment = $conn->query("SELECT * FROM equipment WHERE available_quantity > 0 ORDER BY name");
$preselect = isset($_GET['equip']) ? (int)$_GET['equip'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = clean($conn, $_POST['borrower_name']);
    $email   = clean($conn, $_POST['borrower_email']);
    $contact = clean($conn, $_POST['borrower_contact']);
    $dept    = clean($conn, $_POST['department']);
    $equip   = (int)$_POST['equipment_id'];
    $qty     = (int)$_POST['quantity_borrowed'];
    $purpose = clean($conn, $_POST['purpose']);
    $bdate   = clean($conn, $_POST['borrow_date']);
    $rdate   = clean($conn, $_POST['expected_return']);
    $notes   = clean($conn, $_POST['notes']);

    // Check availability
    $eq = $conn->query("SELECT available_quantity FROM equipment WHERE id=$equip")->fetch_assoc();
    if ($eq && $eq['available_quantity'] >= $qty) {
        $conn->begin_transaction();
        try {
            $conn->query("INSERT INTO borrow_records (borrower_name,borrower_email,borrower_contact,department,equipment_id,quantity_borrowed,purpose,borrow_date,expected_return,notes,status)
                VALUES ('$name','$email','$contact','$dept',$equip,$qty,'$purpose','$bdate','$rdate','$notes','Borrowed')");
            $conn->query("UPDATE equipment SET available_quantity = available_quantity - $qty WHERE id=$equip");
            $conn->commit();
            header("Location: borrowed.php?msg=added"); exit;
        } catch(Exception $e) {
            $conn->rollback();
            $error = "Transaction failed: " . $e->getMessage();
        }
    } else {
        $error = "Insufficient available quantity for selected equipment.";
    }
}

$pageTitle  = 'New Borrow Request';
$pageAction = '<a href="borrowed.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>';
include 'includes/header.php';
?>

<?php if (!empty($error)): ?><div class="flash error"><i class="fas fa-exclamation-circle"></i><?= $error ?></div><?php endif; ?>

<div class="card">
    <div class="card-header"><h2 class="card-title">Borrower Information</h2></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Borrower Name *</label>
                    <input type="text" name="borrower_name" placeholder="Full name" value="<?= htmlspecialchars($_POST['borrower_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="borrower_email" placeholder="borrower@school.edu" value="<?= htmlspecialchars($_POST['borrower_email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="borrower_contact" placeholder="09XXXXXXXXX" value="<?= htmlspecialchars($_POST['borrower_contact'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Department / Section</label>
                    <input type="text" name="department" placeholder="e.g. Computer Science" value="<?= htmlspecialchars($_POST['department'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Equipment *</label>
                    <select name="equipment_id" required>
                        <option value="">Select equipment</option>
                        <?php while($e = $equipment->fetch_assoc()): ?>
                            <option value="<?= $e['id'] ?>" <?= ($preselect==$e['id']||($_POST['equipment_id']??0)==$e['id'])?'selected':'' ?>>
                                <?= htmlspecialchars($e['name']) ?> (<?= $e['available_quantity'] ?> available)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="quantity_borrowed" min="1" value="<?= htmlspecialchars($_POST['quantity_borrowed'] ?? '1') ?>" required>
                </div>
                <div class="form-group">
                    <label>Borrow Date *</label>
                    <input type="date" name="borrow_date" value="<?= htmlspecialchars($_POST['borrow_date'] ?? date('Y-m-d')) ?>" required>
                </div>
                <div class="form-group">
                    <label>Expected Return Date *</label>
                    <input type="date" name="expected_return" value="<?= htmlspecialchars($_POST['expected_return'] ?? '') ?>" required>
                </div>
                <div class="form-group span-2">
                    <label>Purpose</label>
                    <textarea name="purpose" placeholder="Reason for borrowing..."><?= htmlspecialchars($_POST['purpose'] ?? '') ?></textarea>
                </div>
                <div class="form-group span-2">
                    <label>Additional Notes</label>
                    <textarea name="notes" placeholder="Any extra notes or reminders..."><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="form-actions" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit Borrow Request</button>
                <a href="borrowed.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
