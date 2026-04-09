
</main><!-- end .main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
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

    // magfflash na message
    const flash = document.querySelector('.flash');
    if (flash) {
        setTimeout(() => flash.style.opacity = '0', 3500);
        setTimeout(() => flash.remove(), 4000);
    }

    // ddelete nare
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
