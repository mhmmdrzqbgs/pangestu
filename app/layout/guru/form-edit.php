<?php
include '../../config/session.php';
include '../../config/config-db.php';

// Pastikan parameter lengkap
if (!isset($_GET['id_siswa']) || !isset($_GET['semester']) || !isset($_GET['tahun_ajaran_id'])) {
    die("Parameter tidak lengkap.");
}

$id_siswa = intval($_GET['id_siswa']);
$semester = intval($_GET['semester']);
$tahun_ajaran_id = intval($_GET['tahun_ajaran_id']);

// Ambil data siswa dan nilai berdasarkan parameter
$query = $conn->prepare("SELECT s.id AS siswa_id, s.nama, s.kelas, n.id AS nilai_id, 
    n.b_indonesia, n.b_jawa, n.pjok, n.ipas, 
    n.matematika, n.pai, n.b_inggris, n.pkn, n.seni
    FROM siswa s
    LEFT JOIN nilai n ON s.id = n.siswa_id 
    AND n.semester = ? 
    AND n.tahun_ajaran_id = ?
    WHERE s.id = ?");
$query->bind_param("iii", $semester, $tahun_ajaran_id, $id_siswa);
$query->execute();
$result = $query->get_result();
$siswa = $result->fetch_assoc();
$query->close();

if (!$siswa) {
    die("Data siswa tidak ditemukan.");
}

include '../header.php';
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mx-2 content">
        <!-- Judul Halaman -->
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">
            Edit Nilai: <span class="text-grey-700"><?php echo htmlspecialchars($siswa['nama']); ?></span>
        </h2>

        <!-- Form Edit Nilai -->
        <div class="bg-white p-6 rounded-lg shadow-md w-full">
            <form action="../../process/proses-edit.php" method="POST" class="space-y-6">
                <input type="hidden" name="nilai_id" value="<?php echo $siswa['nilai_id'] ?? ''; ?>">
                <input type="hidden" name="id_siswa" value="<?php echo $id_siswa; ?>">
                <input type="hidden" name="semester" value="<?php echo $semester; ?>">
                <input type="hidden" name="tahun_ajaran_id" value="<?php echo $tahun_ajaran_id; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php
                    $mapel = [
                        'b_indonesia' => 'B. Indonesia', 'b_jawa' => 'B. Jawa', 'pjok' => 'PJOK',
                        'ipas' => 'IPAS', 'matematika' => 'Matematika', 'pai' => 'PAI',
                        'b_inggris' => 'B. Inggris', 'pkn' => 'PKN', 'seni' => 'Seni'
                    ];

                    foreach ($mapel as $key => $label) : ?>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1"><?php echo $label; ?></label>
                            <input type="number" name="<?php echo $key; ?>"
                                   value="<?php echo htmlspecialchars($siswa[$key] ?? 0); ?>"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Simpan Perubahan
                    </button>
                    <a href="data.php?tahun_semester=<?php echo urlencode($tahun_ajaran_id . '_' . $semester); ?>" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

<?php include '../footer.php'; ?>