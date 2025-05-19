<?php
include 'db.php';

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = $_POST['password'];

// Cek apakah email sudah digunakan
$check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Email sudah terdaftar!'); window.location.href='../register.html';</script>";
    exit;
}

// Simpan user baru (role default: user)
$query = "INSERT INTO users (name, email, password, role) 
          VALUES ('$name', '$email', '$password', 'user')";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='../login.html';</script>";
} else {
    echo "<script>alert('Registrasi gagal!'); window.location.href='../register.html';</script>";
}
?>
