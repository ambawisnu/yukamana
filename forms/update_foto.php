<?php
include '../forms/db.php';

$id = $_POST['id'];
$imageName = $_FILES['image']['name'];
$imageTmp = $_FILES['image']['tmp_name'];

// Simpan gambar ke folder
move_uploaded_file($imageTmp, "../images/" . $imageName);

// Update nama file di database
mysqli_query($conn, "UPDATE trips SET image = '$imageName' WHERE id = '$id'");
header("Location: admin.php");
exit;
