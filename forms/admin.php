<?php
include '../forms/db.php'; 
$result = mysqli_query($conn, "SELECT * FROM trips");

$userCountQuery = "SELECT COUNT(*) as total FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['total'];

$recentUsersQuery = "SELECT name, email, registered_at FROM users ORDER BY registered_at DESC LIMIT 3";
$recentUsersResult = mysqli_query($conn, $recentUsersQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yukamana Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/css/admin.css" rel="stylesheet">
</head>

<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3">
      <h4 class="text-white">Yukamana Admin</h4>
      <a href="/forms/admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="/admin/users.html"><i class="bi bi-people"></i> Users</a>
      <a href="/admin/tripsadmin.html"><i class="bi bi-map"></i> Trips</a>
      <a href="/admin/feedback.html"><i class="bi bi-chat-left-dots"></i> Feedback</a>
      <a href="/login.html"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light border-bottom">
        <div class="container-fluid">
          <span class="navbar-brand mb-0 h1">Dashboard</span>
          <div class="d-flex align-items-center">
            <span class="me-2">Admin</span>
            <i class="bi bi-person-circle fs-4"></i>
          </div>
        </div>
      </nav>

      <!-- Dashboard Content -->
      <div class="container mt-4">
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text display-6"><?= $userCount ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Upcoming Trips</h5>
                <p class="card-text display-6">8</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Pending Feedback</h5>
                <p class="card-text display-6">5</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Additional Content -->
        <div class="row mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                Recent Registrations
              </div>
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Registered At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['registered_at'] ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
