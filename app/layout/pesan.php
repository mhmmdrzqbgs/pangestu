<!-- pesan.php -->
<?php
$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : "";
?>

<div class="mb-4">
    <?php if ($pesan == "gagal"): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
            <p>Email atau password salah! Coba lagi.</p>
        </div>
    <?php elseif ($pesan == "belum_login"): ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
            <p>Anda harus login terlebih dahulu.</p>
        </div>
    <?php elseif ($pesan == "session_expired"): ?>
        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4">
            <p>Sesi Anda telah kedaluwarsa, silakan login kembali.</p>
        </div>
    <?php elseif ($pesan == "login_berhasil"): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
            <p>Login berhasil, selamat datang!</p>
        </div>
    <?php endif; ?>
</div>
