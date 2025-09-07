<?php
include '../../config/session.php';
include '../header.php';
include '../../config/config-db.php';

// Cek apakah ID catatan tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Catatan tidak ditemukan!");
}

$catatan_id = intval($_GET['id']);

// Ambil data catatan berdasarkan ID
$query = $conn->prepare("SELECT id, siswa_id, catatan FROM catatan_guru WHERE id = ?");
$query->bind_param("i", $catatan_id);
$query->execute();
$result = $query->get_result();
$catatan = $result->fetch_assoc();

if (!$catatan) {
    die("Data catatan tidak ditemukan!");
}

// Proses Update Catatan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siswa_id = $_POST['siswa_id'];
    $catatan_text = $_POST['catatan'];

    $update = $conn->prepare("UPDATE catatan_guru SET siswa_id = ?, catatan = ? WHERE id = ?");
    $update->bind_param("isi", $siswa_id, $catatan_text, $catatan_id);

    if ($update->execute()) {
        echo "<script>alert('Catatan berhasil diperbarui!'); window.location='catatan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui catatan!');</script>";
    }
}
?>

<body class="bg-gray-200 pt-20">
    <div class="lg:ml-64 lg:pl-2 lg:flex lg:flex-col lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center md:text-center">Edit Catatan</h2>

        <div class="bg-white rounded-lg p-6 shadow-md w-full md:w-3/4 mx-auto">
            <form method="POST" action="" class="space-y-6">
                <!-- Pilih Siswa -->
                <div>
                    <label for="siswa" class="block text-gray-700 font-medium mb-2">Pilih Siswa:</label>
                    <select name="siswa_id" id="siswa" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 bg-gray-100">
                        <?php
                        $id_guru = $_SESSION['id_user'];
                        $querySiswa = $conn->prepare("SELECT id, nama FROM siswa WHERE kelas = (SELECT class FROM user WHERE id_user = ?)");
                        $querySiswa->bind_param("i", $id_guru);
                        $querySiswa->execute();
                        $resultSiswa = $querySiswa->get_result();
                        while ($row = $resultSiswa->fetch_assoc()) {
                            $selected = ($row['id'] == $catatan['siswa_id']) ? 'selected' : '';
                            echo "<option value='" . $row['id'] . "' $selected>" . $row['nama'] . "</option>";
                        }
                        $querySiswa->close();
                        ?>
                    </select>
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-gray-700 font-medium mb-2">Catatan:</label>
                    <textarea name="catatan" id="catatan" rows="5" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 bg-gray-100 resize-none"><?= htmlspecialchars($catatan['catatan']); ?></textarea>
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="flex flex-col md:flex-row gap-4 justify-end">
                    <a href="catatan.php" class="bg-gray-400 text-white py-3 px-6 rounded-lg hover:bg-gray-500 transition duration-200 w-full md:w-auto text-center">
                        Batal
                    </a>
                    <button type="submit" class="bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition duration-200 w-full md:w-auto">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

<?php include '../footer.php'; ?>
