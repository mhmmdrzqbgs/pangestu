<?php
include '../../process/get-data/get-catatan.php';
include '../header.php';
?>

<body class="bg-gray-200 pt-20">
    <div class="lg:ml-64 lg:pl-2 lg:flex lg:flex-col lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Catatan Guru</h2>

        <!-- Tabel Catatan -->
        <div class="bg-white rounded-lg p-6 shadow-md overflow-x-auto">
            <?php if (!empty($siswa_data)) : ?>
                <table class="hidden md:table table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-sm text-gray-700">
                            <th class="px-4 py-2 text-left border-b-2">No</th>
                            <th class="px-4 py-2 text-left border-b-2">Nama Siswa</th>
                            <th class="px-4 py-2 text-left border-b-2">Catatan</th>
                            <th class="px-4 py-2 text-left border-b-2">Tanggal</th>
                            <th class="px-4 py-2 text-left border-b-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($siswa_data as $siswa) {
                            echo "<tr class='border-b text-gray-600'>";
                            echo "<td class='px-4 py-2'>{$no}</td>";
                            echo "<td class='px-4 py-2'>{$siswa['nama']}</td>";
                            echo "<td class='px-4 py-2'>" . (!empty($siswa['catatan']) ? $siswa['catatan'] : '<span class="text-gray-500 italic">Belum ada catatan</span>') . "</td>";
                            echo "<td class='px-4 py-2'>" . ($siswa['tanggal'] ?? '-') . "</td>";
                            echo "<td class='px-4 py-2'>";
                            if (!empty($siswa['catatan'])) {
                                echo "<div class='flex gap-2'>
                                        <a href='edit-catatan.php?id={$siswa['catatan_id']}' class='bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600'>Edit</a>
                                        <a href='../../process/hapus-catatan.php?id={$siswa['catatan_id']}' class='bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600' onclick='return confirm(\"Yakin ingin menghapus catatan ini?\")'>Hapus</a>
                                      </div>";
                            }
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p class="text-center text-red-500 font-bold">Tidak ada data catatan guru.</p>
            <?php endif; ?>

            <!-- Tampilan Mobile sebagai Card -->
            <div class="md:hidden">
                <?php
                if (!empty($siswa_data)) {
                    $no = 1;
                    foreach ($siswa_data as $siswa) {
                        echo "<div class='bg-gray-100 p-4 mb-4 rounded-lg shadow'>";
                        echo "<p class='text-gray-800 font-semibold mb-2'>{$no}. {$siswa['nama']}</p>";
                        echo "<p class='text-sm text-gray-600 mb-2'><strong>Catatan:</strong> " . (!empty($siswa['catatan']) ? $siswa['catatan'] : '<span class="text-gray-500 italic">Belum ada catatan</span>') . "</p>";
                        echo "<p class='text-sm text-gray-600 mb-4'><strong>Tanggal:</strong> " . ($siswa['tanggal'] ?? '-') . "</p>";
                        if (!empty($siswa['catatan'])) {
                            echo "<div class='flex gap-2'>
                                    <a href='edit-catatan.php?id={$siswa['catatan_id']}' class='bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600'>Edit</a>
                                    <a href='../../process/hapus-catatan.php?id={$siswa['catatan_id']}' class='bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600' onclick='return confirm(\"Yakin ingin menghapus catatan ini?\")'>Hapus</a>
                                  </div>";
                        }
                        echo "</div>";
                        $no++;
                    }
                } else {
                    echo "<p class='text-center text-red-500 font-bold'>Tidak ada data catatan guru.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Tombol Tambah Catatan -->
        <div class="mt-6 text-center md:text-left">
            <a href="tambah-catatan.php" class="bg-green-500 text-white py-2 px-6 rounded-lg hover:bg-green-600">
                Tambah Catatan
            </a>
        </div>
    </div>
</body>

<?php
include '../footer.php';
?>
