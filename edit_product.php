<?php
include 'config.php';
include 'header.php';
// Mendapatkan id produk yang ingin diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = "UPDATE products SET name='$name', description='$description', price='$price',
image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE products SET name='$name', description='$description', price='$price'
WHERE id=$id";
    }
    if ($conn->query($sql) === TRUE) {
        echo "<div>Produk berhasil diperbarui</div>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <label for="name">Nama Produk:</label><br>
    <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>"
        required><br><br>
    <label for="description">Deskripsi Produk:</label><br>
    <textarea id="description" name="description" required><?php echo $product['description'];
                                                            ?></textarea><br><br>
    <label for="price">Harga Produk:</label><br>
    <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>"
        required><br><br>
    <label for="image">Gambar Produk:</label><br>
    <input type="file" id="image" name="image"><br><br>
    <div class="form-actions">
        <input type="submit" name="submit" value="Perbarui Produk">
        <a href="view_products.php" class="btn-view">View</a>
    </div>
</form>

<?php include 'footer.php' ?>