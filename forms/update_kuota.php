<?php
include '../forms/db.php';

$id = $_POST['id'];
$kuota = $_POST['kuota'];

mysqli_query($conn, "UPDATE trips SET kuota = '$kuota' WHERE id = '$id'");
header("Location: admin.php");
exit;
