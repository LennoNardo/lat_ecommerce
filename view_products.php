<?php
include 'config.php';
include 'header.php';
// Ambil data produk dari database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>


<div class="container">
    <h2>Daftar Produk</h2>
    <a href="add_product.php" class="btn">+ Tambah Produk</a>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
        <tr>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["name"] . "</td>
                <td>" . $row["description"] . "</td>
                <td>Rp " . number_format($row["price"], 0, ',', '.') . "</td>
                <td><img src='uploads/" . $row["image"] . "' width='100'></td>
                <td class='aksi'>
                    <a href='edit_product.php?id=" . $row["id"] . "' class='edit'>Edit</a>
                    <a href='delete_product.php?id=" . $row["id"] . "' class='delete' onclick=\"return confirm('Yakin ingin menghapus produk ini?');\">Delete</a>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>Tidak ada produk</p>";
    }
    ?>
</div>
<?php include 'footer.php'; ?>


