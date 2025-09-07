<?php
session_start(); // Mulai sesi

// Cek apakah logout karena sesi habis
$pesan = isset($_GET['expired']) ? "sesi_habis" : "logout";

// Hapus semua variabel sesi
$_SESSION = [];

// Hancurkan sesi
session_unset();
session_destroy();

// Hapus cookie sesi jika ada
if (isset($_COOKIE['session_id'])) {
    setcookie("session_id", "", time() - 3600, "/", "", false, true);
}

// Redirect ke halaman login dengan pesan yang sesuai
header("Location: ../../index.php?pesan=$pesan");
exit();
?>
