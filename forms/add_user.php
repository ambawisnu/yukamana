<?php
include '../forms/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $status = $_POST['status'];
  $joined_at = $_POST['joined_at']; 

  $sql = "INSERT INTO users (name, email, status, joined_at) VALUES ('$name', '$email', '$status', '$joined_at')";
  if (mysqli_query($conn, $sql)) {
    http_response_code(200); // sukses
  } else {
    http_response_code(500); // error
    echo "Error: " . mysqli_error($conn);
  }
}
?>
