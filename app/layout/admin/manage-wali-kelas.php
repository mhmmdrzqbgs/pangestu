<?php
include '../../process/get-data/get-guru.php';
include '../header-admin.php';

$kelasOptions = range(1, 6);
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 mt-2 mb-2 mx-2 content">

        <!-- Judul Halaman -->
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center md:text-left">Manajemen Guru</h2>

        <!-- Tabel Data Guru -->
        <div class="bg-white rounded-lg p-4 shadow-md overflow-x-auto">
            <table class="w-full min-w-[600px] text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4 text-center">Wali Kelas</th>
                        <th class="py-3 px-4">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($guruList)): ?>
                        <?php $no = 1;
                        foreach ($guruList as $guru): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 text-center"><?= $no++; ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($guru['nama']); ?></td>
                                <td class="py-3 px-4 text-center">
                                    <form action="../../process/handle-guru.php" method="POST" class="flex justify-center">
                                        <input type="hidden" name="id_user" value="<?= $guru['id_user']; ?>">
                                        <select name="kelas" class="border p-2 rounded min-w-[120px] md:min-w-[150px] lg:min-w-[200px] focus:ring-2 focus:ring-blue-500 focus:outline-none" onchange="this.form.submit()">
                                            <option value="">Pilih Kelas</option>
                                            <?php foreach ($kelasOptions as $kelas): ?>
                                                <option value="<?= $kelas; ?>" <?= $guru['kelas'] == $kelas ? 'selected' : ''; ?>>Kelas <?= $kelas; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-3 px-4"><?= htmlspecialchars($guru['email']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-3 text-red-500">Tidak ada data guru.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<?php include '../footer-admin.php'; ?>
