<?php
include '../../config/session.php';
include '../header-admin.php';

$kelas = isset($_GET['kelas']) ? intval($_GET['kelas']) : 1;
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Manajemen Siswa</h2>

        <!-- Form Pilihan Kelas -->
        <form method="GET" class="mb-4 flex justify-center items-center gap-4">
            <label for="kelas" class="font-bold text-gray-700">Pilih Kelas:</label>
            <select name="kelas" id="kelas" class="border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none" onchange="this.form.submit()">
                <?php for ($i = 1; $i <= 6; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i == $kelas) ? 'selected' : ''; ?>>
                        Kelas <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </form>

        <!-- Tambah Siswa -->
        <div class="flex justify-end mb-4">
            <a href="tambah-siswa.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Siswa</a>
        </div>

        <!-- Data Siswa -->
        <div class="bg-white rounded-lg p-6 shadow-md overflow-x-auto">
            <?php include '../../process/get-data/get-siswa.php'; ?>
        </div>
    </div>
</body>

<?php include '../footer-admin.php'; ?>