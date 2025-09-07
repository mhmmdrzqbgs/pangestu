<?php
include '../../config/session.php';

include '../header.php';
include '../../config/config-db.php';
?>

<body class="bg-gray-200 pt-20">
    <div class="lg:ml-64 lg:pl-2 lg:flex lg:flex-col lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center md:text-center">Tambah Catatan</h2>

        <!-- Form Tambah Catatan -->
        <div class="bg-white rounded-lg p-6 shadow-md w-full md:w-3/4 mx-auto">
            <form action="../../process/proses-catat.php" method="POST" class="space-y-6">
                <!-- Pilih Siswa -->
                <div>
                    <label for="siswa" class="block text-gray-700 font-medium mb-2">Pilih Siswa:</label>
                    <select name="siswa_id" id="siswa" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 bg-gray-100">
                        <?php
                        $id_guru = $_SESSION['id_user'];
                        $query = $conn->prepare("SELECT id, nama FROM siswa WHERE kelas = (SELECT class FROM user WHERE id_user = ?)");
                        $query->bind_param("i", $id_guru);
                        $query->execute();
                        $result = $query->get_result();
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
                        }
                        $query->close();
                        ?>
                    </select>
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-gray-700 font-medium mb-2">Catatan:</label>
                    <textarea name="catatan" id="catatan" required rows="5"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 bg-gray-100 resize-none"></textarea>
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="flex flex-col md:flex-row gap-4 justify-end">
                    <a href="catatan.php"
                        class="bg-gray-400 text-white py-3 px-6 rounded-lg hover:bg-gray-500 transition duration-200 w-full md:w-auto text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition duration-200 w-full md:w-auto">
                        Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

<?php
include '../footer.php';
?>
