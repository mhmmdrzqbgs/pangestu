<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'session.php';
include 'config-db.php';

if (!isset($_SESSION['id_user'])) {
    echo json_encode(["error" => "Sesi tidak ditemukan"]);
    exit;
}

$id_user = $_SESSION['id_user'];

$query = $conn->prepare("SELECT nama, email FROM user WHERE id_user = ?");
$query->bind_param("i", $id_user);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(["error" => "User tidak ditemukan"]);
} else {
    echo json_encode($user);
}
?>
