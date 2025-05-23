<?php
include '../forms/db.php';

$query = "SELECT id, title, description, kuota, image FROM trips ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Yukamana Admin - Trips</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="/assets/css/admin.css" rel="stylesheet" />
</head>
<body>
  <div class="d-flex">
    <div class="sidebar p-3">
      <h4 class="text-white">Yukamana Admin</h4>
      <a href="/forms/admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="/forms/user.php"><i class="bi bi-people"></i> Users</a>
      <a href="/forms/tripsadmin.php"><i class="bi bi-map"></i> Trips</a>
      <a href="/admin/feedback.html"><i class="bi bi-chat-left-dots"></i> Feedback</a>
      <a href="/login.html"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="flex-grow-1">
      <nav class="navbar navbar-expand-lg navbar-light border-bottom">
        <div class="container-fluid">
          <span class="navbar-brand mb-0 h1">Trips</span>
          <div class="d-flex align-items-center">
            <span class="me-2">Admin</span>
            <i class="bi bi-person-circle fs-4"></i>
          </div>
        </div>
      </nav>

      <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
          <h4>List of Trips</h4>
          <a href="add_trip.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Trip
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Kuota</th>
                <th>Image</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                  <td><?= htmlspecialchars($row['id']) ?></td>
                  <td><?= htmlspecialchars($row['title']) ?></td>
                  <td><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</td>
                  <td><?= htmlspecialchars($row['kuota']) ?></td>
                  <td>
                    <?php if ($row['image']): ?>
                      <img src="<?= htmlspecialchars($row['image']) ?>" alt="Image" style="max-width: 100px; height: auto;">
                    <?php else: ?>
                      <span class="text-muted">No image</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="edit_trip.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="delete_trip.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus trip ini?')">
                      <i class="bi bi-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
              <?php if (mysqli_num_rows($result) == 0) : ?>
                <tr>
                  <td colspan="6" class="text-center">No trips found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
