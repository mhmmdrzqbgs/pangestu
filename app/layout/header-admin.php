<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANGESTU</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <link rel="icon" href="../../../public/assets/img/tutwuri.png" type="image/png">
</head>
<style>
    #profileModal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 50;
    background-color: transparent; /* Hapus background putih */
    padding: 20px;
    border-radius: 8px;
    box-shadow: none; /* Hapus shadow agar lebih bersih */
    width: 90%;
    max-width: 400px;
}

/* Responsif untuk layar kecil */
@media (max-width: 480px) {
    #profileModal {
        width: 95%;
        padding: 15px;
    }
}
</style>
    <!-- Header -->
    <header class="bg-white border-b border-gray-300 fixed top-0 w-full z-50">
        <div class="flex justify-between items-center px-9 py-4">
            <button id="menuBtn">
                <i class="fas fa-bars text-red-500 text-lg"></i>
            </button>

            <div class="relative">
                <button id="profileBtn" class="focus:outline-none">
                    <i class="fas fa-user text-red-500 text-lg"></i>
                </button>

                <!-- Dropdown Profil -->
                <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-md hidden">
                    <button onclick="showProfileModal()" class="block px-4 py-2 text-gray-700 hover:bg-gray-200 w-full text-left">Profil</button>
                    <a href="../../process/logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Modal Profil -->
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-96 text-center">
            <h3 class="text-xl font-bold mb-4">Profil Pengguna</h3>
            <p><strong>Nama:</strong> <span id="modalNama">Nama Anda</span></p>
            <p><strong>Email:</strong> <span id="modalEmail">email@example.com</span></p>
            <button onclick="hideProfileModal()" class="bg-gray-400 text-white px-4 py-2 rounded mt-4">Tutup</button>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sideNav" class="lg:block hidden bg-white w-64 h-screen fixed border-none overflow-y-auto top-14">
        <div class="p-2 flex flex-col items-center">
            <!-- Logo -->
            <div class="flex justify-center mt-5 flex-col items-center">
                <img src="../../../public/assets/img/tutwuri.png" alt="logo" class="h-20 w-20">
                <p class="text-gray-500 text-center mt-2"><b>PANGESTU</b></p>
                <p class="text-gray-500 text-center mt-1">SD Negeri 1 Pedawang</p>
            </div>

            <!-- Menu Navigasi -->
            <div class="w-full space-y-2 mt-5">
                <a href="index.php" class="px-2 py-2 flex items-center space-x-2 rounded-md text-gray-500 group w-full hover:bg-gray-200">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </a>
                <a href="manage-wali-kelas.php" class="px-2 py-2 flex items-center space-x-2 rounded-md text-gray-500 group w-full hover:bg-gray-200">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Manajemen Guru</span>
                </a>
                <a href="manage-siswa.php" class="px-2 py-2 flex items-center space-x-2 rounded-md text-gray-500 group w-full hover:bg-gray-200">
                    <i class="fas fa-user-graduate"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="manajemen-user.php" class="px-2 py-2 flex items-center space-x-2 rounded-md text-gray-500 group w-full hover:bg-gray-200">
                    <i class="fas fa-users"></i>
                    <span>Manajemen User</span>
                </a>
                <a href="tahun-ajaran.php" class="px-2 py-2 flex items-center space-x-2 rounded-md text-gray-500 group w-full hover:bg-gray-200">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Pengaturan Tahun Ajaran</span>
                </a>
                <a href="../admin/pengumuman.php" class="px-2 py-2 flex items-center space-x-2 rounded-md text-gray-500 group w-full hover:bg-gray-200">
                    <i class="fas fa-bullhorn"></i>
                    <span>Pengumuman</span>
                </a>
            </div>
        </div>
    </div>
