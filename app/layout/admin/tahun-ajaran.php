<?php
include '../../config/session.php';
include '../header-admin.php';
include '../../config/config-db.php';

$query = "SELECT * FROM tahun_ajaran ORDER BY tahun DESC, semester ASC";
$result = $conn->query($query);

$query_active = "SELECT tahun FROM tahun_ajaran WHERE status = 'aktif' LIMIT 1";
$result_active = $conn->query($query_active);
$tahun_aktif = ($result_active->num_rows > 0) ? $result_active->fetch_assoc()['tahun'] : 'Belum Ada';
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Pengaturan Tahun Ajaran</h2>

        <!-- Tambah Tahun Ajaran -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-xl font-bold mb-4">Tambah Tahun Ajaran</h3>
            <form action="../../process/tambah-tahun-ajaran.php" method="POST" class="space-y-4">
                <input type="text" name="tahun" class="border p-2 w-full rounded" placeholder="Contoh: 2024/2025" required>
                <select name="semester" class="border p-2 w-full rounded" required>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                </select>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded w-full md:w-auto">Tambah</button>
            </form>
        </div>

        <!-- Daftar -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold mb-4">Daftar Tahun Ajaran</h3>
            <p class="mb-4 font-semibold">Tahun Ajaran Aktif: <span class="text-blue-500"><?php echo $tahun_aktif; ?></span></p>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-300 text-sm md:text-base">
                            <th class="border p-2">Tahun Ajaran</th>
                            <th class="border p-2">Semester</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td class="border p-2 text-center"><?php echo $row['tahun']; ?></td>
                                <td class="border p-2 text-center"><?php echo $row['semester']; ?></td>
                                <td class="border p-2 text-center">
                                    <?php echo ($row['status'] == 'aktif') ? '<span class="text-green-500">Aktif</span>' : '<span class="text-red-500">Tidak Aktif</span>'; ?>
                                </td>
                                <td class="border p-2 text-center">
                                    <div class="flex justify-center gap-2">
                                        <?php if ($row['status'] != 'aktif') : ?>
                                            <a href="../../process/set-aktif.php?id=<?php echo $row['id']; ?>" 
                                               class="bg-blue-500 text-white px-3 py-1 rounded text-xs md:text-sm">
                                                Set Aktif
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<?php include '../footer-admin.php'; ?>
