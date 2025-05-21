<?php
include '../forms/db.php';

$query = "SELECT id, name, email, registered_at, status FROM users ORDER BY registered_at DESC";
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
  <title>Yukamana Admin - Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="/assets/css/admin.css" rel="stylesheet" />
</head>

<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3">
      <h4 class="text-white">Yukamana Admin</h4>
      <a href="/forms/admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="/forms/user.php"><i class="bi bi-people"></i> Users</a>
      <a href="/admin/tripsadmin.html"><i class="bi bi-map"></i> Trips</a>
      <a href="/admin/feedback.html"><i class="bi bi-chat-left-dots"></i> Feedback</a>
      <a href="/login.html"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1">
      <nav class="navbar navbar-expand-lg navbar-light border-bottom">
        <div class="container-fluid">
          <span class="navbar-brand mb-0 h1">Users</span>
          <div class="d-flex align-items-center">
            <span class="me-2">Admin</span>
            <i class="bi bi-person-circle fs-4"></i>
          </div>
        </div>
      </nav>

      <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>List of Registered Users</h4>
          <button class="btn btn-primary" onclick="toggleAddUserForm()">
            <i class="bi bi-plus-circle"></i> Add User
          </button>
        </div>

        <!-- Form Tambah User -->
        <div id="addUserForm" style="display: none;" class="card p-3 shadow-sm mb-4">
          <form id="addUserFormElement" class="row g-3">
            <div class="col-md-3">
              <input type="text" name="name" class="form-control" placeholder="Nama" required />
            </div>
            <div class="col-md-3">
              <input type="email" name="email" class="form-control" placeholder="Email" required />
            </div>
            <div class="col-md-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required />
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-success w-100">Tambah</button>
            </div>
          </form>
        </div>

        <!-- Tabel User -->
        <div class="table-responsive">
          <table class="table table-striped align-middle" id="userTable">
            <thead class="table-light">
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Registered at</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr data-id="<?= htmlspecialchars($row['id']) ?>">
                  <td><?= htmlspecialchars($row['name']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td><?= htmlspecialchars($row['registered_at']) ?></td>
                  <td><span class="badge bg-success"><?= htmlspecialchars(ucfirst($row['status'])) ?></span></td>
                  <td>
                    <button class="btn btn-sm btn-danger delete-user" data-id="<?= htmlspecialchars($row['id']) ?>"><i class="bi bi-trash"></i></button>
                  </td>
                </tr>
              <?php endwhile; ?>
              <?php if (mysqli_num_rows($result) == 0) : ?>
                <tr>
                  <td colspan="6" class="text-center">No users found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleAddUserForm() {
      const form = document.getElementById('addUserForm');
      form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }

    document.getElementById("addUserFormElement").addEventListener("submit", async function(e) {
      e.preventDefault();

      const name = this.name.value.trim();
      const email = this.email.value.trim();
      const status = 'active';
      const registered_at = new Date().toISOString().slice(0, 10);
      const password = this.password.value.trim();

      // Kirim data ke backend
      const response = await fetch("/forms/add_user.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&status=${status}&registered_at=${registered_at}=&password=${encodeURIComponent(password)}`
      });

      const result = await response.text();

      if (response.ok && !isNaN(result.trim())) {
        const newUserId = result.trim();
        const tableBody = document.querySelector("#userTable tbody");

        const newRow = `
          <tr data-id="${newUserId}">
            <td>${name}</td>
            <td>${email}</td>
            <td>${registered_at}</td>
            <td><span class="badge bg-success">${status.charAt(0).toUpperCase() + status.slice(1)}</span></td>
            <td>
              <button class="btn btn-sm btn-danger delete-user" data-id="${newUserId}"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        `;
        tableBody.insertAdjacentHTML("beforeend", newRow);
        this.reset();
        toggleAddUserForm();
      } else {
        alert("Gagal menambahkan user: " + result);
      }
    });

    // Event delete user
    document.addEventListener('click', async function(e) {
      if (e.target.closest('.delete-user')) {
        const button = e.target.closest('.delete-user');
        const userId = button.getAttribute('data-id');

        if (confirm("Yakin mau hapus user ini?")) {
          const response = await fetch("/forms/hapus_user.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${encodeURIComponent(userId)}`
          });

          const result = await response.text();

          if (result.trim() === "success") {
            const row = button.closest('tr');
            row.remove();
          } else {
            alert("Gagal menghapus user: " + result);
          }
        }
      }
    });
  </script>
</body>

</html>
