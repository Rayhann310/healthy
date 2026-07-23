<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/sidebar.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/navbar.php'; ?>

<div class="flex-between" style="margin-bottom: 1.5rem;">
    <div class="page-title" style="margin-bottom: 0;">Laporan Data Tensi</div>
    <a href="<?= base_url('reports/pdf?start_date=' . urlencode($start_date) . '&end_date=' . urlencode($end_date)) ?>" target="_blank" class="btn btn-primary" style="background-color: var(--secondary); border: none;">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        Cetak PDF
    </a>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <form method="GET" action="<?= base_url('reports') ?>" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div class="form-group" style="margin-bottom: 0; min-width: 200px;">
            <label class="form-label">Mulai Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>" required>
        </div>
        <div class="form-group" style="margin-bottom: 0; min-width: 200px;">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Filter Laporan</button>
    </form>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card">
        <h3 style="color: var(--text-gray); font-size: 0.9rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem;">Total Pengukuran</h3>
        <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">
            <?= htmlspecialchars($totalMeasurements) ?> 
            <span style="font-size: 1rem; color: var(--text-light); font-weight: 500;">kali</span>
        </div>
    </div>
    
    <div class="card">
        <h3 style="color: var(--text-gray); font-size: 0.9rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem;">Tensi Tinggi Terdeteksi</h3>
        <div style="font-size: 2.5rem; font-weight: 800; color: #ef4444;">
            <?= htmlspecialchars($highBpCount) ?> 
            <span style="font-size: 1rem; color: var(--text-light); font-weight: 500;">kali</span>
        </div>
    </div>
</div>

<div class="card table-responsive">
    <h3 style="margin-bottom: 1rem; color: var(--dark);">Pratinjau Data (<?= htmlspecialchars($start_date) ?> - <?= htmlspecialchars($end_date) ?>)</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color); color: var(--text-gray);">
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Waktu</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Pasien</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">SYS/DIA</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Nadi</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">SpO2</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($logs)): ?>
                <tr><td colspan="5" style="text-align: center; padding: 2rem;">Data tidak ditemukan pada rentang tanggal ini.</td></tr>
            <?php else: ?>
                <?php foreach($logs as $log): ?>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 1rem 0.5rem;"><?= date('d M Y, H:i', strtotime($log['measured_at'])) ?></td>
                    <td style="padding: 1rem 0.5rem; font-weight: 600; color: var(--primary);"><?= htmlspecialchars($log['patient_name'] ?? 'Anonim') ?></td>
                    <td style="padding: 1rem 0.5rem; font-weight: 600;"><?= htmlspecialchars($log['systolic']) ?>/<?= htmlspecialchars($log['diastolic']) ?></td>
                    <td style="padding: 1rem 0.5rem;"><?= htmlspecialchars($log['heart_rate'] ?? '-') ?></td>
                    <td style="padding: 1rem 0.5rem;"><?= htmlspecialchars($log['oxygen_saturation'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
