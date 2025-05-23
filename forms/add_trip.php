<?php
include '../forms/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $kuota = (int)($_POST['kuota'] ?? 0);

    // Upload image
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $fileName = uniqid() . "-" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = "uploads/" . $fileName; // relative path for HTML
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

    if (!isset($error)) {
        $sql = "INSERT INTO trips (title, description, kuota, image) VALUES ('$title', '$description', $kuota, '$imagePath')";
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
  <title>Add Trip</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">
  <h2>Add Trip</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
      <label>Kuota</label>
      <input type="number" name="kuota" class="form-control" required min="1" value="<?= (int)($_POST['kuota'] ?? 0) ?>">
    </div>
    <div class="mb-3">
      <label>Image</label>
      <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Trip</button>
    <a href="tripsadmin.php" class="btn btn-secondary">Cancel</a>
  </form>
</body>
</html>
