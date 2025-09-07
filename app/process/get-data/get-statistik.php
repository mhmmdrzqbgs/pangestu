<?php
include '../../config/config-db.php';

$siswa_id = isset($_POST['siswa_id']) ? intval($_POST['siswa_id']) : 0;
$mapel = isset($_POST['mapel']) ? $_POST['mapel'] : 'all';

$labels = [];
$data_nilai = [];
$no_data = false; // Flag jika data tidak tersedia

if ($siswa_id > 0) {
    if ($mapel == 'all') {
        $query = $conn->prepare("SELECT tahun_ajaran.tahun, tahun_ajaran.semester, 
                (COALESCE(b_indonesia,0) + COALESCE(b_jawa,0) + COALESCE(pjok,0) + 
                 COALESCE(ipas,0) + COALESCE(matematika,0) + COALESCE(pai,0) + 
                 COALESCE(b_inggris,0) + COALESCE(pkn,0) + COALESCE(seni,0)) / 9 AS rata_rata
            FROM nilai
            JOIN tahun_ajaran ON nilai.tahun_ajaran_id = tahun_ajaran.id
            WHERE siswa_id = ?
            ORDER BY tahun_ajaran.tahun ASC, tahun_ajaran.semester ASC");
        $query->bind_param("i", $siswa_id);
    } else {
        $query = $conn->prepare("SELECT tahun_ajaran.tahun, tahun_ajaran.semester, COALESCE($mapel, 0) AS nilai
            FROM nilai
            JOIN tahun_ajaran ON nilai.tahun_ajaran_id = tahun_ajaran.id
            WHERE siswa_id = ?
            ORDER BY tahun_ajaran.tahun ASC, tahun_ajaran.semester ASC");
        $query->bind_param("i", $siswa_id);
    }

    $query->execute();
    $result = $query->get_result();

    while ($row = $result->fetch_assoc()) {
        $tahun1 = intval($row['tahun']);
        $tahun2 = $tahun1 + 1;
        $semester = intval($row['semester']);
    
        // Ambil dua digit terakhir tahun pertama dan dua digit terakhir tahun kedua
        $tahun1_short = substr($tahun1, -2);
        $tahun2_short = substr($tahun2, -2);
    
        $labels[] = "smt $semester ($tahun1_short/$tahun2_short)";
    
        // Pastikan nilai adalah angka, jika tidak, gunakan 0
        $nilai = $mapel == 'all' ? $row['rata_rata'] : $row['nilai'];
        $data_nilai[] = is_numeric($nilai) ? round($nilai, 2) : 0;
    }
    

    $query->close();
}

// Jika tidak ada data, tampilkan pesan "Statistik belum tersedia"
if (empty($labels)) {
    $labels = ["Statistik belum tersedia"];
    $data_nilai = [null]; // Gunakan null agar tidak tampil dalam chart
    $no_data = true;
}
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let ctx = document.getElementById('chartPerkembangan').getContext('2d');
    const labels = <?= json_encode($labels); ?>;
    const dataNilai = <?= json_encode($data_nilai); ?>;
    
    console.log("Labels:", labels);
    console.log("Data Nilai:", dataNilai); // Debugging untuk melihat nilai yang dikirim

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "<?= $mapel == 'all' ? 'Semua Mapel' : strtoupper(str_replace('_', ' ', $mapel)); ?>",
                data: dataNilai,
                borderColor: <?= $no_data ? "'gray'" : "'blue'" ?>,
                backgroundColor: <?= $no_data ? "'rgba(128, 128, 128, 0.2)'" : "'rgba(0, 0, 255, 0.2)'" ?>,
                borderWidth: 2,
                pointRadius: <?= $no_data ? "0" : "4" ?>
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    enabled: <?= $no_data ? "false" : "true" ?>
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value !== null ? value : '-';
                        }
                    }
                }
            }
        }
    });
});
</script>
