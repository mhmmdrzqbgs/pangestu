<?php
include '../../config/session.php';
include '../../config/config-db.php';

$guru_id = $_SESSION['id_user'];

$queryKelas = $conn->prepare("SELECT class FROM user WHERE id_user = ?");
$queryKelas->bind_param("i", $guru_id);
$queryKelas->execute();
$queryKelas->bind_result($class);
$queryKelas->fetch();
$queryKelas->close();

if (!$class) {
    die("Guru tidak memiliki kelas.");
}

$queryTahunAktif = $conn->query("SELECT id AS tahun_id, tahun, semester 
                                FROM tahun_ajaran 
                                WHERE status = 'aktif'
                                ORDER BY id DESC 
                                LIMIT 1");

$tahunAktif = $queryTahunAktif->fetch_assoc();
$tahun_ajaran_id = $tahunAktif['tahun_id'] ?? null;
$semester = $tahunAktif['semester'] ?? null;

if (!$tahun_ajaran_id || !$semester) {
    die("Tidak ada semester aktif yang ditemukan.");
}

$query = $conn->prepare("SELECT s.id AS siswa_id, s.nama, s.jenis_kelamin, 
           n.b_indonesia, n.b_jawa, n.pjok, n.ipas, n.matematika, 
           n.pai, n.b_inggris, n.pkn, n.seni
    FROM siswa s
    LEFT JOIN nilai n ON s.id = n.siswa_id 
        AND n.semester = ? 
        AND n.tahun_ajaran_id = ?
    WHERE s.kelas = ?");
$query->bind_param("iii", $semester, $tahun_ajaran_id, $class);
$query->execute();
$result = $query->get_result();

$siswaData = [];
while ($row = $result->fetch_assoc()) {
    $siswaData[] = $row;
}

$folderPath = 'json_rekomendasi/';
if (!file_exists($folderPath)) {
    mkdir($folderPath, 0777, true);
}

$file = $folderPath . "rekomendasi_kelas_{$class}.json";

if (file_exists($file)) {
    $rekomendasiSiswa = json_decode(file_get_contents($file), true);
} else {
    $rekomendasiSiswa = [];
}

// Proses Generate
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($siswaData as $siswa) {
        $prompt = "Berikan rekomendasi metode pembelajaran bagi guru untuk meningkatkan performa dengan penjelasan rekomendasi yang sangat singkat dan jelas dalam maksimal 2 kalimat berdasarkan nilai siswanya berikut:
        Bahasa Indonesia: {$siswa['b_indonesia']}
        Bahasa Jawa: {$siswa['b_jawa']}
        PJOK: {$siswa['pjok']}
        IPAS: {$siswa['ipas']}
        Matematika: {$siswa['matematika']}
        PAI: {$siswa['pai']}
        Bahasa Inggris: {$siswa['b_inggris']}
        PKN: {$siswa['pkn']}
        Seni: {$siswa['seni']}.
        Jawaban harus langsung rekomendasi belajar tanpa simbol apapun.";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyCwnn_TBm3JmtWydjz0_3UxWMkJY6MrwQQ");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["contents" => [["parts" => [["text" => $prompt]]]]]));

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        $rekomendasiSiswa[$siswa['siswa_id']] = $responseData["candidates"][0]["content"]["parts"][0]["text"] ?? "Rekomendasi tidak tersedia.";
    }

    file_put_contents($file, json_encode($rekomendasiSiswa));
}

include '../header.php';
?>

<body class="bg-gray-200 pt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">
            Rekomendasi Belajar Siswa Kelas <?php echo htmlspecialchars($class); ?>
            (Semester <?php echo $semester; ?> - Tahun Ajaran <?php echo $tahunAktif['tahun']; ?>)
        </h2>

        <!-- Form untuk Generate -->
        <form method="POST" id="generateForm" class="flex flex-col md:flex-row items-center gap-4 mb-6">
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg">Generate</button>
            <div id="loading" class="hidden flex items-center gap-2">
                <div class="animate-spin rounded-full h-6 w-6 border-t-4 border-blue-500 border-solid"></div>
                <p class="text-black font-semibold">Sedang Memproses Rekomendasi...</p>
            </div>
        </form>

        <!-- Tabel -->
        <div class="bg-white rounded-lg p-6 shadow-md overflow-x-auto">
            <table class="table-auto w-full border border-gray-300 text-sm md:text-base">
                <thead class="bg-gray-100">
                    <tr class="text-gray-700 text-xs md:text-sm uppercase">
                        <th class="px-4 py-3 border">No</th>
                        <th class="px-4 py-3 border">Nama</th>
                        <th class="px-4 py-3 border">Jenis Kelamin</th>
                        <th class="px-4 py-3 border">Rekomendasi Belajar</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    <?php if (!empty($siswaData)): ?>
                        <?php
                        $no = 1;
                        foreach ($siswaData as $siswa) {
                            $rekomendasi = $rekomendasiSiswa[$siswa['siswa_id']] ?? "Rekomendasi tidak tersedia.";
                            echo "<tr>
                                    <td class='border px-4 py-2 text-center'>{$no}</td>
                                    <td class='border px-4 py-2'>" . htmlspecialchars($siswa['nama']) . "</td>
                                    <td class='border px-4 py-2 text-center'>" . htmlspecialchars($siswa['jenis_kelamin']) . "</td>
                                    <td class='border px-4 py-2'>" . nl2br(htmlspecialchars($rekomendasi)) . "</td>
                                </tr>";
                            $no++;
                        }
                        ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-red-500 font-bold py-4">
                                Data nilai tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const form = document.getElementById('generateForm');
        const loadingDiv = document.getElementById('loading');

        form.addEventListener('submit', function() {
            loadingDiv.classList.remove('hidden');
        });
    </script>
</body>

<?php include '../footer.php'; ?>
