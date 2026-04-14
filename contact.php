<?php
$pageTitle    = 'Contact Us';
$pageSubtitle = 'Get in touch with the development team';

// Handle contact form submission (stores in session for demo)
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real system, you'd send an email using mail() or PHPMailer
    // For demo purposes, we just set a success flag
    $sent = true;
}

include 'includes/header.php';
?>

<?php if ($sent): ?>
<div class="flash success"><i class="fas fa-check-circle"></i>Thank you! Your message has been sent. We'll get back to you soon.</div>
<?php endif; ?>

<div class="contact-grid">
    <!-- Contact Form -->
    <div class="card">
        <div class="card-header"><h2 class="card-title"><i class="fas fa-paper-plane" style="color:var(--accent);margin-right:8px"></i>Send a Message</h2></div>
        <div class="card-body">
            <form method="POST">
                <div class="form-grid cols-1" style="gap:16px;">
                    <div class="form-group">
                        <label>Your Name *</label>
                        <input type="text" name="contact_name" placeholder="Full name" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="contact_email" placeholder="you@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <select name="contact_subject">
                            <option value="">Select a topic</option>
                            <option>Technical Support</option>
                            <option>Bug Report</option>
                            <option>Feature Request</option>
                            <option>General Inquiry</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Message *</label>
                        <textarea name="contact_message" placeholder="Write your message here..." style="min-height:140px;" required></textarea>
                    </div>
                </div>
                <div class="form-actions" style="margin-top:20px;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send Message</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contact Info -->
    <div>
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2 class="card-title"><i class="fas fa-address-book" style="color:var(--accent);margin-right:8px"></i>Contact Information</h2></div>
            <div class="card-body" style="padding:16px 24px;">
                <?php
                $contacts = [
                    ['fa-envelope',         'Email',       'TeamRizal@school.edu.ph'],
                    ['fa-phone',            'Phone',       '+63 908 1800 113'],
                    ['fa-location-dot',     'Location',    'College of Computer Studies'],
                    ['fa-school',           'Institution', 'Laguna State Polytechnic University San Pablo City Campus'],
                    ['fa-clock',            'Office Hours','Mon – Fri, 8:00 AM – 5:00 PM'],
                ];
                foreach ($contacts as $c): ?>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="fas <?= $c[0] ?>"></i></div>
                    <div>
                        <div class="contact-label"><?= $c[1] ?></div>
                        <div class="contact-value"><?= $c[2] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h2 class="card-title"><i class="fas fa-link" style="color:var(--accent);margin-right:8px"></i>Project Links</h2></div>
            <div class="card-body">
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <a href="https://github.com/tatintatat/isleta-bayani-EquipmentBorrowedSystem/" class="btn btn-outline" style="justify-content:flex-start;">
                        <i class="fab fa-github"></i> GitHub Repository
                    </a>
                    <a href="#" class="btn btn-outline" style="justify-content:flex-start;">
                        <i class="fas fa-cloud"></i> Live Site (InfinityFree)
                    </a>
                    <a href="https://canva.link/84pgtrr7glcuczj" class="btn btn-outline" style="justify-content:flex-start;">
                        <i class=""></i> Canva Presentation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ -->
<div class="card" style="margin-top:24px;">
    <div class="card-header"><h2 class="card-title"><i class="fas fa-circle-question" style="color:var(--accent);margin-right:8px"></i>Frequently Asked Questions</h2></div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <?php
            $faqs = [
                ['How do I add new equipment?',       'Go to Equipment Available and click the "Add Equipment" button in the top right.'],
                ['How do I mark an item as returned?','Open Equipment Borrowed, find the record, and click the green return button.'],
                ['What happens when I delete a borrow record?', 'The equipment quantity is automatically restored to the available count.'],
                ['Can I search for specific records?', 'Yes! Both the Equipment and Borrowed pages have search bars with filter options.'],
                ['Where is the overdue report?',      'The Reports page shows overdue statistics, or filter by Overdue in Borrowed page.'],
                ['How do I deploy to InfinityFree?',  'See the Documentation page Section 7 for a complete step-by-step deployment guide.'],
            ];
            foreach ($faqs as $faq): ?>
            <div style="padding:16px;background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-sm);">
                <div style="font-size:14px;font-weight:600;color:var(--text);margin-bottom:8px;">
                    <i class="fas fa-chevron-right" style="color:var(--accent);font-size:11px;margin-right:6px;"></i><?= $faq[0] ?>
                </div>
                <div style="font-size:13px;color:var(--text2);line-height:1.6;"><?= $faq[1] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
