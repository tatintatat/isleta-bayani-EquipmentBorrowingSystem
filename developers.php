<?php
$pageTitle    = 'Meet the Developers';
$pageSubtitle = 'The team behind the Equipment Borrowing System';
include 'includes/header.php';

$developers = [
    [
        'name'  => 'Justine Erick S. Isleta',
        'role'  => 'Full-Stack Developer / Project Lead',
        'photo' => 'img/Isleta.jpg',
        'contributions' => [
            'Designed overall system architecture and database schema',
            'Developed the main application logic (index.php, config.php)',
            'Implemented all CRUD operations for equipment and borrow records',
            'Led team coordination and task distribution',
        ],
    ],
    [
        'name'  => 'Hyuan Andrei U. Bayani',
        'role'  => 'UI/UX Designer / Frontend Developer',
        'photo' => 'img/Bayani.jpg',
        'contributions' => [
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

        <!-- Profile Photo -->
        <?php if (file_exists($dev['photo'])): ?>
            <img src="<?= $dev['photo'] ?>"
                 alt="<?= htmlspecialchars($dev['name']) ?>"
                 style="width:110px;height:110px;border-radius:50%;object-fit:cover;object-position:top;border:3px solid var(--border2);display:block;margin:0 auto 16px;">
        <?php else: ?>
            <div style="width:110px;height:110px;border-radius:50%;background:var(--bg3);border:3px dashed var(--border2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fas fa-user" style="font-size:36px;color:var(--text3);"></i>
            </div>
        <?php endif; ?>

        <div class="dev-name"><?= htmlspecialchars($dev['name']) ?></div>
        <div class="dev-role"><?= htmlspecialchars($dev['role']) ?></div>

        <ul style="list-style:none;text-align:left;border-top:1px solid var(--border);padding-top:14px;margin-top:12px;">
            <?php foreach ($dev['contributions'] as $c): ?>
                <li style="font-size:13px;color:var(--text2);padding:4px 0;display:flex;gap:8px;align-items:flex-start;">
                    <i class="fas fa-check" style="color:var(--accent);font-size:11px;margin-top:5px;flex-shrink:0;"></i>
                    <?= htmlspecialchars($c) ?>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
    <?php endforeach; ?>
</div>

<!-- Group Info -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-users-gear" style="color:var(--accent);margin-right:8px"></i>Group Details
        </h2>
    </div>
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