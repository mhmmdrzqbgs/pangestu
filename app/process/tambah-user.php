<?php
include '../config/session.php';
include '../config/config-db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $nama = trim($_POST['nama']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);
    $class = isset($_POST['class']) ? trim($_POST['class']) : NULL;

    // Hash password dengan bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Cek apakah role valid
    if ($role !== 'Admin' && $role !== 'Guru') {
        echo "<script>alert('Role tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Admin tidak memiliki kelas
    if ($role === 'Admin') {
        $class = NULL;
    }

    // Query menggunakan prepared statement untuk keamanan
    $query = "INSERT INTO user (email, nama, role, password, class) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $email, $nama, $role, $hashed_password, $class);

    if ($stmt->execute()) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location.href = '../layout/admin/manajemen-user.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan user!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
