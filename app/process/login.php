<?php
session_start();
include '../config/config-db.php';

$timeout_duration = 1800; // Timeout session 30 menit

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Gunakan prepared statement untuk keamanan
    $query = "SELECT id_user, nama, role, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true); // Mencegah session fixation

            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['is_logged_in'] = true; // Tambahkan ini untuk verifikasi login
            $_SESSION['last_activity'] = time(); // Untuk timeout session

            // Simpan session ID di cookie dengan keamanan tambahan
            setcookie("session_id", session_id(), [
                "expires" => time() + $timeout_duration,
                "path" => "/",
                "secure" => true,  // Hanya dikirim melalui HTTPS
                "httponly" => true // Mencegah akses JavaScript
            ]);

            // Redirect berdasarkan peran (role)
            if ($row['role'] === "Admin") {
                header("Location: ../layout/admin/index.php?pesan=login_berhasil");
            } elseif ($row['role'] === "Guru") {
                header("Location: ../layout/guru/index.php?pesan=login_berhasil");
            } else {
                header("Location: ../../index.php?pesan=role_tidak_valid");
            }
            exit();
        } else {
            header("Location: ../../index.php?pesan=password_salah");
            exit();
        }
    } else {
        header("Location: ../../index.php?pesan=email_tidak_ditemukan");
        exit();
    }
} else {
    header("Location: ../../index.php?pesan=akses_ditolak");
    exit();
}
?>
