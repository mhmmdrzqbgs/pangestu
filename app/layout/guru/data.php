<?php
include '../../config/session.php';
include '../../config/config-db.php';

// Ambil kelas guru
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

// Ambil Tahun Ajaran Aktif
$queryTahunAktif = $conn->query("
    SELECT id AS tahun_id, tahun, semester 
    FROM tahun_ajaran 
    WHERE status = 'aktif'
    LIMIT 1
");
$tahunAktif = $queryTahunAktif->fetch_assoc();
$tahun_ajaran_id_default = $tahunAktif['tahun_id'] ?? null;
$semester_default = $tahunAktif['semester'] ?? null;

// Pilihan Tahun Ajaran & Semester
$selected = isset($_GET['tahun_semester']) ? explode('_', $_GET['tahun_semester']) : [$tahun_ajaran_id_default, $semester_default];
$tahun_ajaran_id = intval($selected[0]);
$semester = intval($selected[1]);

// Ambil daftar siswa di kelas ini
$querySiswa = $conn->prepare("SELECT id FROM siswa WHERE kelas = ?");
$querySiswa->bind_param("i", $class);
$querySiswa->execute();
$resultSiswa = $querySiswa->get_result();
$siswaList = $resultSiswa->fetch_all(MYSQLI_ASSOC);
$querySiswa->close();

// Cek dan tambahkan nilai default 0 jika belum ada
foreach ($siswaList as $siswa) {
    $siswa_id = $siswa['id'];

    $queryCek = $conn->prepare("
        SELECT COUNT(*) FROM nilai 
        WHERE siswa_id = ? AND semester = ? AND tahun_ajaran_id = ?
    ");
    $queryCek->bind_param("iii", $siswa_id, $semester, $tahun_ajaran_id);
    $queryCek->execute();
    $queryCek->bind_result($jumlah);
    $queryCek->fetch();
    $queryCek->close();

    if ($jumlah == 0) {
        $queryInsert = $conn->prepare("
            INSERT INTO nilai (siswa_id, semester, tahun_ajaran_id, 
                               b_indonesia, b_jawa, pjok, ipas, matematika, 
                               pai, b_inggris, pkn, seni) 
            VALUES (?, ?, ?, 0, 0, 0, 0, 0, 0, 0, 0, 0)
        ");
        $queryInsert->bind_param("iii", $siswa_id, $semester, $tahun_ajaran_id);
        $queryInsert->execute();
        $queryInsert->close();
    }
}

include '../header.php';
?>

<body class="bg-gray-200 pt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">
            Nilai Siswa Kelas <?php echo htmlspecialchars($class); ?>
        </h2>

        <form method="GET" class="mb-4 flex flex-col lg:flex-row items-center justify-center gap-4 w-full">
            <label for="tahun_semester" class="text-gray-700 font-semibold">Tahun Ajaran & Semester:</label>
            <select name="tahun_semester" id="tahun_semester" class="border p-2 rounded w-full lg:w-auto">
                <?php
                $queryTahunSemester = $conn->query("SELECT id, tahun, semester, status FROM tahun_ajaran ORDER BY id DESC");
                while ($ts = $queryTahunSemester->fetch_assoc()) :
                ?>
                    <option value="<?= $ts['id'] . '_' . $ts['semester'] ?>" <?= ($ts['id'] == $tahun_ajaran_id && $ts['semester'] == $semester) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($ts['tahun']) ?> - Semester <?= $ts['semester'] ?> <?= $ts['status'] == 'aktif' ? '(Aktif)' : '' ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full lg:w-auto">Tampilkan</button>
        </form>

        <!-- Tabel Nilai Siswa -->
        <div class="bg-white rounded-lg p-6 shadow-md overflow-x-auto">
            <table class="table-auto w-full border border-gray-300 text-sm md:text-base">
                <thead class="bg-gray-100">
                    <tr class="text-gray-700 uppercase text-xs md:text-sm">
                        <th class="px-4 py-3 border">No</th>
                        <th class="px-4 py-3 border">Nama</th>
                        <th class="px-4 py-3 border">Jenis Kelamin</th>
                        <th class="px-4 py-3 border">B. Indonesia</th>
                        <th class="px-4 py-3 border">B. Jawa</th>
                        <th class="px-4 py-3 border">PJOK</th>
                        <th class="px-4 py-3 border">IPAS</th>
                        <th class="px-4 py-3 border">Matematika</th>
                        <th class="px-4 py-3 border">PAI</th>
                        <th class="px-4 py-3 border">B. Inggris</th>
                        <th class="px-4 py-3 border">PKN</th>
                        <th class="px-4 py-3 border">Seni</th>
                        <th class="px-4 py-3 border">Rata-rata</th>
                        <th class="px-4 py-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    <?php
                    $query = $conn->prepare("
                        SELECT s.id AS siswa_id, s.nama, s.jenis_kelamin, n.id AS nilai_id, 
                               n.b_indonesia, n.b_jawa, n.pjok, n.ipas, n.matematika, 
                               n.pai, n.b_inggris, n.pkn, n.seni,
                               (COALESCE(n.b_indonesia, 0) + COALESCE(n.b_jawa, 0) + COALESCE(n.pjok, 0) + 
                                COALESCE(n.ipas, 0) + COALESCE(n.matematika, 0) + COALESCE(n.pai, 0) + 
                                COALESCE(n.b_inggris, 0) + COALESCE(n.pkn, 0) + COALESCE(n.seni, 0)) / 9 AS rata_rata
                        FROM siswa s
                        LEFT JOIN nilai n ON s.id = n.siswa_id 
                            AND n.semester = ? 
                            AND n.tahun_ajaran_id = ?
                        WHERE s.kelas = ?
                    ");
                    $query->bind_param("iii", $semester, $tahun_ajaran_id, $class);
                    $query->execute();
                    $result = $query->get_result();

                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border px-4 py-2 text-center'>{$no}</td>";
                            echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['nama']) . "</td>";
                            echo "<td class='border px-4 py-2 text-center'>" . htmlspecialchars($row['jenis_kelamin']) . "</td>";
                            foreach (["b_indonesia", "b_jawa", "pjok", "ipas", "matematika", "pai", "b_inggris", "pkn", "seni"] as $mapel) {
                                echo "<td class='border px-4 py-2 text-center'>" . htmlspecialchars($row[$mapel] ?? '-') . "</td>";
                            }
                            echo "<td class='border px-4 py-2 text-center font-bold'>" . number_format($row['rata_rata'], 2) . "</td>";
                            echo "<td class='border px-4 py-2 text-center'>
                                <a href='form-edit.php?id_siswa=" . $row['siswa_id'] . "&semester=" . $semester . "&tahun_ajaran_id=" . $tahun_ajaran_id . "' 
                                   class='bg-yellow-500 text-white px-2 py-1 rounded'>Edit</a>
                            </td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='14' class='text-center text-red-500 font-bold py-4'>Data nilai tidak ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<?php include '../footer.php'; ?>
