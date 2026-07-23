<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/sidebar.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/navbar.php'; ?>

<div class="flex-between" style="margin-bottom: 1.5rem;">
    <div class="page-title" style="margin-bottom: 0;">Ringkasan Tensi</div>
    <a href="<?= base_url('blood-pressure') ?>" class="btn btn-primary" style="text-decoration: none;">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Buka Data Tensi
    </a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Card 1 -->
    <div class="card">
        <h3 style="color: var(--text-gray); font-size: 0.9rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem;">Sistolik Terakhir</h3>
        <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);" id="stat-sys">
            <?= $latest ? htmlspecialchars($latest['systolic']) : '--' ?> 
            <span style="font-size: 1rem; color: var(--text-light); font-weight: 500;">mmHg</span>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="card">
        <h3 style="color: var(--text-gray); font-size: 0.9rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem;">Diastolik Terakhir</h3>
        <div style="font-size: 2.5rem; font-weight: 800; color: #f59e0b;" id="stat-dia">
            <?= $latest ? htmlspecialchars($latest['diastolic']) : '--' ?> 
            <span style="font-size: 1rem; color: var(--text-light); font-weight: 500;">mmHg</span>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="card">
        <h3 style="color: var(--text-gray); font-size: 0.9rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem;">Detak Jantung</h3>
        <div style="font-size: 2.5rem; font-weight: 800; color: #ef4444;" id="stat-hr">
            <?= $latest && $latest['heart_rate'] ? htmlspecialchars($latest['heart_rate']) : '--' ?> 
            <span style="font-size: 1rem; color: var(--text-light); font-weight: 500;">bpm</span>
        </div>
    </div>
</div>

<div class="card table-responsive">
    <h3 style="margin-bottom: 1rem;">Riwayat Pengukuran</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: left;" id="bpTable">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color); color: var(--text-gray);">
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Tanggal & Waktu</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">SYS / DIA</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Detak Jantung</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logs)): ?>
                <tr id="empty-row"><td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-light);">Belum ada data tercatat.</td></tr>
            <?php else: ?>
                <?php foreach ($logs as $log): 
                    $time = strtotime($log['measured_at']);
                    $statusStr = 'Normal';
                    $statusColor = 'rgba(140, 198, 63, 0.1)';
                    $statusText = 'var(--secondary)';
                    
                    if ($log['systolic'] >= 140 || $log['diastolic'] >= 90) {
                        $statusStr = 'Tinggi';
                        $statusColor = 'rgba(239, 68, 68, 0.1)';
                        $statusText = '#ef4444';
                    } elseif ($log['systolic'] >= 120 || $log['diastolic'] >= 80) {
                        $statusStr = 'Waspada';
                        $statusColor = 'rgba(245, 158, 11, 0.1)';
                        $statusText = '#f59e0b';
                    }
                ?>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 1rem 0.5rem;"><?= date('d M Y, H:i', $time) ?></td>
                    <td style="padding: 1rem 0.5rem; font-weight: 600;"><?= htmlspecialchars($log['systolic']) ?> / <?= htmlspecialchars($log['diastolic']) ?></td>
                    <td style="padding: 1rem 0.5rem;"><?= $log['heart_rate'] ? htmlspecialchars($log['heart_rate']) . ' bpm' : '-' ?></td>
                    <td style="padding: 1rem 0.5rem;"><span style="background: <?= $statusColor ?>; color: <?= $statusText ?>; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600;"><?= $statusStr ?></span></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div style="margin-top: 1rem; text-align: right;">
        <a href="<?= base_url('blood-pressure') ?>" style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 0.9rem;">Lihat Semua Data &rarr;</a>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1rem; color: var(--dark);">Grafik Tren Tekanan Darah</h3>
    <?php if (empty($logs)): ?>
        <p style="color: var(--text-light); text-align: center; padding: 2rem;">Belum ada data tensi darah untuk ditampilkan pada grafik.</p>
    <?php else: ?>
        <canvas id="dashboardChart" style="width: 100%; height: 300px; max-height: 400px;"></canvas>
    <?php endif; ?>
</div>

<script>
<?php if (!empty($logs)): ?>
    const rawData = <?= json_encode(array_reverse(array_slice($logs, 0, 15))) ?>; // Ambil 15 data terakhir, balik urutannya agar dari terlama ke terbaru
    
    const labels = rawData.map(item => {
        const d = new Date(item.measured_at);
        return d.getDate() + '/' + (d.getMonth()+1) + ' ' + d.getHours() + ':' + String(d.getMinutes()).padStart(2, '0');
    });
    const systolicData = rawData.map(item => item.systolic);
    const diastolicData = rawData.map(item => item.diastolic);
    const heartRateData = rawData.map(item => item.heart_rate || null);

    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Sistolik (Atas)',
                    data: systolicData,
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Diastolik (Bawah)',
                    data: diastolicData,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Nadi',
                    data: heartRateData,
                    borderColor: 'rgb(245, 158, 11)',
                    borderDash: [5, 5],
                    tension: 0.4,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: false, suggestedMin: 50, suggestedMax: 160 }
            }
        }
    });
<?php endif; ?>
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
