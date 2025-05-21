<?php
include '../forms/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

$name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'active');
$registered_at = mysqli_real_escape_string($conn, $_POST['registered_at'] ?? date('Y-m-d'));

if (empty($name) || empty($email)) {
    http_response_code(400);
    echo "Name and Email are required.";
    exit;
}

// Jika password wajib di db, buat default password hash (ubah sesuai kebutuhan)
$password = password_hash('default123', PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, status, registered_at, password) VALUES ('$name', '$email', '$status', '$registered_at', '$password')";

if (mysqli_query($conn, $sql)) {
    // Kirim balik ID user yang baru dibuat
    echo mysqli_insert_id($conn);
} else {
    http_response_code(500);
    echo "Database error: " . mysqli_error($conn);
}
