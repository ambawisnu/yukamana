<?php
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Cek apakah akun ada
$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    session_start();
    $row = mysqli_fetch_assoc($result);
    
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['name']    = $row['name'];
    $_SESSION['email']   = $row['email'];
    $_SESSION['role']    = $row['role'];

    // Cek role dan redirect
    if ($row['role'] == 'admin') {
        header("Location: ../forms/admin.php");
    } else {
        header("Location: ../trips.html");
    }
    exit;
} else {
    echo "<script>alert('Email atau Password salah!'); window.location.href='../login.html';</script>";
}
?>
