<?php
include '../../config/session.php';
include '../../config/config-db.php';

$id = $_GET['id'];
$query = "SELECT * FROM pengumuman WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pengumuman = $result->fetch_assoc();

include '../header-admin.php';
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Edit Pengumuman</h2>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="../../process/update-pengumuman.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $pengumuman['id']; ?>">
                <input type="text" name="judul" class="border p-2 w-full mb-2" value="<?php echo $pengumuman['judul']; ?>" required>
                <textarea name="isi" class="border p-2 w-full mb-2" required><?php echo $pengumuman['isi']; ?></textarea>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>

<?php
include '../footer-admin.php';
?>