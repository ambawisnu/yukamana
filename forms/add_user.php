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

$sql = "INSERT INTO users (name, email, status, registered_at) VALUES ('$name', '$email', '$status', '$registered_at')";

if (mysqli_query($conn, $sql)) {
    http_response_code(200);
    echo "success";
} else {
    http_response_code(500);
    echo "Database error: " . mysqli_error($conn);
}
?>
