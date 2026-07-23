    <div class="main-content">
        <nav class="navbar">
            <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
            <div class="navbar-title">
                Ringkasan
            </div>
            <div class="navbar-user">
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn">Keluar</a>
                <div class="avatar">
                    <?= substr(htmlspecialchars($username ?? 'U'), 0, 1) ?>
                </div>
            </div>
        </nav>
        
        <div class="content">
