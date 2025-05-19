<?php
include '../forms/db.php'; 
$result = mysqli_query($conn, "SELECT * FROM trips");
?>

<h2>Kelola Trip</h2>
<table borde ="1">
    <tr>
        <th>Foto</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Kuota</th>
        <th>Ubah Kuota</th>
        <th>Ubah Foto</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><img src="../images/<?php echo $row['image']; ?>" width="100"></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['kuota']; ?></td>
        <td>
            <form method="POST" action="update_kuota.php">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="number" name="kuota" value="<?php echo $row['kuota']; ?>">
                <button type="submit">Update</button>
            </form>
        </td>
        <td>
            <form method="POST" action="update_foto.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="file" name="image">
                <button type="submit">Ubah</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
