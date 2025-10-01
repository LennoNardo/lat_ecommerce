<?php
include 'config.php';
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    // Menyimpan data ke database
    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name',
'$description', '$price', '$image')";
    if ($conn->query($sql) === TRUE) {
        echo "Produk berhasil ditambahkan";
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <label for="name">Nama Produk:</label><br>
    <input type="text" id="name" name="name" required><br><br>
    <label for="description">Deskripsi Produk:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>
    <label for="price">Harga Produk:</label><br>
    <input type="number" id="price" name="price" required><br><br>
    <label for="image">Gambar Produk:</label><br>
    <input type="file" id="image" name="image" required><br><br>
    <input type="submit" name="submit" value="Tambah Produk">
</form>