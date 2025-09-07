<?php
include '../../config/session.php';
include '../../config/config-db.php';
include '../header.php';

$guru_id = $_SESSION['id_user'];

// Ambil daftar siswa yang diajar oleh guru ini
$querySiswa = $conn->prepare("
    SELECT s.id, s.nama 
    FROM siswa s 
    JOIN user u ON s.kelas = u.class
    WHERE u.id_user = ?
");
$querySiswa->bind_param("i", $guru_id);
$querySiswa->execute();
$resultSiswa = $querySiswa->get_result();
$siswa_list = $resultSiswa->fetch_all(MYSQLI_ASSOC);
$querySiswa->close();

// Inisialisasi variabel untuk tampilan awal
$siswa_id = isset($_POST['siswa_id']) ? intval($_POST['siswa_id']) : 0;
$mapel = isset($_POST['mapel']) ? $_POST['mapel'] : 'all';
?>
<body class="bg-gray-200 pt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-[75%] lg:mr-2 mx-auto mt-2 mb-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Statistik Nilai Siswa</h2>

        <!-- Form Pilihan -->
        <form method="POST" action="" class="bg-white p-6 rounded-lg shadow-md mx-auto w-full">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pilih Siswa -->
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Pilih Siswa:</label>
                    <select name="siswa_id" class="w-full p-3 border rounded-md bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <?php foreach ($siswa_list as $siswa): ?>
                            <option value="<?= $siswa['id']; ?>" <?= $siswa_id == $siswa['id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($siswa['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Pilih Mata Pelajaran -->
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Pilih Mata Pelajaran:</label>
                    <select name="mapel" class="w-full p-3 border rounded-md bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option value="all" <?= $mapel == 'all' ? 'selected' : ''; ?>>Semua Mapel</option>
                        <option value="b_indonesia" <?= $mapel == 'b_indonesia' ? 'selected' : ''; ?>>Bahasa Indonesia</option>
                        <option value="b_jawa" <?= $mapel == 'b_jawa' ? 'selected' : ''; ?>>Bahasa Jawa</option>
                        <option value="pjok" <?= $mapel == 'pjok' ? 'selected' : ''; ?>>PJOK</option>
                        <option value="ipas" <?= $mapel == 'ipas' ? 'selected' : ''; ?>>IPAS</option>
                        <option value="matematika" <?= $mapel == 'matematika' ? 'selected' : ''; ?>>Matematika</option>
                        <option value="pai" <?= $mapel == 'pai' ? 'selected' : ''; ?>>PAI</option>
                        <option value="b_inggris" <?= $mapel == 'b_inggris' ? 'selected' : ''; ?>>Bahasa Inggris</option>
                        <option value="pkn" <?= $mapel == 'pkn' ? 'selected' : ''; ?>>PKN</option>
                        <option value="seni" <?= $mapel == 'seni' ? 'selected' : ''; ?>>Seni</option>
                    </select>
                </div>

                <!-- Tombol Tampilkan -->
                <div class="col-span-1 md:col-span-2 flex justify-center">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-200">
                        Tampilkan
                    </button>
                </div>
            </div>
        </form>

        <!-- Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6 mx-auto w-full">
            <canvas id="chartPerkembangan"></canvas>
        </div>

        <!-- Load Statistik jika ada pilihan -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $siswa_id > 0) {
            include '../../process/get-data/get-statistik.php';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @media (max-width: 768px) {
            .content {
                padding: 1rem;
            }
        }
    </style>
</body>

<?php include '../footer.php'; ?>
