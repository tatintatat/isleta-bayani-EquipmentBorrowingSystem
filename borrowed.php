<?php
include 'config.php';

$flash = '';
if (isset($_GET['msg'])) {
    $msgs = ['added'=>'Borrow record added.','updated'=>'Record updated.','deleted'=>'Record deleted.','returned'=>'Item marked as returned.'];
    if (isset($msgs[$_GET['msg']])) $flash = ['type'=>'success','text'=>$msgs[$_GET['msg']]];
}

$search = isset($_GET['q'])      ? clean($conn,$_GET['q'])      : '';
$status = isset($_GET['status']) ? clean($conn,$_GET['status']) : '';

$where = "WHERE 1=1";
if ($search) $where .= " AND (br.borrower_name LIKE '%$search%' OR e.name LIKE '%$search%' OR br.borrower_email LIKE '%$search%')";
if ($status) $where .= " AND br.status='$status'";

$records = $conn->query("
    SELECT br.*, e.name AS equip_name, e.category
    FROM borrow_records br
    JOIN equipment e ON br.equipment_id = e.id
    $where
    ORDER BY br.created_at DESC
");

$pageTitle    = 'Equipment Borrowed';
$pageSubtitle = 'Track all borrow records and returns';
$pageAction   = '<a href="borrow_add.php" class="btn btn-primary"><i class="fas fa-plus"></i> New Borrow</a>';
include 'includes/header.php';
?>

<?php if ($flash): ?>
    <div class="flash <?= $flash['type'] ?>"><i class="fas fa-check-circle"></i><?= $flash['text'] ?></div>
<?php endif; ?>

<!-- Filter bar -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-body" style="padding:14px 24px;">
        <form method="GET" class="search-bar">
            <input type="text" name="q" placeholder="Search borrower or equipment..." value="<?= htmlspecialchars($search) ?>">
            <select name="status">
                <option value="">All Status</option>
                <option value="Borrowed" <?= $status==='Borrowed'?'selected':'' ?>>Borrowed</option>
                <option value="Returned" <?= $status==='Returned'?'selected':'' ?>>Returned</option>
                <option value="Overdue"  <?= $status==='Overdue' ?'selected':'' ?>>Overdue</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
            <?php if ($search||$status): ?>
                <a href="borrowed.php" class="btn btn-outline"><i class="fas fa-xmark"></i> Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Borrow Records (<?= $records->num_rows ?>)</h2>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Borrower</th>
                    <th>Equipment</th>
                    <th>Qty</th>
                    <th>Borrow Date</th>
                    <th>Expected Return</th>
                    <th>Actual Return</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($records->num_rows === 0): ?>
                    <tr><td colspan="9" style="text-align:center;padding:40px;color:var(--text3);">No records found.</td></tr>
                <?php else: ?>
                <?php while($r = $records->fetch_assoc()): ?>
                <tr>
                    <td style="color:var(--text3);font-size:12px;"><?= $r['id'] ?></td>
                    <td>
                        <strong><?= htmlspecialchars($r['borrower_name']) ?></strong><br>
                        <span style="font-size:12px;color:var(--text3);"><?= htmlspecialchars($r['department']) ?></span>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($r['equip_name']) ?></strong><br>
                        <span style="font-size:11px;color:var(--text3);"><?= htmlspecialchars($r['category']) ?></span>
                    </td>
                    <td><?= $r['quantity_borrowed'] ?></td>
                    <td><?= formatDate($r['borrow_date']) ?></td>
                    <td><?= formatDate($r['expected_return']) ?></td>
                    <td><?= $r['actual_return'] ? formatDate($r['actual_return']) : '<span style="color:var(--text3)">—</span>' ?></td>
                    <td><?= statusBadge($r['status']) ?></td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <?php if ($r['status'] === 'Borrowed' || $r['status'] === 'Overdue'): ?>
                                <a href="borrow_return.php?id=<?= $r['id'] ?>" class="btn btn-success btn-sm" title="Mark Returned"><i class="fas fa-rotate-left"></i></a>
                            <?php endif; ?>
                            <a href="borrow_edit.php?id=<?= $r['id'] ?>" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-pen"></i></a>
                            <a href="borrow_delete.php?id=<?= $r['id'] ?>" class="btn btn-danger btn-sm btn-delete" title="Delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
