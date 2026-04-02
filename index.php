<?php
include 'config.php';
$pageTitle    = 'Dashboard';
$pageSubtitle = 'Welcome to the Equipment Borrowing System';

// Stats
$totalEq  = $conn->query("SELECT COUNT(*) AS c FROM equipment")->fetch_assoc()['c'];
$available = $conn->query("SELECT SUM(available_quantity) AS c FROM equipment")->fetch_assoc()['c'];
$borrowed  = $conn->query("SELECT COUNT(*) AS c FROM borrow_records WHERE status='Borrowed'")->fetch_assoc()['c'];
$overdue   = $conn->query("SELECT COUNT(*) AS c FROM borrow_records WHERE status='Overdue'")->fetch_assoc()['c'];

// Recent borrows
$recent = $conn->query("
    SELECT br.*, e.name AS equip_name
    FROM borrow_records br
    JOIN equipment e ON br.equipment_id = e.id
    ORDER BY br.created_at DESC LIMIT 5
");
include 'includes/header.php';
?>

<div class="hero">
    <div class="hero-tag"><i class="fas fa-box-archive"></i> Equipment Borrowing System</div>
    <h2>Manage <span>Equipment</span><br>Borrowing Efficiently</h2>
    <p>Track all equipment inventory, borrowing records, and returns in one centralized platform designed for ITEL 203.</p>
    <div class="hero-btns">
        <a href="borrow_add.php" class="btn btn-primary"><i class="fas fa-plus"></i> New Borrow Request</a>
        <a href="equipment.php" class="btn btn-outline"><i class="fas fa-microchip"></i> View Equipment</a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-icon blue"><i class="fas fa-boxes-stacked"></i></div>
        <div>
            <div class="stat-value"><?= $totalEq ?></div>
            <div class="stat-label">Total Equipment</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-value"><?= $available ?></div>
            <div class="stat-label">Units Available</div>
        </div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon orange"><i class="fas fa-hand-holding"></i></div>
        <div>
            <div class="stat-value"><?= $borrowed ?></div>
            <div class="stat-label">Currently Borrowed</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon red"><i class="fas fa-clock"></i></div>
        <div>
            <div class="stat-value"><?= $overdue ?></div>
            <div class="stat-label">Overdue Returns</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;flex-wrap:wrap;">
    <!-- Recent Borrow Activity -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-clock" style="color:var(--accent);margin-right:8px"></i>Recent Activity</h2>
            <a href="borrowed.php" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="card-body" style="padding:0 24px;">
            <?php if ($recent->num_rows === 0): ?>
                <div class="empty-state"><i class="fas fa-inbox"></i><p>No records yet.</p></div>
            <?php else: ?>
                <ul class="activity-list">
                    <?php while($r = $recent->fetch_assoc()): 
                        $dot = $r['status'] === 'Returned' ? 'green' : ($r['status'] === 'Overdue' ? 'red' : 'blue');
                    ?>
                    <li class="activity-item">
                        <div class="activity-dot <?= $dot ?>"></div>
                        <div>
                            <div class="activity-text">
                                <strong><?= htmlspecialchars($r['borrower_name']) ?></strong>
                                <?= $r['status'] === 'Returned' ? 'returned' : 'borrowed' ?>
                                <strong><?= htmlspecialchars($r['equip_name']) ?></strong>
                            </div>
                            <div class="activity-time"><?= formatDate($r['borrow_date']) ?> &mdash; <?= statusBadge($r['status']) ?></div>
                        </div>
                    </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-bolt" style="color:var(--accent);margin-right:8px"></i>Quick Actions</h2>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:12px;">
                <a href="borrow_add.php" class="btn btn-primary" style="justify-content:flex-start;">
                    <i class="fas fa-plus-circle"></i> Add Borrow Record
                </a>
                <a href="equipment_add.php" class="btn btn-outline" style="justify-content:flex-start;">
                    <i class="fas fa-box-open"></i> Add New Equipment
                </a>
                <a href="borrowed.php?status=Overdue" class="btn btn-danger" style="justify-content:flex-start;">
                    <i class="fas fa-triangle-exclamation"></i> View Overdue Items (<?= $overdue ?>)
                </a>
                <a href="reports.php" class="btn btn-outline" style="justify-content:flex-start;">
                    <i class="fas fa-chart-bar"></i> Generate Reports
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
