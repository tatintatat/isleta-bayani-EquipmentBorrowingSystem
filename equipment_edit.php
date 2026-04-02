<?php
include 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$eq = $conn->query("SELECT * FROM equipment WHERE id=$id")->fetch_assoc();
if (!$eq) { header("Location: equipment.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = clean($conn, $_POST['name']);
    $cat    = clean($conn, $_POST['category']);
    $desc   = clean($conn, $_POST['description']);
    $serial = clean($conn, $_POST['serial_number']);
    $total  = (int)$_POST['total_quantity'];
    $avail  = (int)$_POST['available_quantity'];
    $cond   = clean($conn, $_POST['condition_status']);

    $sql = "UPDATE equipment SET name='$name',category='$cat',description='$desc',
            serial_number='$serial',total_quantity=$total,available_quantity=$avail,
            condition_status='$cond' WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: equipment.php?msg=updated"); exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}

$pageTitle  = 'Edit Equipment';
$pageAction = '<a href="equipment.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>';
include 'includes/header.php';
?>

<?php if (!empty($error)): ?><div class="flash error"><i class="fas fa-exclamation-circle"></i><?= $error ?></div><?php endif; ?>

<div class="card">
    <div class="card-header"><h2 class="card-title">Edit Equipment Details</h2></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-grid">
                <div class="form-group span-2">
                    <label>Equipment Name *</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($eq['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <?php foreach(['Computing','Electronics','Photography','Audio','Utilities','Presentation','Other'] as $c): ?>
                            <option value="<?= $c ?>" <?= $eq['category']===$c?'selected':'' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Serial Number</label>
                    <input type="text" name="serial_number" value="<?= htmlspecialchars($eq['serial_number']) ?>">
                </div>
                <div class="form-group">
                    <label>Total Quantity</label>
                    <input type="number" name="total_quantity" min="1" value="<?= $eq['total_quantity'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Available Quantity</label>
                    <input type="number" name="available_quantity" min="0" value="<?= $eq['available_quantity'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Condition</label>
                    <select name="condition_status">
                        <?php foreach(['Excellent','Good','Fair','Needs Repair'] as $c): ?>
                            <option value="<?= $c ?>" <?= $eq['condition_status']===$c?'selected':'' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group span-2">
                    <label>Description</label>
                    <textarea name="description"><?= htmlspecialchars($eq['description']) ?></textarea>
                </div>
            </div>
            <div class="form-actions" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Equipment</button>
                <a href="equipment.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
