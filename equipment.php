<?php
include 'config.php';

// Handle flash message
$flash = '';
if (isset($_GET['msg'])) {
    $flash = $_GET['msg'] === 'deleted'  ? ['type'=>'success','text'=>'Equipment deleted successfully.'] :
            ($_GET['msg'] === 'added'    ? ['type'=>'success','text'=>'Equipment added successfully.'] :
            ($_GET['msg'] === 'updated'  ? ['type'=>'success','text'=>'Equipment updated successfully.'] : ''));
}

// Search / Filter
$search   = isset($_GET['q'])   ? clean($conn, $_GET['q'])   : '';
$category = isset($_GET['cat']) ? clean($conn, $_GET['cat']) : '';

$where = "WHERE 1=1";
if ($search)   $where .= " AND (name LIKE '%$search%' OR serial_number LIKE '%$search%' OR description LIKE '%$search%')";
if ($category) $where .= " AND category = '$category'";

$equipment = $conn->query("SELECT * FROM equipment $where ORDER BY name ASC");
$categories = $conn->query("SELECT DISTINCT category FROM equipment ORDER BY category");

$pageTitle    = 'Equipment Available';
$pageSubtitle = 'Browse and manage all equipment in inventory';
$pageAction   = '<a href="equipment_add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Equipment</a>';

include 'includes/header.php';
?>

<?php if ($flash): ?>
<div class="flash <?= $flash['type'] ?>"><i class="fas fa-<?= $flash['type']==='success'?'check-circle':'exclamation-circle' ?>"></i><?= $flash['text'] ?></div>
<?php endif; ?>

<!-- Search & Filter -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-body" style="padding:16px 24px;">
        <form method="GET" class="search-bar">
            <input type="text" name="q" placeholder="Search equipment, serial no..." value="<?= htmlspecialchars($search) ?>">
            <select name="cat">
                <option value="">All Categories</option>
                <?php while($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['category'] ?>" <?= $category===$cat['category']?'selected':'' ?>>
                        <?= htmlspecialchars($cat['category']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            <?php if ($search || $category): ?>
                <a href="equipment.php" class="btn btn-outline"><i class="fas fa-xmark"></i> Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Equipment Grid -->
<?php if ($equipment->num_rows === 0): ?>
    <div class="card"><div class="empty-state"><i class="fas fa-boxes-stacked"></i><p>No equipment found. <a href="equipment_add.php">Add one?</a></p></div></div>
<?php else: ?>
<div class="equipment-grid">
    <?php 
    $icons = ['Computing'=>'fa-laptop','Electronics'=>'fa-microchip','Photography'=>'fa-camera','Audio'=>'fa-volume-high','Utilities'=>'fa-plug','Presentation'=>'fa-display'];
    while($eq = $equipment->fetch_assoc()):
        $icon = $icons[$eq['category']] ?? 'fa-box';
        $pct  = $eq['total_quantity'] > 0 ? $eq['available_quantity']/$eq['total_quantity'] : 0;
        $avclass = $pct > 0.5 ? 'good' : ($pct > 0 ? 'low' : 'none');
    ?>
    <div class="equipment-card">
        <div class="equipment-card-icon"><i class="fas <?= $icon ?>"></i></div>
        <div class="category"><?= htmlspecialchars($eq['category']) ?></div>
        <h3><?= htmlspecialchars($eq['name']) ?></h3>
        <div class="desc"><?= htmlspecialchars(substr($eq['description'],0,90)) ?>...</div>
        <div class="meta">
            <span class="availability <?= $avclass ?>">
                <i class="fas fa-circle" style="font-size:8px;margin-right:4px"></i>
                <?= $eq['available_quantity'] ?>/<?= $eq['total_quantity'] ?> Available
            </span>
            <?= conditionBadge($eq['condition_status']) ?>
        </div>
        <?php if ($eq['serial_number']): ?>
            <div style="font-size:11px;color:var(--text3);margin-bottom:14px;font-family:'Courier New',monospace;">SN: <?= htmlspecialchars($eq['serial_number']) ?></div>
        <?php endif; ?>
        <div class="card-actions">
            <a href="borrow_add.php?equip=<?= $eq['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-hand-holding"></i> Borrow</a>
            <a href="equipment_edit.php?id=<?= $eq['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
            <a href="equipment_delete.php?id=<?= $eq['id'] ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></a>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
