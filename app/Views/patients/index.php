<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/sidebar.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/navbar.php'; ?>

<div class="flex-between" style="margin-bottom: 1.5rem;">
    <div class="page-title" style="margin-bottom: 0;">Daftar Pasien</div>
    <button class="btn btn-primary" onclick="document.getElementById('patientModal').classList.add('active')">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
        Tambah Pasien
    </button>
</div>

<div class="card table-responsive">
    <table style="width: 100%; border-collapse: collapse; text-align: left;" id="patientTable">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color); color: var(--text-gray);">
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">ID</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Nama Pasien</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Umur / Gender</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Kontak</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($patients)): ?>
                <tr id="empty-row"><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">Belum ada data pasien tercatat.</td></tr>
            <?php else: ?>
                <?php foreach ($patients as $p): ?>
                <tr style="border-bottom: 1px solid var(--border-color);" id="row-<?= $p['id'] ?>">
                    <td style="padding: 1rem 0.5rem; font-weight: 600;">#<?= $p['id'] ?></td>
                    <td style="padding: 1rem 0.5rem; font-weight: 600; color: var(--primary);"><?= htmlspecialchars($p['name']) ?></td>
                    <td style="padding: 1rem 0.5rem;"><?= htmlspecialchars($p['age']) ?> thn / <?= htmlspecialchars($p['gender']) ?></td>
                    <td style="padding: 1rem 0.5rem;"><?= htmlspecialchars($p['contact'] ?? '-') ?></td>
                    <td style="padding: 1rem 0.5rem;">
                        <button onclick="deletePatient(<?= $p['id'] ?>)" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-weight: 600;">Hapus</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Pasien -->
<div class="modal-overlay" id="patientModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Data Pasien</h2>
            <button class="modal-close" onclick="document.getElementById('patientModal').classList.remove('active')">&times;</button>
        </div>
        <form id="patientForm">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required placeholder="Budi Santoso">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Umur</label>
                    <input type="number" name="age" class="form-control" required placeholder="Contoh: 35">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="gender" class="form-control" required>
                        <option value="">Pilih...</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Kontak</label>
                <input type="text" name="contact" class="form-control" placeholder="08123456789">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;" id="btnSubmit">Simpan Pasien</button>
        </form>
    </div>
</div>

<script>
document.getElementById('patientForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmit');
    const form = this;
    
    btn.innerHTML = 'Menyimpan...';
    btn.disabled = true;

    const formData = new FormData(form);
    
    fetch('<?= base_url("patients/store") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            document.getElementById('patientModal').classList.remove('active');
            form.reset();
            
            const newRow = `
                <tr style="border-bottom: 1px solid var(--border-color); animation: fadeIn 0.5s;" id="row-${data.data.id}">
                    <td style="padding: 1rem 0.5rem; font-weight: 600;">#${data.data.id}</td>
                    <td style="padding: 1rem 0.5rem; font-weight: 600; color: var(--primary);">${data.data.name}</td>
                    <td style="padding: 1rem 0.5rem;">${data.data.age} thn / ${data.data.gender}</td>
                    <td style="padding: 1rem 0.5rem;">${data.data.contact ? data.data.contact : '-'}</td>
                    <td style="padding: 1rem 0.5rem;">
                        <button onclick="deletePatient(${data.data.id})" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-weight: 600;">Hapus</button>
                    </td>
                </tr>
            `;
            
            const tbody = document.querySelector('#patientTable tbody');
            const emptyRow = document.getElementById('empty-row');
            if(emptyRow) emptyRow.remove();
            
            tbody.insertAdjacentHTML('afterbegin', newRow);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan koneksi.');
        console.error(error);
    })
    .finally(() => {
        btn.innerHTML = 'Simpan Pasien';
        btn.disabled = false;
    });
});

function deletePatient(id) {
    if(!confirm('Apakah Anda yakin ingin menghapus data pasien ini?')) return;
    
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('<?= base_url("patients/delete") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const row = document.getElementById('row-' + id);
            if(row) {
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 300);
            }
        } else {
            alert(data.message);
        }
    });
}
</script>

<style>
@keyframes fadeIn {
    from { background: rgba(0, 118, 182, 0.1); opacity: 0; }
    to { background: transparent; opacity: 1; }
}
</style>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
