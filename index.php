<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="icon" href="public/assets/img/tutwuri.png" type="image/png">
    <title>PANGESTU Login</title>
</head>

<body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
    <div class="bg-sky-100 flex justify-center items-center h-screen">
        <!-- Bagian Gambar untuk Desktop -->
        <div class="w-1/2 h-screen hidden lg:block">
            <img src="public/assets/img/SD.jpg" alt="Placeholder Image" class="object-cover w-full h-full">
        </div>

        <!-- Bagian Form Login -->
        <div class="lg:p-36 md:p-52 sm:p-20 p-8 w-full lg:w-1/2 bg-white rounded-lg shadow-lg z-10">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">PANGESTU</h1>
                <p class="text-lg text-gray-600 mt-2">Platform Analisis dan Navigasi Evaluasi Siswa Terpadu Utama</p>
            </div>

            <?php
            $pesan = isset($_GET['pesan']) ? $_GET['pesan'] : '';

            if ($pesan === "gagal") {
                echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Email atau password salah! Coba lagi.</div>';
            } elseif ($pesan === "belum_login") {
                echo '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">Anda harus login terlebih dahulu.</div>';
            } elseif ($pesan === "session_expired") {
                echo '<div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 mb-4">Sesi Anda telah kedaluwarsa, silakan login kembali.</div>';
            } elseif ($pesan === "login_berhasil") {
                echo '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">Login berhasil, selamat datang!</div>';
            } elseif ($pesan === "password_salah") {
                echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Password yang kamu masukkan salah!</div>';
            } elseif ($pesan === "email_tidak_ditemukan") {
                echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Email tidak terdaftar!</div>';
            } elseif ($pesan === "akses_ditolak") {
                echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Akses ditolak!</div>';
            } elseif ($pesan === "role_tidak_valid") {
                echo '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">Peran tidak valid!</div>';
            }
            ?>

            <!-- Form Login -->
            <h1 class="text-2xl font-semibold mb-2">Login</h1>
            <form action="app/process/login.php" method="POST">
                <div class="mb-2">
                    <label for="email" class="block text-gray-600">Email</label>
                    <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-red-400" required>
                </div>
                <div class="mb-8">
                    <label for="password" class="block text-gray-800">Password</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-red-400" required>
                </div>
                <button type="submit" class="bg-red-500 hover:bg-red-400 text-white font-semibold rounded-md py-2 px-4 w-full">Login</button>
            </form>

            <div class="copyright-section mt-4 text-gray-500 text-center">
                <a href="#" class="hover:text-gray-550">SD Negeri 1 Pedawang ©2025</a>
            </div>
        </div>
    </div>
</body>

</html>