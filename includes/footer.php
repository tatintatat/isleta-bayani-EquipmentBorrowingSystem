
</main><!-- end .main-content -->

<script>
    // Sidebar mobile toggle
    const toggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });
    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    // Flash message auto-dismiss
    const flash = document.querySelector('.flash');
    if (flash) {
        setTimeout(() => flash.style.opacity = '0', 3500);
        setTimeout(() => flash.remove(), 4000);
    }

    // Confirm delete
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', e => {
            if (!confirm('Are you sure you want to delete this record? This cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>
