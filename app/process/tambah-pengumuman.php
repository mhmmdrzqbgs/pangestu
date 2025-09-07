<?php
include '../config/session.php';
include '../config/config-db.php';

// **Pastikan session berisi ID pengguna**
if (!isset($_SESSION['id_user'])) {
    die("Error: Pengguna belum login. Silakan login kembali.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'] ?? '';
    $isi = $_POST['isi'] ?? '';
    $user_id = $_SESSION['id_user']; // Ambil dari session (id_user di tabel user)

    // **Gunakan user_id sesuai tabel pengumuman**
    $query = "INSERT INTO pengumuman (user_id, judul, isi, tanggal) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $user_id, $judul, $isi);

    if ($stmt->execute()) {
        header("Location: ../layout/admin/pengumuman.php?status=sukses");
    } else {
        header("Location: ../layout/admin/pengumuman.php?status=gagal&error=db");
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
