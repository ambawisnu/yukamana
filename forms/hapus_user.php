<?php
include '../forms/db.php'; // atau sesuaikan path koneksi kamu

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
