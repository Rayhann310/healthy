<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/sidebar.php'; ?>
<?php require_once APP_PATH . '/Views/layouts/navbar.php'; ?>

<div class="flex-between" style="margin-bottom: 1.5rem;">
    <div class="page-title" style="margin-bottom: 0;">Data Tensi Darah</div>
    <button class="btn btn-primary" onclick="document.getElementById('bpModal').classList.add('active')">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Catat Tensi Baru
    </button>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <h3 style="margin-bottom: 1rem; color: var(--dark);">Grafik Tren Tensi Darah Keseluruhan</h3>
    <?php if (empty($logs)): ?>
        <p style="color: var(--text-light); text-align: center; padding: 2rem;">Belum ada data tercatat.</p>
    <?php else: ?>
        <canvas id="bpChart" style="width: 100%; height: 300px; max-height: 350px;"></canvas>
    <?php endif; ?>
</div>

<div class="card table-responsive">
    <table style="width: 100%; border-collapse: collapse; text-align: left;" id="bpTable">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color); color: var(--text-gray);">
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Tanggal & Waktu</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Pasien</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">SYS / DIA</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Nadi</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">SpO2 (%)</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Status</th>
                <th style="padding: 1rem 0.5rem; white-space: nowrap;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logs)): ?>
                <tr id="empty-row"><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">Belum ada data tercatat.</td></tr>
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
                    <td style="padding: 1rem 0.5rem; font-weight: 600; color: var(--primary);"><?= htmlspecialchars($log['patient_name'] ?? 'Tidak Diketahui') ?></td>
                    <td style="padding: 1rem 0.5rem; font-weight: 600;"><?= htmlspecialchars($log['systolic']) ?> / <?= htmlspecialchars($log['diastolic']) ?></td>
                    <td style="padding: 1rem 0.5rem;"><?= $log['heart_rate'] ? htmlspecialchars($log['heart_rate']) . ' bpm' : '-' ?></td>
                    <td style="padding: 1rem 0.5rem;"><?= $log['oxygen_saturation'] ? htmlspecialchars($log['oxygen_saturation']) . '%' : '-' ?></td>
                    <td style="padding: 1rem 0.5rem;"><span style="background: <?= $statusColor ?>; color: <?= $statusText ?>; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600;"><?= $statusStr ?></span></td>
                    <td style="padding: 1rem 0.5rem; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($log['notes'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Pencatatan Tensi -->
<div class="modal-overlay" id="bpModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Catat Tensi Baru</h2>
            <button class="modal-close" onclick="document.getElementById('bpModal').classList.remove('active')">&times;</button>
        </div>
        <form id="bpForm">
            <div class="form-group">
                <label class="form-label">Pilih Pasien</label>
                <select name="patient_id" class="form-control" required>
                    <option value="">-- Pilih Pasien --</option>
                    <?php foreach($patients as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['contact'] ?? '-') ?>)</option>
                    <?php endforeach; ?>
                </select>
                <?php if(empty($patients)): ?>
                    <small style="color: var(--danger);">Belum ada data pasien. <a href="<?= base_url('patients') ?>">Tambahkan Pasien</a> terlebih dahulu.</small>
                <?php endif; ?>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Tanggal Pengukuran</label>
                    <input type="date" name="measured_date" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Jam Pengukuran</label>
                    <input type="time" name="measured_time" class="form-control" required value="<?= date('H:i') ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Tensi Sistolik (Atas)</label>
                    <input type="number" name="systolic" class="form-control" required placeholder="Contoh: 120">
                </div>
                <div class="form-group">
                    <label class="form-label">Tensi Diastolik (Bawah)</label>
                    <input type="number" name="diastolic" class="form-control" required placeholder="Contoh: 80">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Nadi / Detak Jantung</label>
                    <input type="number" name="heart_rate" class="form-control" placeholder="Contoh: 75">
                </div>
                <div class="form-group">
                    <label class="form-label">Saturasi Oksigen (SpO2 %)</label>
                    <input type="number" name="oxygen_saturation" class="form-control" placeholder="Contoh: 98">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan Tambahan - Opsional</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Merasa pusing, habis lari..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;" id="btnSubmit">Simpan Catatan</button>
        </form>
    </div>
</div>

