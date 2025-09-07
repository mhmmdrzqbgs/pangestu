<?php
include '../../config/config-db.php';

$kelas = isset($_GET['kelas']) ? intval($_GET['kelas']) : 1;

// Ambil data siswa berdasarkan kelas
$query = $conn->prepare("SELECT id, nama, jenis_kelamin, kelas FROM siswa WHERE kelas = ?");
$query->bind_param("i", $kelas);
$query->execute();
$result = $query->get_result();
?>

<!-- Container Utama -->
<div class="container mx-auto p-4">

    <!-- Tampilan Tabel untuk Desktop -->
    <div class="hidden md:block overflow-x-auto bg-white p-4 rounded-lg shadow-md">
        <table class="w-full border border-gray-300">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 border">No</th>
                    <th class="px-4 py-3 border">Nama</th>
                    <th class="px-4 py-3 border">Jenis Kelamin</th>
                    <th class="px-4 py-3 border">Kelas</th>
                    <th class="px-4 py-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2 text-center'>{$no}</td>";
                        echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td class='border px-4 py-2 text-center'>" . htmlspecialchars($row['jenis_kelamin']) . "</td>";
                        echo "<td class='border px-4 py-2 text-center'>Kelas " . htmlspecialchars($row['kelas']) . "</td>";
                        echo "<td class='border px-4 py-2 text-center'>
                                <a href='edit-siswa.php?id=" . $row['id'] . "' class='bg-yellow-500 text-white px-2 py-1 rounded-md'>Edit</a>
                                <a href='../../process/hapus-siswa.php?id=" . $row['id'] . "' class='bg-red-500 text-white px-2 py-1 rounded-md' onclick='return confirm(\"Yakin ingin menghapus siswa ini?\");'>Hapus</a>
                            </td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center py-4 text-red-500'>Tidak ada data siswa.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Tampilan Card View untuk Mobile -->
    <div class="md:hidden space-y-4">
        <?php
        // Reset result agar bisa digunakan lagi untuk tampilan mobile
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<div class='bg-white p-4 rounded-lg shadow-md'>";
                echo "<h3 class='text-lg font-semibold text-gray-800'>" . htmlspecialchars($row['nama']) . "</h3>";
                echo "<p class='text-gray-600'>Jenis Kelamin: <span class='font-medium'>" . htmlspecialchars($row['jenis_kelamin']) . "</span></p>";
                echo "<p class='text-gray-600'>Kelas: <span class='font-medium'>Kelas " . htmlspecialchars($row['kelas']) . "</span></p>";
                echo "<div class='mt-3 flex gap-2'>
                        <a href='edit-siswa.php?id=" . $row['id'] . "' class='bg-yellow-500 text-white px-3 py-1 rounded-md'>Edit</a>
                        <a href='../../process/hapus-siswa.php?id=" . $row['id'] . "' class='bg-red-500 text-white px-3 py-1 rounded-md' onclick='return confirm(\"Yakin ingin menghapus siswa ini?\");'>Hapus</a>
                    </div>";
                echo "</div>";
                $no++;
            }
        } else {
            echo "<p class='text-red-500 text-center'>Tidak ada data siswa.</p>";
        }
        ?>
    </div>
</div>

<?php $query->close(); ?>
