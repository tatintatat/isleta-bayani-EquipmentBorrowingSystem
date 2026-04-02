<?php
include 'config.php';
$pageTitle    = 'Reports & Analytics';
$pageSubtitle = 'Overview of borrowing activity and equipment usage';

// Summary stats
$totalEq     = $conn->query("SELECT COUNT(*) AS c FROM equipment")->fetch_assoc()['c'];
$totalBorrow = $conn->query("SELECT COUNT(*) AS c FROM borrow_records")->fetch_assoc()['c'];
$returned    = $conn->query("SELECT COUNT(*) AS c FROM borrow_records WHERE status='Returned'")->fetch_assoc()['c'];
$overdue     = $conn->query("SELECT COUNT(*) AS c FROM borrow_records WHERE status='Overdue'")->fetch_assoc()['c'];
$active      = $conn->query("SELECT COUNT(*) AS c FROM borrow_records WHERE status='Borrowed'")->fetch_assoc()['c'];

// Most borrowed equipment
$mostBorrowed = $conn->query("
    SELECT e.name, COUNT(br.id) AS borrow_count
    FROM borrow_records br
    JOIN equipment e ON br.equipment_id = e.id
    GROUP BY br.equipment_id
    ORDER BY borrow_count DESC LIMIT 8
");

// Borrow by department
$byDept = $conn->query("
    SELECT department, COUNT(*) AS cnt
    FROM borrow_records
    WHERE department != ''
    GROUP BY department
    ORDER BY cnt DESC LIMIT 6
");

// Equipment by category
$byCategory = $conn->query("
    SELECT category, COUNT(*) AS cnt, SUM(total_quantity) AS total, SUM(available_quantity) AS avail
    FROM equipment
    GROUP BY category ORDER BY cnt DESC
");

// Recent monthly activity (last 6 months)
$monthly = $conn->query("
    SELECT DATE_FORMAT(borrow_date, '%b %Y') AS month,
           COUNT(*) AS borrows,
           SUM(CASE WHEN status='Returned' THEN 1 ELSE 0 END) AS returns
    FROM borrow_records
    WHERE borrow_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(borrow_date, '%Y-%m')
    ORDER BY borrow_date ASC
");

// Max borrow count for scaling bars
$maxRow = $conn->query("
    SELECT MAX(cnt) AS m FROM (
        SELECT COUNT(*) AS cnt FROM borrow_records GROUP BY equipment_id
    ) t
")->fetch_assoc();
$maxCount = max(1, $maxRow['m'] ?? 1);

$maxDept = $conn->query("SELECT MAX(cnt) AS m FROM (SELECT COUNT(*) AS cnt FROM borrow_records GROUP BY department) t")->fetch_assoc();
$maxDeptCount = max(1, $maxDept['m'] ?? 1);

include 'includes/header.php';
?>

<!-- Summary Stats -->
<div class="stats-grid" style="margin-bottom:28px;">
    <div class="stat-card blue">
        <div class="stat-icon blue"><i class="fas fa-boxes-stacked"></i></div>
        <div><div class="stat-value"><?= $totalEq ?></div><div class="stat-label">Total Equipment</div></div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon blue"><i class="fas fa-clipboard-list"></i></div>
        <div><div class="stat-value"><?= $totalBorrow ?></div><div class="stat-label">Total Borrow Records</div></div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon green"><i class="fas fa-rotate-left"></i></div>
        <div><div class="stat-value"><?= $returned ?></div><div class="stat-label">Returned</div></div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon orange"><i class="fas fa-hand-holding"></i></div>
        <div><div class="stat-value"><?= $active ?></div><div class="stat-label">Currently Borrowed</div></div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon red"><i class="fas fa-clock"></i></div>
        <div><div class="stat-value"><?= $overdue ?></div><div class="stat-label">Overdue</div></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">

    <!-- Most Borrowed Equipment -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-chart-bar" style="color:var(--accent);margin-right:8px"></i>Most Borrowed Equipment</h2>
        </div>
        <div class="card-body">
            <?php if ($mostBorrowed->num_rows === 0): ?>
                <p style="color:var(--text3);font-size:14px;">No data yet.</p>
            <?php else: ?>
                <?php while($row = $mostBorrowed->fetch_assoc()): 
                    $pct = round(($row['borrow_count'] / $maxCount) * 100);
                ?>
                <div class="chart-bar-row">
                    <div class="chart-label" title="<?= htmlspecialchars($row['name']) ?>"><?= htmlspecialchars(substr($row['name'],0,22)) ?></div>
                    <div class="chart-track"><div class="chart-fill" style="width:<?= $pct ?>%"></div></div>
                    <div class="chart-val"><?= $row['borrow_count'] ?>x</div>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Borrow by Department -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-building" style="color:var(--accent);margin-right:8px"></i>Borrowing by Department</h2>
        </div>
        <div class="card-body">
            <?php if ($byDept->num_rows === 0): ?>
                <p style="color:var(--text3);font-size:14px;">No data yet.</p>
            <?php else: ?>
                <?php while($row = $byDept->fetch_assoc()): 
                    $pct = round(($row['cnt'] / $maxDeptCount) * 100);
                ?>
                <div class="chart-bar-row">
                    <div class="chart-label" title="<?= htmlspecialchars($row['department']) ?>"><?= htmlspecialchars(substr($row['department'],0,22)) ?></div>
                    <div class="chart-track">
                        <div class="chart-fill" style="width:<?= $pct ?>%;background:linear-gradient(90deg,var(--success),#14b87a)"></div>
                    </div>
                    <div class="chart-val"><?= $row['cnt'] ?></div>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Equipment by Category & Monthly -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">

    <!-- Equipment by Category -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-tags" style="color:var(--accent);margin-right:8px"></i>Equipment by Category</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Types</th>
                        <th>Total Units</th>
                        <th>Available</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $byCategory->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['category']) ?></strong></td>
                        <td><?= $row['cnt'] ?></td>
                        <td><?= $row['total'] ?></td>
                        <td>
                            <span style="color:<?= $row['avail']>0?'var(--success)':'var(--danger)' ?>">
                                <?= $row['avail'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Monthly Activity -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-calendar-days" style="color:var(--accent);margin-right:8px"></i>Monthly Borrow Activity</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Month</th><th>Borrowed</th><th>Returned</th><th>Balance</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $monthlyData = [];
                    while($row = $monthly->fetch_assoc()) $monthlyData[] = $row;
                    if (empty($monthlyData)): ?>
                        <tr><td colspan="4" style="text-align:center;color:var(--text3);padding:30px;">No monthly data yet.</td></tr>
                    <?php else: foreach($monthlyData as $row): $bal = $row['borrows'] - $row['returns']; ?>
                    <tr>
                        <td><?= $row['month'] ?></td>
                        <td><?= $row['borrows'] ?></td>
                        <td><?= $row['returns'] ?></td>
                        <td><span style="color:<?= $bal>0?'var(--warning)':'var(--success)' ?>"><?= $bal ?></span></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Return Rate -->
<?php if ($totalBorrow > 0): 
    $returnRate = round(($returned / $totalBorrow) * 100);
    $onTimeRate = round(($active   / $totalBorrow) * 100);
    $overdueRate= round(($overdue  / $totalBorrow) * 100);
?>
<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="fas fa-chart-pie" style="color:var(--accent);margin-right:8px"></i>Overall Borrow Status Distribution</h2>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:32px;text-align:center;">
            <div>
                <div style="font-size:42px;font-family:var(--font-head);font-weight:800;color:var(--success)"><?= $returnRate ?>%</div>
                <div style="font-size:13px;color:var(--text2);margin-top:6px">Return Rate</div>
                <div style="margin-top:10px;height:6px;background:var(--bg3);border-radius:10px;overflow:hidden;">
                    <div style="height:100%;width:<?= $returnRate ?>%;background:var(--success);border-radius:10px;"></div>
                </div>
            </div>
            <div>
                <div style="font-size:42px;font-family:var(--font-head);font-weight:800;color:var(--accent)"><?= $onTimeRate ?>%</div>
                <div style="font-size:13px;color:var(--text2);margin-top:6px">Currently Active</div>
                <div style="margin-top:10px;height:6px;background:var(--bg3);border-radius:10px;overflow:hidden;">
                    <div style="height:100%;width:<?= $onTimeRate ?>%;background:var(--accent);border-radius:10px;"></div>
                </div>
            </div>
            <div>
                <div style="font-size:42px;font-family:var(--font-head);font-weight:800;color:var(--danger)"><?= $overdueRate ?>%</div>
                <div style="font-size:13px;color:var(--text2);margin-top:6px">Overdue Rate</div>
                <div style="margin-top:10px;height:6px;background:var(--bg3);border-radius:10px;overflow:hidden;">
                    <div style="height:100%;width:<?= $overdueRate ?>%;background:var(--danger);border-radius:10px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
