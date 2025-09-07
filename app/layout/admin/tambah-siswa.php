<?php
include '../../config/session.php';
include '../../config/config-db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kelas = intval($_POST['kelas']);

    $query = $conn->prepare("INSERT INTO siswa (nama, jenis_kelamin, kelas) VALUES (?, ?, ?)");
    $query->bind_param("ssi", $nama, $jenis_kelamin, $kelas);

    if ($query->execute()) {
        header("Location: manage-siswa.php?kelas=$kelas");
        exit();
    } else {
        echo "Gagal menambahkan siswa.";
    }
}

include '../header-admin.php'
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Tambah Siswa</h2>

        <div class="bg-white rounded-lg p-6 shadow-md">
            <form method="POST" action="" class="space-y-4">
                <!-- Input -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nama</label>
                    <input type="text" name="nama" required
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Kelas</label>
                    <select name="kelas" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <?php for ($i = 1; $i <= 6; $i++) : ?>
                            <option value="<?php echo $i; ?>">Kelas <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Aksi -->
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <a href="manage-siswa.php" class="bg-gray-500 text-white px-4 py-2 rounded text-center w-full md:w-1/3">Kembali</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-1/3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>

<?php include '../footer-admin.php'; ?>