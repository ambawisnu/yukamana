<?php
include '../forms/db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: tripsadmin.php');
    exit;
}

// Ambil path gambar untuk dihapus
$result = mysqli_query($conn, "SELECT image FROM trips WHERE id = $id");
$row = mysqli_fetch_assoc($result);
if ($row && $row['image'] && file_exists("../" . $row['image'])) {
    unlink("../" . $row['image']);
}

// Hapus data trip
mysqli_query($conn, "DELETE FROM trips WHERE id = $id");

header('Location: tripsadmin.php');
exit;
