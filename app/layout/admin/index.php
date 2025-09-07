<?php
include '../../process/get-data/get-data-admin.php';
include '../header-admin.php';
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 mt-2 mb-2 mx-2 content">

        <!-- Judul Halaman -->
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center md:text-left">
            <span class="font-bold text-red-500">PANGESTU</span>
            <span class="text-gray-600 text-lg block">Platform Analisis dan Navigasi Evaluasi Siswa Terpadu Utama</span>
        </h2>

        <!-- Ringkasan Data -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <i class="fas fa-user-tie text-green-500 text-3xl mr-4"></i>
                <div>
                    <h3 class="text-gray-600 text-lg font-semibold">Total Guru</h3>
                    <p class="text-2xl font-bold"><?= htmlspecialchars($total_guru); ?></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <i class="fas fa-users text-red-500 text-3xl mr-4"></i>
                <div>
                    <h3 class="text-gray-600 text-lg font-semibold">Total Siswa</h3>
                    <p class="text-2xl font-bold"><?= htmlspecialchars($total_siswa); ?></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <i class="fas fa-calendar-alt text-blue-500 text-3xl mr-4"></i>
                <div>
                    <h3 class="text-gray-600 text-lg font-semibold">Tahun Ajaran Aktif</h3>
                    <p class="text-2xl font-bold"><?= htmlspecialchars($tahun_ajaran_aktif); ?></p>
                </div>
            </div>
        </div>

        <!-- Pengumuman Terbaru -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-600 mb-4">Pengumuman Terbaru</h3>
            <?php if (!empty($pengumuman_list)) : ?>
                <ul class="space-y-4">
                    <?php foreach ($pengumuman_list as $pengumuman) : ?>
                        <li class="border-b pb-4">
                            <strong class="text-blue-600"><?= htmlspecialchars($pengumuman['judul']); ?></strong>
                            <br>
                            <small class="text-gray-500"><?= date("d M Y", strtotime($pengumuman['tanggal'])); ?></small>
                            <p class="text-gray-700 mt-2"><?= nl2br(htmlspecialchars($pengumuman['isi'])); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="text-gray-500">Tidak ada pengumuman terbaru.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

<?php include '../footer-admin.php'; ?>