<script>
<?php if (!empty($logs)): ?>
    const rawData = <?= json_encode(array_reverse(array_slice($logs, 0, 15))) ?>;
    
    const labels = rawData.map(item => {
        const d = new Date(item.measured_at);
        return d.getDate() + '/' + (d.getMonth()+1) + ' ' + d.getHours() + ':' + String(d.getMinutes()).padStart(2, '0');
    });
    
    let bpChart = new Chart(document.getElementById('bpChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Sistolik',
                    data: rawData.map(i => i.systolic),
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Diastolik',
                    data: rawData.map(i => i.diastolic),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: false } }
        }
    });
<?php endif; ?>

document.getElementById('bpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmit');
    const form = this;
    
    btn.innerHTML = 'Menyimpan...';
    btn.disabled = true;

    const formData = new FormData(form);
    
    fetch('<?= base_url("bp/store") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Tutup modal
            document.getElementById('bpModal').classList.remove('active');
            form.reset();
            
            // Perbarui tabel
            let statusStr = 'Normal';
            let statusColor = 'rgba(140, 198, 63, 0.1)';
            let statusText = 'var(--secondary)';
            
            if (data.data.systolic >= 140 || data.data.diastolic >= 90) {
                statusStr = 'Tinggi';
                statusColor = 'rgba(239, 68, 68, 0.1)';
                statusText = '#ef4444';
            } else if (data.data.systolic >= 120 || data.data.diastolic >= 80) {
                statusStr = 'Waspada';
                statusColor = 'rgba(245, 158, 11, 0.1)';
                statusText = '#f59e0b';
            }
            
            const newRow = `
                <tr style="border-bottom: 1px solid var(--border-color); animation: fadeIn 0.5s;">
                    <td style="padding: 1rem 0.5rem;">${data.data.formatted_date}</td>
                    <td style="padding: 1rem 0.5rem; font-weight: 600; color: var(--primary);">${data.data.patient_name ? data.data.patient_name : 'Tidak Diketahui'}</td>
                    <td style="padding: 1rem 0.5rem; font-weight: 600;">${data.data.systolic} / ${data.data.diastolic}</td>
                    <td style="padding: 1rem 0.5rem;">${data.data.heart_rate ? data.data.heart_rate + ' bpm' : '-'}</td>
                    <td style="padding: 1rem 0.5rem;">${data.data.oxygen_saturation ? data.data.oxygen_saturation + '%' : '-'}</td>
                    <td style="padding: 1rem 0.5rem;"><span style="background: ${statusColor}; color: ${statusText}; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600;">${statusStr}</span></td>
                    <td style="padding: 1rem 0.5rem; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${data.data.notes ? data.data.notes : '-'}</td>
                </tr>
            `;
            
            const tbody = document.querySelector('#bpTable tbody');
            const emptyRow = document.getElementById('empty-row');
            if(emptyRow) emptyRow.remove();
            
            tbody.insertAdjacentHTML('afterbegin', newRow);
            
            // Perbarui Chart.js secara Real-time
            if (typeof bpChart !== 'undefined') {
                const dateObj = new Date(data.data.measured_at);
                const newLabel = dateObj.getDate() + '/' + (dateObj.getMonth()+1) + ' ' + dateObj.getHours() + ':' + String(dateObj.getMinutes()).padStart(2, '0');
                
                // Tambahkan data ke awal array grafik (krn urutannya dari kiri ke kanan)
                bpChart.data.labels.push(newLabel);
                bpChart.data.datasets[0].data.push(data.data.systolic);
                bpChart.data.datasets[1].data.push(data.data.diastolic);
                
                // Jika data sudah lebih dari 15, buang yang paling lama (index 0)
                if (bpChart.data.labels.length > 15) {
                    bpChart.data.labels.shift();
                    bpChart.data.datasets[0].data.shift();
                    bpChart.data.datasets[1].data.shift();
                }
                bpChart.update();
            }
            
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan koneksi.');
        console.error(error);
    })
    .finally(() => {
        btn.innerHTML = 'Simpan Catatan';
        btn.disabled = false;
    });
});
</script>

<style>
@keyframes fadeIn {
    from { background: rgba(0, 118, 182, 0.1); opacity: 0; }
    to { background: transparent; opacity: 1; }
}
</style>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
