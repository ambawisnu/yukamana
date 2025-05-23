<?php
include '../forms/db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: tripsadmin.php');
    exit;
}

// Ambil data trip
$result = mysqli_query($conn, "SELECT * FROM trips WHERE id = $id");
$trip = mysqli_fetch_assoc($result);
if (!$trip) {
    echo "Trip tidak ditemukan.";
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $kuota = (int)($_POST['kuota'] ?? 0);

    // Update image jika ada upload baru
    $imagePath = $trip['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $fileName = uniqid() . "-" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Hapus file lama kalau ada
                if ($trip['image'] && file_exists("../" . $trip['image'])) {
                    unlink("../" . $trip['image']);
                }
                $imagePath = "uploads/" . $fileName;
            } else {
                $error = "Gagal meng-upload gambar.";
            }
        } else {
            $error = "Format gambar tidak didukung.";
        }
    }

    if (empty($title) || empty($description) || $kuota <= 0) {
        $error = "Title, description dan kuota wajib diisi dengan benar.";
    }

    if (!$error) {
        $sql = "UPDATE trips SET title='$title', description='$description', kuota=$kuota, image='$imagePath' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            header('Location: tripsadmin.php');
            exit;
        } else {
            $error = "Database error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Trip</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">
  <h2>Edit Trip</h2>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($trip['title']) ?>">
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" required><?= htmlspecialchars($trip['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>Kuota</label>
      <input type="number" name="kuota" class="form-control" required min="1" value="<?= (int)$trip['kuota'] ?>">
    </div>
    <div class="mb-3">
      <label>Current Image</label><br>
      <?php if ($trip['image']): ?>
        <img src="../<?= htmlspecialchars($trip['image']) ?>" alt="Current Image" style="max-width: 200px;">
      <?php else: ?>
        <span>No image</span>
      <?php endif; ?>
    </div>
    <div class="mb-3">
      <label>Change Image (optional)</label>
      <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif">
    </div>
    <button type="submit" class="btn btn-primary">Update Trip</button>
    <a href="tripsadmin.php" class="btn btn-secondary">Cancel</a>
  </form>
</body>
</html>
