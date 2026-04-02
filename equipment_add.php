<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = clean($conn, $_POST['name']);
    $category = clean($conn, $_POST['category']);
    $desc     = clean($conn, $_POST['description']);
    $serial   = clean($conn, $_POST['serial_number']);
    $total    = (int)$_POST['total_quantity'];
    $avail    = (int)$_POST['available_quantity'];
    $cond     = clean($conn, $_POST['condition_status']);

    if ($name && $category && $total > 0) {
        $sql = "INSERT INTO equipment (name,category,description,serial_number,total_quantity,available_quantity,condition_status)
                VALUES ('$name','$category','$desc','$serial',$total,$avail,'$cond')";
        if ($conn->query($sql)) {
            header("Location: equipment.php?msg=added");
            exit;
        } else {
            $error = "Database error: " . $conn->error;
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}

$pageTitle  = 'Add Equipment';
$pageAction = '<a href="equipment.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>';
include 'includes/header.php';
?>

<?php if (!empty($error)): ?>
    <div class="flash error"><i class="fas fa-exclamation-circle"></i><?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Equipment Details</h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-grid">
                <div class="form-group span-2">
                    <label>Equipment Name *</label>
                    <input type="text" name="name" placeholder="e.g. Laptop - Dell Inspiron 15" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <option value="">Select category</option>
                        <?php foreach(['Computing','Electronics','Photography','Audio','Utilities','Presentation','Other'] as $c): ?>
                            <option value="<?= $c ?>" <?= ($_POST['category']??'')===$c?'selected':'' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Serial Number</label>
                    <input type="text" name="serial_number" placeholder="e.g. DL-INS-2024-001" value="<?= htmlspecialchars($_POST['serial_number'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Total Quantity *</label>
                    <input type="number" name="total_quantity" min="1" value="<?= htmlspecialchars($_POST['total_quantity'] ?? '1') ?>" required>
                </div>
                <div class="form-group">
                    <label>Available Quantity *</label>
                    <input type="number" name="available_quantity" min="0" value="<?= htmlspecialchars($_POST['available_quantity'] ?? '1') ?>" required>
                </div>
                <div class="form-group">
                    <label>Condition</label>
                    <select name="condition_status">
                        <?php foreach(['Excellent','Good','Fair','Needs Repair'] as $c): ?>
                            <option value="<?= $c ?>" <?= ($_POST['condition_status']??'Good')===$c?'selected':'' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group span-2">
                    <label>Description</label>
                    <textarea name="description" placeholder="Brief description of the equipment..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="form-actions" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Equipment</button>
                <a href="equipment.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
