<?php
include '../../process/get-data/get-data-index.php';
include '../header.php';
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center md:text-left">
            <span class="font-bold text-red-500">PANGESTU</span>
            <span class="text-gray-600 text-lg block">Platform Analisis dan Navigasi Evaluasi Siswa Terpadu Utama</span>
        </h2>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <i class="fas fa-users text-red-500 text-3xl mr-4"></i>
                <div>
                    <h3 class="text-gray-600 text-lg font-semibold">Total Siswa</h3>
                    <p class="text-2xl font-bold"><?= htmlspecialchars($data_siswa['total_siswa']); ?></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <i class="fas fa-chart-line text-blue-500 text-3xl mr-4"></i>
                <div>
                    <h3 class="text-gray-600 text-lg font-semibold">Rata-rata Nilai</h3>
                    <p class="text-2xl font-bold"><?= htmlspecialchars($data_siswa['rata_nilai']); ?></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mr-4"></i>
                <div>
                    <h3 class="text-gray-600 text-lg font-semibold">Siswa Butuh Perhatian</h3>
                    <p class="text-2xl font-bold"><?= htmlspecialchars($data_siswa['siswa_perhatian']); ?></p>
                </div>
            </div>
        </div>

        <!-- Grafik Rata-rata Nilai -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-4">
            <h3 class="text-lg font-semibold text-gray-600 mb-4">Grafik Rata-rata Nilai per Semester</h3>
            <canvas id="chartSemester"></canvas>
        </div>

        <!-- Pengumuman -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-4">
            <h3 class="text-lg font-semibold text-blue-600 mb-4">Pengumuman</h3>
            <ul class="list-disc pl-6 text-gray-700 space-y-4">
                <?php if (!empty($data_siswa['pengumuman'])): ?>
                    <?php foreach ($data_siswa['pengumuman'] as $pengumuman): ?>
                        <li>
                            <strong class="text-blue-500"><?= htmlspecialchars($pengumuman['judul']); ?></strong>
                            <span class="text-gray-500 text-sm">(<?= htmlspecialchars($pengumuman['tanggal']); ?>)</span>
                            <p class="text-sm mt-1"><?= nl2br(htmlspecialchars($pengumuman['isi'])); ?></p>
                            <p class="text-xs text-gray-500">Dibuat oleh: <?= htmlspecialchars($pengumuman['nama_guru']); ?></p>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="text-gray-500">Tidak ada pengumuman.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>

<?php include '../footer.php'; ?>
