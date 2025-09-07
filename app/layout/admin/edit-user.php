<?php
include '../../config/session.php';
include '../header-admin.php';
include '../../config/config-db.php';

// Cek apakah ID user tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID user tidak ditemukan!");
}

$id_user = intval($_GET['id']);

// Ambil data user berdasarkan ID
$query = $conn->prepare("SELECT id_user, email, nama, role FROM user WHERE id_user = ?");
$query->bind_param("i", $id_user);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User tidak ditemukan!");
}

// Jika form utama dikirim (Edit Profil)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $role = $_POST['role'];

    // Update data user
    $update = $conn->prepare("UPDATE user SET email = ?, nama = ?, role = ? WHERE id_user = ?");
    $update->bind_param("sssi", $email, $nama, $role, $id_user);

    if ($update->execute()) {
        echo "<script>alert('Data user berhasil diperbarui!'); window.location='manajemen-user.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}

// Jika form password dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Cek apakah password baru dan konfirmasi cocok
    if ($password_baru === $konfirmasi_password) {
        $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT);

        // Update password
        $update_pass = $conn->prepare("UPDATE user SET password = ? WHERE id_user = ?");
        $update_pass->bind_param("si", $hashed_password, $id_user);

        if ($update_pass->execute()) {
            echo "<script>alert('Password berhasil diperbarui!');</script>";
        } else {
            echo "<script>alert('Gagal memperbarui password!');</script>";
        }
    } else {
        echo "<script>alert('Password tidak cocok!');</script>";
    }
}
?>

<body class="bg-gray-200 mt-20">
    <div class="lg:ml-64 lg:pl-2 lg:w-75% mt-2 mb-2 mx-2 content">
        <h2 class="text-3xl font-bold text-gray-600 mb-6 text-center">Edit User</h2>

        <!-- Form Edit User -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="" method="POST">
                <label class="block font-semibold mb-1">Email:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" class="border p-2 w-full mb-4 rounded-md" required>

                <label class="block font-semibold mb-1">Nama Lengkap:</label>
                <input type="text" name="nama" value="<?php echo $user['nama']; ?>" class="border p-2 w-full mb-4 rounded-md" required>

                <label class="block font-semibold mb-1">Role:</label>
                <select name="role" class="border p-2 w-full mb-4 rounded-md" required>
                    <option value="Admin" <?php echo ($user['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Guru" <?php echo ($user['role'] == 'Guru') ? 'selected' : ''; ?>>Guru</option>
                </select>

                <div class="flex flex-col md:flex-row gap-2">
                    <button type="submit" name="update_profile" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 w-full md:w-auto">Simpan Perubahan</button>
                    <button type="button" onclick="togglePasswordModal()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 w-full md:w-auto">Edit Password</button>
                    <a href="manajemen-user.php" class="bg-gray-400 text-white px-4 py-2 rounded-md w-full md:w-auto text-center">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Password -->
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm mx-4 md:w-96">
            <h3 class="text-xl font-bold mb-4">Edit Password</h3>
            <form action="" method="POST">
                <label class="block font-semibold mb-1">Password Baru:</label>
                <div class="relative mb-4">
                    <input type="password" name="password_baru" id="password_baru" class="border p-2 w-full rounded-md" required>
                    <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePassword('password_baru')">👁️</button>
                </div>

                <label class="block font-semibold mb-1">Konfirmasi Password:</label>
                <div class="relative mb-4">
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="border p-2 w-full rounded-md" required>
                    <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePassword('konfirmasi_password')">👁️</button>
                </div>
                <p id="passwordMismatch" class="text-red-500 hidden">Password tidak cocok!</p>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="togglePasswordModal()" class="bg-gray-400 text-white px-4 py-2 rounded-md">Batal</button>
                    <button type="submit" name="update_password" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordModal() {
            document.getElementById('passwordModal').classList.toggle('hidden');
        }

        function togglePassword(id) {
            let input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        document.getElementById('konfirmasi_password').addEventListener('input', function() {
            let passwordBaru = document.getElementById('password_baru').value;
            let konfirmasiPassword = this.value;
            let warningText = document.getElementById('passwordMismatch');

            if (passwordBaru && konfirmasiPassword && passwordBaru !== konfirmasiPassword) {
                warningText.classList.remove('hidden');
            } else {
                warningText.classList.add('hidden');
            }
        });
    </script>
</body>

<?php include '../footer-admin.php'; ?>