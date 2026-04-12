<?php
$pageTitle    = 'Documentation';
$pageSubtitle = 'Technical guide for running and understanding the system';
include 'includes/header.php';
?>

<!-- Table of Contents -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-header"><h2 class="card-title"><i class="fas fa-list-ul" style="color:var(--accent);margin-right:8px"></i>Table of Contents</h2></div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
            <?php
            $toc = [
                ['#overview',    'System Overview'],
                ['#requirements','Requirements'],
                ['#installation','Installation Guide'],
                ['#database',    'Database Setup'],
                ['#files',       'File Structure'],
                ['#crud',        'CRUD Concepts'],
                ['#deployment',  'Deployment (InfinityFree)'],
                ['#github',      'GitHub Setup'],
            ];
            foreach ($toc as $t): ?>
                <a href="<?= $t[0] ?>" style="display:flex;align-items:center;gap:8px;padding:8px 12px;background:var(--bg3);border:1px solid var(--border);border-radius:6px;font-size:13px;color:var(--text2);transition:all .2s;">
                    <i class="fas fa-arrow-right" style="font-size:10px;color:var(--accent)"></i><?= $t[1] ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Overview -->
<div class="card" id="overview" style="margin-bottom:20px;">
    <div class="card-header"><h2 class="card-title">1. System Overview</h2></div>
    <div class="card-body">
        <div class="doc-section">
            <p>The <strong style="color:var(--text)">Equipment Borrowing System (EBS)</strong> is a PHP and MySQL-based web application developed for ITEL 203 – Web Systems and Technologies. It allows administrators to manage equipment inventory and borrowing records through a clean, modern interface.</p>
            <br>
            <p>The system implements full <strong style="color:var(--text)">CRUD operations</strong> (Create, Read, Update, Delete) on two main data entities: <code>equipment</code> and <code>borrow_records</code>.</p>
        </div>
    </div>
</div>

<!-- Requirements -->
<div class="card" id="requirements" style="margin-bottom:20px;">
    <div class="card-header"><h2 class="card-title">2. Requirements</h2></div>
    <div class="card-body">
        <div class="doc-section">
            <ul>
                <li><strong style="color:var(--text)">XAMPP</strong> – Apache + MySQL local server environment</li>
                <li><strong style="color:var(--text)">PHP 7.4+</strong> – Server-side language (included in XAMPP)</li>
                <li><strong style="color:var(--text)">MySQL</strong> – Database server (via phpMyAdmin)</li>
                <li><strong style="color:var(--text)">Visual Studio Code</strong> – Recommended code editor</li>
                <li><strong style="color:var(--text)">Modern Web Browser</strong> – Chrome, Firefox, or Edge</li>
                <li><strong style="color:var(--text)">Internet Connection</strong> – For loading Google Fonts and Font Awesome</li>
            </ul>
        </div>
    </div>
</div>

<!-- Installation -->
<div class="card" id="installation" style="margin-bottom:20px;">
    <div class="card-header"><h2 class="card-title">3. Installation Guide</h2></div>
    <div class="card-body">
        <div class="doc-section">
            <h3>Step 1 — Install XAMPP</h3>
            <p>Download and install XAMPP from <code>https://apachefriends.org</code>. Launch the XAMPP Control Panel and start both <strong style="color:var(--text)">Apache</strong> and <strong style="color:var(--text)">MySQL</strong>.</p>

            <h3>Step 2 — Copy Project Files</h3>
            <p>Extract the project folder into your XAMPP htdocs directory:</p>
            <div class="code-block">C:\xampp\htdocs\ebs\</div>

            <h3>Step 3 — Set Up the Database</h3>
            <p>Open phpMyAdmin at <code>http://localhost/phpmyadmin</code>, create a new database, then import the <code>database.sql</code> file. See Section 4 for full details.</p>

            <h3>Step 4 — Configure Database Connection</h3>
            <p>Open <code>config.php</code> and update credentials if needed:</p>
            <div class="code-block">$host     = "localhost";
$user     = "root";
$password = "";       // leave blank for XAMPP default
$dbname   = "db_equipment_borrowing";</div>

            <h3>Step 5 — Run the Application</h3>
            <p>Open your browser and navigate to:</p>
            <div class="code-block">http://localhost/ebs/</div>
        </div>
    </div>
</div>

