<?php
session_start();

// Timeout sesi (30 menit)
$timeout_duration = 1800;

// **Cek apakah pengguna memiliki sesi aktif & sudah login**
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || !isset($_SESSION['is_logged_in'])) {
    header("Location: ../../../index.php?pesan=harus_login");
    exit();
}

// **Cek timeout sesi**
if (isset($_SESSION['last_activity'])) {
    $waktu_idle = time() - $_SESSION['last_activity'];
    if ($waktu_idle > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: ../../../index.php?pesan=sesi_habis");
        exit();
    }
}

// **Perbarui waktu aktivitas terakhir**
$_SESSION['last_activity'] = time();

// **Cek peran pengguna untuk halaman tertentu**
$page_role = basename($_SERVER['PHP_SELF']);

if (strpos($page_role, "guru") !== false && $_SESSION['role'] !== 'Guru') {
    die("Akses ditolak.");
}

if (strpos($page_role, "admin") !== false && $_SESSION['role'] !== 'Admin') {
    die("Akses ditolak.");
}

// **Perbarui cookie sesi agar tidak timeout jika masih aktif**
setcookie("session_id", session_id(), [
    "expires" => time() + $timeout_duration,
    "path" => "/",
    "secure" => true,
    "httponly" => true
]);
?>
