<?php
// includes/header.php
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Equipment Borrowing System' ?> | EBS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-box-archive"></i></div>
        <div class="brand-text">
            <span class="brand-name">EBS</span>
            <span class="brand-sub">Equipment Borrowing</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="index.php" class="nav-item <?= $currentPage === 'index' ? 'active' : '' ?>">
            <i class="fas fa-house"></i><span>Home</span>
        </a>
        <a href="equipment.php" class="nav-item <?= $currentPage === 'equipment' ? 'active' : '' ?>">
            <i class="fas fa-microchip"></i><span>Equipment Available</span>
        </a>
        <a href="borrowed.php" class="nav-item <?= $currentPage === 'borrowed' ? 'active' : '' ?>">
            <i class="fas fa-hand-holding"></i><span>Equipment Borrowed</span>
        </a>
        <a href="reports.php" class="nav-item <?= $currentPage === 'reports' ? 'active' : '' ?>">
            <i class="fas fa-chart-bar"></i><span>Reports</span>
        </a>
        <div class="nav-divider"></div>
        <a href="about.php" class="nav-item <?= $currentPage === 'about' ? 'active' : '' ?>">
            <i class="fas fa-circle-info"></i><span>About</span>
        </a>
        <a href="developers.php" class="nav-item <?= $currentPage === 'developers' ? 'active' : '' ?>">
            <i class="fas fa-users"></i><span>Developers</span>
        </a>
        <a href="documentation.php" class="nav-item <?= $currentPage === 'documentation' ? 'active' : '' ?>">
            <i class="fas fa-book"></i><span>Documentation</span>
        </a>
        <a href="contact.php" class="nav-item <?= $currentPage === 'contact' ? 'active' : '' ?>">
            <i class="fas fa-envelope"></i><span>Contact</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <p>ITEL 203 &mdash; Team Rizal rights 
           Sponsored by: AkayniBossRhein, Team Welog, Tato Shawarma, Noliboy's Poultry</p>
    </div>
</div>

<div class="topbar">
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>
    <span class="topbar-title"><?= $pageTitle ?? 'Equipment Borrowing System' ?></span>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- Main Content Wrapper -->
<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title"><?= $pageTitle ?? '' ?></h1>
            <?php if (!empty($pageSubtitle)): ?>
                <p class="page-subtitle"><?= $pageSubtitle ?></p>
            <?php endif; ?>
        </div>
        <?php if (!empty($pageAction)): ?>
            <div class="page-actions"><?= $pageAction ?></div>
        <?php endif; ?>
    </div>

