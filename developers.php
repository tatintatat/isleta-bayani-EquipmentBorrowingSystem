<?php
$pageTitle    = 'Meet the Developers';
$pageSubtitle = 'The team behind the Equipment Borrowing System';
include 'includes/header.php';

$developers = [
    [
        'name'         => 'Justine Erick S. Isleta',
        'role'         => 'Full-Stack Developer / Project Lead',
        'color'        => 'linear-gradient(135deg,#4f8ef7,#6366f1)',
        'contributions'=> [
            'Designed overall system architecture and database schema',
            'Developed the main application logic (index.php, config.php)',
            'Implemented all CRUD operations for equipment and borrow records',
            'Led team coordination and task distribution',
        ],
    ],
    [
        'name'         => 'Hyuan Andrei U. Bayani',
        'role'         => 'UI/UX Designer / Frontend Developer',
        'color'        => 'linear-gradient(135deg,#22c87a,#14b87a)',
        'contributions'=> [
            'Designed the entire UI layout and visual design system',
            'Built the CSS stylesheet and responsive mobile layout',
            'Created equipment.php and the equipment card grid interface',
            'Ensured cross-browser compatibility and accessibility',
        ],
    ],
   
];
?>

<div class="dev-grid" style="margin-bottom:32px;">
    <?php foreach ($developers as $dev): ?>
    <div class="dev-card">
        <div class="dev-avatar" style="background:<?= $dev['color'] ?>"><?= $dev['initials'] ?></div>
        <div class="dev-name"><?= htmlspecialchars($dev['name']) ?></div>
        <div class="dev-role"><?= htmlspecialchars($dev['role']) ?></div>
        <ul style="list-style:none;text-align:left;border-top:1px solid var(--border);padding-top:16px;">
            <?php foreach ($dev['contributions'] as $c): ?>
                <li style="font-size:13px;color:var(--text2);line-height:1.6;padding:4px 0;display:flex;align-items:flex-start;gap:8px;">
                    <i class="fas fa-check" style="color:var(--accent);font-size:11px;margin-top:4px;flex-shrink:0;"></i>
                    <?= htmlspecialchars($c) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endforeach; ?>
</div>

<!-- Group Info -->
<div class="card">
    <div class="card-header"><h2 class="card-title"><i class="fas fa-users-gear" style="color:var(--accent);margin-right:8px"></i>Group Details</h2></div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:24px;">
            <?php
            $infos = [
                ['fa-book-open',    'Subject',    'ITEL 203 – Web Systems and Technologies'],
                ['fa-list-check',   'Task',       'Group Performance Task #2: PHP & MySQL CRUD'],
                ['fa-people-group', 'Group Size', '3 Students per Group'],
                ['fa-laptop-code',  'System',     'Equipment Borrowing System'],
                ['fa-cloud',        'Deployed on','InfinityFree'],
                ['fa-code-branch',  'Repository', 'GitHub (Public)'],
            ];
            foreach ($infos as $i): ?>
            <div style="display:flex;align-items:flex-start;gap:12px;">
                <div style="width:36px;height:36px;background:var(--bg3);border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--accent);font-size:14px;flex-shrink:0;">
                    <i class="fas <?= $i[0] ?>"></i>
                </div>
                <div>
                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:var(--text3);margin-bottom:3px;"><?= $i[1] ?></div>
                    <div style="font-size:13px;color:var(--text);font-weight:500;"><?= $i[2] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
