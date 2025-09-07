<?php
include '../../config/session.php';
include '../header-admin.php';
include '../../config/config-db.php';

// Ambil data user dari database
$query = "SELECT id_user, email, nama, role, class FROM user";
$result = $conn->query($query);

// Pisahkan data berdasarkan role
$admins = [];
$gurus = [];

while ($row = $result->fetch_assoc()) {
    if ($row['role'] === 'Admin') {
        $admins[] = $row;
    } else if ($row['role'] === 'Guru') {
        $gurus[] = $row;
    }
}
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Manajemen User</h2>

        <!-- Form Tambah User -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg md:text-xl font-bold mb-4">Tambah User</h3>
            <form action="../../process/tambah-user.php" method="POST">
                <input type="email" name="email" class="border p-2 w-full mb-2 rounded-md" placeholder="Email" required>

                <input type="text" name="nama" class="border p-2 w-full mb-2 rounded-md" placeholder="Nama Lengkap" required>

                <select name="role" id="roleSelect" class="border p-2 w-full mb-2 rounded-md" required onchange="toggleClassSelect()">
                    <option value="">Pilih Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Guru">Guru</option>
                </select>

                <!-- Pilihan Kelas (hanya untuk Guru) -->
                <select name="class" id="classSelect" class="border p-2 w-full mb-2 rounded-md hidden">
                    <option value="">Pilih Kelas</option>
                    <option value="1">Kelas 1</option>
                    <option value="2">Kelas 2</option>
                    <option value="3">Kelas 3</option>
                    <option value="4">Kelas 4</option>
                    <option value="5">Kelas 5</option>
                    <option value="6">Kelas 6</option>
                </select>

                <button type="button" class="bg-green-500 text-white px-4 py-2 rounded w-full md:w-auto" onclick="openPasswordModal()">Tambah</button>

                <!-- Modal Pop-Up untuk Password -->
                <div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white p-4 md:p-6 rounded-lg w-11/12 max-w-md">
                        <h3 class="text-lg md:text-xl font-bold mb-4">Masukkan Password</h3>
                        <input type="password" id="password" name="password" class="border p-2 w-full mb-2 rounded-md" placeholder="Password" required oninput="checkPasswordMatch()">
                        <input type="password" id="confirm_password" class="border p-2 w-full mb-2 rounded-md" placeholder="Konfirmasi Password" required oninput="checkPasswordMatch()">
                        <p id="passwordError" class="text-red-500 hidden">⚠ Password tidak cocok!</p>
                        <div class="flex justify-end mt-4">
                            <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded mr-2" onclick="closeModal()">Batal</button>
                            <button type="submit" id="submitButton" class="bg-green-500 text-white px-4 py-2 rounded" disabled>Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabel Admin -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg md:text-xl font-bold mb-4">Daftar Admin</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-300">
                            <th class="border p-2">ID</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin) : ?>
                            <tr>
                                <td class="border p-2 text-center"><?php echo $admin['id_user']; ?></td>
                                <td class="border p-2 text-center"><?php echo $admin['email']; ?></td>
                                <td class="border p-2 text-center"><?php echo $admin['nama']; ?></td>
                                <td class="border p-2 text-center">
                                    <div class="flex flex-col md:flex-row gap-2 justify-center">
                                        <a href="edit-user.php?id=<?php echo htmlspecialchars($admin['id_user']); ?>"
                                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                                            Edit
                                        </a>
                                        <a href="../../process/hapus-user.php?id=<?php echo htmlspecialchars($admin['id_user']); ?>"
                                            class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition"
                                            onclick="return confirm('Hapus user ini?')">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Guru -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
            <h3 class="text-lg md:text-xl font-bold mb-4">Daftar Guru</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-300">
                            <th class="border p-2">ID</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">Kelas</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gurus as $guru) : ?>
                            <tr>
                                <td class="border p-2 text-center"><?php echo $guru['id_user']; ?></td>
                                <td class="border p-2 text-center"><?php echo $guru['email']; ?></td>
                                <td class="border p-2 text-center"><?php echo $guru['nama']; ?></td>
                                <td class="border p-2 text-center"><?php echo ($guru['class']) ? 'Kelas ' . $guru['class'] : '-'; ?></td>
                                <td class="border p-2 text-center">
                                    <div class="flex flex-col md:flex-row gap-2 justify-center">
                                        <a href="edit-user.php?id=<?php echo htmlspecialchars($guru['id_user']); ?>"
                                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                                            Edit
                                        </a>
                                        <a href="../../process/hapus-user.php?id=<?php echo htmlspecialchars($guru['id_user']); ?>"
                                            class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition"
                                            onclick="return confirm('Hapus user ini?')">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function openPasswordModal() {
            document.getElementById("passwordModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("passwordModal").classList.add("hidden");
        }
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var errorText = document.getElementById("passwordError");
            var submitButton = document.getElementById("submitButton");

            errorText.classList.toggle('hidden', password === confirmPassword);
            submitButton.disabled = password !== confirmPassword;
        }

        function togglePassword(id) {
            var input = document.getElementById(id);
            input.type = (input.type === "password") ? "text" : "password";
        }

        document.getElementById('roleSelect').addEventListener('change', function() {
            document.getElementById('classSelect').classList.toggle('hidden', this.value !== 'Guru');
        });
    </script>
</body>

<?php include '../footer-admin.php'; ?>