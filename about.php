<?php
$pageTitle    = 'About the Project';
$pageSubtitle = 'Equipment Borrowing System — ITEL 203';
include 'includes/header.php';
?>

<!-- Hero banner -->
<div class="hero" style="margin-bottom:28px;">
    <div class="hero-tag"><i class="fas fa-circle-info"></i> About This System</div>
    <h2>Equipment Borrowing<br><span>System (EBS)</span></h2>
    <p>A web-based platform built with PHP and MySQL that allows institutions to efficiently manage, track, and monitor equipment borrowing activities in real time.</p>
</div>

<!-- Project Info -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">
    <div class="card">
        <div class="card-header"><h2 class="card-title"><i class="fas fa-bullseye" style="color:var(--accent);margin-right:8px"></i>Purpose of the System</h2></div>
        <div class="card-body">
            <div class="doc-section">
                <p>The <strong style="color:var(--text)">Equipment Borrowing System (EBS)</strong> was developed to address the common challenges in manually tracking borrowed equipment in educational institutions and organizations.</p>
                <br>
                <p>The system aims to:</p>
                <ul style="margin-top:10px;">
                    <li>Eliminate paperwork and manual borrowing logbooks</li>
                    <li>Provide real-time visibility of equipment availability</li>
                    <li>Automate overdue tracking and alert administrators</li>
                    <li>Generate meaningful reports on usage patterns</li>
                    <li>Maintain a complete audit trail of all borrowing activity</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h2 class="card-title"><i class="fas fa-code" style="color:var(--accent);margin-right:8px"></i>Technologies Used</h2></div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:14px;">
                <?php
                $techs = [
                    ['PHP 8.x',         'Server-side scripting language',          'fa-code',           'var(--accent)'],
                    ['MySQL / XAMPP',    'Relational database management system',   'fa-database',       'var(--success)'],
                    ['HTML5 / CSS3',     'Markup and styling of the interface',     'fa-file-code',      'var(--warning)'],
                    ['Font Awesome 6',   'Icon library for UI elements',            'fa-icons',          'var(--info)'],
                    ['Google Fonts',     'Syne & DM Sans typography',               'fa-font',           'var(--accent2)'],
                    ['InfinityFree',     'Free PHP hosting deployment platform',    'fa-cloud-arrow-up', 'var(--danger)'],
                    ['GitHub',          'Source code version control repository',  'fa-brands fa-github','var(--text2)'],
                ];
                foreach ($techs as $t): ?>
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:36px;height:36px;background:var(--bg3);border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;justify-content:center;color:<?= $t[3] ?>;flex-shrink:0;font-size:14px;">
                        <i class="fas <?= $t[0]==='GitHub'?'fa-brands fa-github':$t[2] ?>"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:var(--text)"><?= $t[0] ?></div>
                        <div style="font-size:12px;color:var(--text3)"><?= $t[1] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Features -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-header"><h2 class="card-title"><i class="fas fa-star" style="color:var(--accent);margin-right:8px"></i>System Features</h2></div>
    <div class="card-body">
        <div class="about-grid">
            <?php
            $features = [
                ['fa-plus-circle',        'Create Records',           'Add new equipment and borrow requests through intuitive forms with input validation.'],
                ['fa-table-list',         'View All Records',         'Browse all equipment and borrow records in organized, searchable data tables.'],
                ['fa-pen-to-square',      'Edit & Update',            'Modify existing equipment details and borrow records with full inline editing support.'],
                ['fa-trash-can',          'Delete Records',           'Remove outdated or incorrect records with confirmation prompts for data safety.'],
                ['fa-magnifying-glass',   'Search & Filter',          'Quickly find records by name, department, status, or category with live filtering.'],
                ['fa-rotate-left',        'Return Tracking',          'Mark items as returned with one click, automatically restoring equipment availability.'],
                ['fa-triangle-exclamation','Overdue Detection',       'Automatically highlights overdue borrowing records so admins can follow up quickly.'],
                ['fa-chart-bar',          'Reports & Analytics',      'Visual reports showing borrowing frequency, department usage, and return rates.'],
            ];
            foreach ($features as $f): ?>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas <?= $f[0] ?>"></i></div>
                <div>
                    <div class="feature-title"><?= $f[1] ?></div>
                    <div class="feature-desc"><?= $f[2] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Project Details -->
<div class="card">
    <div class="card-header"><h2 class="card-title"><i class="fas fa-graduation-cap" style="color:var(--accent);margin-right:8px"></i>Project Information</h2></div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:24px;text-align:center;">
            <div style="padding:20px;background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius);">
                <div style="font-size:28px;font-family:var(--font-head);font-weight:800;color:var(--accent)">ITEL 203</div>
                <div style="font-size:12px;color:var(--text3);margin-top:6px;text-transform:uppercase;letter-spacing:.08em">Subject Code</div>
            </div>
            <div style="padding:20px;background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius);">
                <div style="font-size:14px;font-family:var(--font-head);font-weight:700;color:var(--text)">Web Systems &<br>Technologies</div>
                <div style="font-size:12px;color:var(--text3);margin-top:6px;text-transform:uppercase;letter-spacing:.08em">Subject Title</div>
            </div>
            <div style="padding:20px;background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius);">
                <div style="font-size:14px;font-family:var(--font-head);font-weight:700;color:var(--text)">Group Performance<br>Task #2</div>
                <div style="font-size:12px;color:var(--text3);margin-top:6px;text-transform:uppercase;letter-spacing:.08em">Assessment Type</div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