<!-- Database -->
<div class="card" id="database" style="margin-bottom:20px;">
    <div class="card-header"><h2 class="card-title">4. Database Setup</h2></div>
    <div class="card-body">
        <div class="doc-section">
            <h3>Database Name</h3>
            <p><code>db_equipment_borrowing</code></p>

            <h3>Table: equipment</h3>
            <div class="code-block">CREATE TABLE equipment (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    name             VARCHAR(150) NOT NULL,
    category         VARCHAR(100) NOT NULL,
    description      TEXT,
    serial_number    VARCHAR(100),
    total_quantity   INT NOT NULL DEFAULT 1,
    available_quantity INT NOT NULL DEFAULT 1,
    condition_status ENUM('Excellent','Good','Fair','Needs Repair'),
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);</div>

            <h3>Table: borrow_records</h3>
            <div class="code-block">CREATE TABLE borrow_records (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    borrower_name    VARCHAR(150) NOT NULL,
    borrower_email   VARCHAR(150),
    borrower_contact VARCHAR(50),
    department       VARCHAR(100),
    equipment_id     INT NOT NULL,
    quantity_borrowed INT NOT NULL DEFAULT 1,
    purpose          TEXT,
    borrow_date      DATE NOT NULL,
    expected_return  DATE NOT NULL,
    actual_return    DATE NULL,
    status           ENUM('Borrowed','Returned','Overdue') DEFAULT 'Borrowed',
    notes            TEXT,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (equipment_id) REFERENCES equipment(id)
);</div>
        </div>
    </div>
</div>

<!-- File Structure -->
<div class="card" id="files" style="margin-bottom:20px;">
    <div class="card-header"><h2 class="card-title">5. File Structure</h2></div>
    <div class="card-body">
        <div class="code-block">ebs/
├── index.php              ← Dashboard / Home
├── equipment.php          ← View all equipment
├── equipment_add.php      ← Add new equipment
├── equipment_edit.php     ← Edit equipment
├── equipment_delete.php   ← Delete equipment
├── borrowed.php           ← View borrow records
├── borrow_add.php         ← Add borrow request
├── borrow_edit.php        ← Edit borrow record
├── borrow_delete.php      ← Delete borrow record
├── borrow_return.php      ← Mark as returned
├── reports.php            ← Analytics & Reports
├── about.php              ← About the project
├── developers.php         ← About the developers
├── documentation.php      ← This page
├── contact.php            ← Contact page
├── config.php             ← DB connection + helpers
├── database.sql           ← SQL schema + sample data
├── assets/
│   └── style.css          ← Main stylesheet
└── includes/
    ├── header.php         ← Sidebar navigation + head
    └── footer.php         ← Scripts + closing tags</div>
    </div>
</div>

<!-- CRUD Concepts -->
<div class="card" id="crud" style="margin-bottom:20px;">
    <div class="card-header"><h2 class="card-title">6. CRUD Implementation</h2></div>
    <div class="card-body">
        <div class="doc-section">
            <h3>Create (INSERT)</h3>
            <div class="code-block">$sql = "INSERT INTO equipment (name, category, description, total_quantity, available_quantity)
        VALUES ('$name', '$category', '$desc', $total, $avail)";
$conn->query($sql);</div>

            <h3>Read (SELECT)</h3>
            <div class="code-block">$result = $conn->query("SELECT * FROM equipment ORDER BY name ASC");
while ($row = $result->fetch_assoc()) {
    echo $row['name'];
}</div>

            <h3>Update (UPDATE)</h3>
            <div class="code-block">$sql = "UPDATE equipment SET name='$name', category='$category' WHERE id=$id";
$conn->query($sql);</div>

            <h3>Delete (DELETE)</h3>
            <div class="code-block">$sql = "DELETE FROM equipment WHERE id=$id";
$conn->query($sql);</div>

            <h3>Database Connection (config.php)</h3>
            <div class="code-block">$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}</div>
        </div>
    </div>
</div>

<!-- Deployment -->
<div class="card" id="deployment" style="margin-bottom:20px;">
    <div class="card-header"><h2 class="card-title">7. Deployment (InfinityFree)</h2></div>
    <div class="card-body">
        <div class="doc-section">
            <ol>
                <li>Create a free account at <code>https://infinityfree.net</code></li>
                <li>Create a new hosting account and note your FTP credentials</li>
                <li>Use a FTP client (FileZilla) to upload all project files to <code>/htdocs/</code></li>
                <li>Open phpMyAdmin from the InfinityFree control panel</li>
                <li>Create database and import <code>database.sql</code></li>
                <li>Update <code>config.php</code> with InfinityFree MySQL credentials</li>
                <li>Access the site via the provided subdomain URL</li>
            </ol>
        </div>
    </div>
</div>

<!-- GitHub -->
<div class="card" id="github">
    <div class="card-header"><h2 class="card-title">8. GitHub Repository Setup</h2></div>
    <div class="card-body">
        <div class="doc-section">
            <ol>
                <li>Create a public repository on <code>https://github.com</code></li>
                <li>Initialize with a <code>README.md</code> file</li>
                <li>Upload all project files to the repository</li>
                <li>Add the following to your README:</li>
            </ol>
            <div class="code-block"># Equipment Borrowing System
**Subject:** ITEL 203 – Web Systems and Technologies
**Members:** Isleta, Justine Erick S.
             Bayani, Hyuan Andrei U.
**Features:** Equipment CRUD, Borrow Records, Reports, Search
**Deployment Link:** https://isleta-bayani-equipmentborrowingsystem.ct.ws/</div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
