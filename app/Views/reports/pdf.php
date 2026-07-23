<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tensi Darah</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #0076b6; font-size: 20px; }
        p.subtitle { text-align: center; margin-bottom: 30px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        th { background-color: #f8fafc; color: #475569; }
        .danger { color: #ef4444; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Laporan Pencatatan Tensi Darah</h1>
    <p class="subtitle">KathaHealthy Smart Monitor<br>Periode: <?= htmlspecialchars($start_date) ?> s/d <?= htmlspecialchars($end_date) ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu Pengukuran</th>
                <th>Nama Pasien</th>
                <th>Tensi (SYS/DIA)</th>
                <th>Nadi (bpm)</th>
                <th>SpO2 (%)</th>
                <th>Keterangan Tambahan</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($logs)): ?>
                <tr><td colspan="7" style="text-align:center;">Tidak ada data pada periode ini.</td></tr>
            <?php else: ?>
                <?php $i = 1; foreach($logs as $log): 
                    $isHigh = ($log['systolic'] >= 140 || $log['diastolic'] >= 90);
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= date('d M Y, H:i', strtotime($log['measured_at'])) ?></td>
                    <td><?= htmlspecialchars($log['patient_name'] ?? 'Anonim') ?></td>
                    <td class="<?= $isHigh ? 'danger' : '' ?>"><?= htmlspecialchars($log['systolic']) ?> / <?= htmlspecialchars($log['diastolic']) ?></td>
                    <td><?= htmlspecialchars($log['heart_rate'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($log['oxygen_saturation'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($log['notes'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
