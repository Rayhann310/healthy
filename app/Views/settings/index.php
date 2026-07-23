<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/sidebar.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/navbar.php'; ?>

<div class="page-title">Pengaturan Profil</div>

<div class="card" style="max-width: 600px;">
    <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
        <div class="avatar" style="width: 80px; height: 80px; font-size: 2.5rem;">
            <?= substr(htmlspecialchars($username ?? 'U'), 0, 1) ?>
        </div>
        <div>
            <h2 style="margin: 0; color: var(--dark); font-size: 1.5rem;"><?= htmlspecialchars($username ?? 'Administrator') ?></h2>
            <p style="color: var(--text-gray); margin-top: 0.3rem;">Hak Akses: Administrator</p>
        </div>
    </div>
    
    <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 2rem 0;">

    <h3 style="margin-bottom: 1.5rem;">Informasi Akun</h3>
    <form onsubmit="event.preventDefault(); alert('Modul ubah profil belum diaktifkan.');">
        <div class="form-group">
            <label class="form-label">Username Saat Ini</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($username ?? '') ?>" readonly style="background: #f3f4f6; color: var(--text-gray);">
            <small style="color: var(--text-light); margin-top: 0.5rem; display: block;">Username tidak dapat diubah (ReadOnly).</small>
        </div>
        
        <div class="form-group" style="margin-top: 1.5rem;">
            <label class="form-label">Kata Sandi Baru</label>
            <input type="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Simpan Perubahan</button>
    </form>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
