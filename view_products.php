<?php
include 'config.php';
// Ambil data produk dari database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1'>
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
 <td>" . $row["price"] . "</td>
 <td><img src='uploads/" . $row["image"] . "' width='100'></td>
 <td>
 <a href='edit_product.php?id=" . $row["id"] . "'>Edit</a> |
 <a href='delete_product.php?id=" . $row["id"] . "'>Delete</a>
 </td>
 </tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada produk";
}
