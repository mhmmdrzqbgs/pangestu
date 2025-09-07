<?php
include '../../config/session.php';
include '../header-admin.php';
include '../../process/get-data/get-pengumuman.php';

// Cek apakah data pengumuman kosong
$pengumumanKosong = empty($pengumuman_list);
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mb-2 mx-2 content">

        <!-- Judul Halaman -->
        <h2 class="text-2xl md:text-3xl font-bold text-gray-600 mb-6 text-center">Manajemen Pengumuman</h2>

        <!-- Form Tambah Pengumuman -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-xl font-bold mb-4">Tambah Pengumuman</h3>
            <form action="../../process/tambah-pengumuman.php" method="POST" class="space-y-4">
                <input type="text" name="judul" class="border p-3 w-full rounded-md" placeholder="Judul Pengumuman" required>
                <textarea name="isi" class="border p-3 w-full rounded-md" placeholder="Isi Pengumuman" rows="4" required></textarea>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md w-full md:w-auto">Tambah</button>
            </form>
        </div>

        <!-- Daftar Pengumuman -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold mb-4">Daftar Pengumuman</h3>
            <?php if ($pengumumanKosong) : ?>
                <p class="text-center text-gray-500 font-semibold">Tidak ada pengumuman yang tersedia.</p>
            <?php else : ?>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px] border-collapse border">
                        <thead>
                            <tr class="bg-gray-300 text-sm text-left">
                                <th class="border p-2">Judul</th>
                                <th class="border p-2">Isi</th>
                                <th class="border p-2">Tanggal</th>
                                <th class="border p-2">Dibuat Oleh</th>
                                <th class="border p-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pengumuman_list as $pengumuman) : ?>
                                <tr class="text-sm">
                                    <td class="border p-2"><?php echo $pengumuman['judul']; ?></td>
                                    <td class="border p-2"><?php echo substr($pengumuman['isi'], 0, 50) . '...'; ?></td>
                                    <td class="border p-2"><?php echo $pengumuman['tanggal']; ?></td>
                                    <td class="border p-2"><?php echo $pengumuman['nama_user']; ?></td>
                                    <td class="border p-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="edit-pengumuman.php?id=<?php echo $pengumuman['id']; ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">Edit</a>
                                            <a href="../../process/hapus-pengumuman.php?id=<?php echo $pengumuman['id']; ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 text-xs" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

<?php include '../footer-admin.php'; ?>
