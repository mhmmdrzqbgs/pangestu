<?php
include '../../config/session.php';
include '../../config/config-db.php';

$id = intval($_GET['id']);
$query = $conn->prepare("SELECT * FROM siswa WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$siswa = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kelas = intval($_POST['kelas']);

    $updateQuery = $conn->prepare("UPDATE siswa SET nama = ?, jenis_kelamin = ?, kelas = ? WHERE id = ?");
    $updateQuery->bind_param("ssii", $nama, $jenis_kelamin, $kelas, $id);

    if ($updateQuery->execute()) {
        header("Location: manage-siswa.php?kelas=$kelas");
        exit();
    } else {
        echo "Gagal mengupdate data.";
    }
}

include '../header-admin.php';
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Edit Siswa</h2>

        <div class="bg-white rounded-lg p-6 shadow-md">
            <form method="POST" action="">
                <!-- Input Nama -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold">Nama Siswa</label>
                    <input type="text" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Input Jenis Kelamin -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="L" <?php echo ($siswa['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?php echo ($siswa['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <!-- Input Kelas -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold">Kelas</label>
                    <select name="kelas" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <?php for ($i = 1; $i <= 6; $i++) : ?>
                            <option value="<?php echo $i; ?>" <?php echo ($siswa['kelas'] == $i) ? 'selected' : ''; ?>>Kelas <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <a href="manage-siswa.php" class="bg-gray-500 text-white px-4 py-2 rounded text-center w-full md:w-auto">Kembali</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-auto">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>

<?php include '../footer-admin.php'; ?>