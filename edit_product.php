<?php
include 'config.php';
include 'header.php';
$message = '';
$message_class = '';
$product = null;
// Mendapatkan id produk yang ingin diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}
// Proses update
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    if ($image) {
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        // Update dengan gambar baru
        $sql = "UPDATE products 
                SET name='$name', description='$description', price='$price', image='$image' 
                WHERE id=$id";
    } else {
        // Update tanpa ganti gambar
        $sql = "UPDATE products 
                SET name='$name', description='$description', price='$price' 
                WHERE id=$id";
    }
    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil diperbarui ✅";
        $message_class = "success";
        // Refresh data terbaru
        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $conn->query($sql);
        $product = $result->fetch_assoc();
    } else {
        $message = "Error: " . $conn->error;
        $message_class = "error";
    }
}
?>

<?php if ($message): ?>
    <div class="status-message <?php echo $message_class; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div class="form-container">
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Nama Produk:</label>
        <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>"
            required>
        <label for="description">Deskripsi Produk:</label>

        <textarea id="description" name="description" required><?php echo $product['description']; ?></textarea>

        <label for="price">Harga Produk:</label>
        <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>"
            required>

        <label for="image">Gambar Produk:</label>
        <input type="file" id="image" name="image">

        <?php if (!empty($product['image'])): ?>
            <p>Gambar saat ini:</p>
            <img src="uploads/<?php echo $product['image']; ?>" class="preview-img" alt="Produk">
        <?php endif; ?>

        <div class="form-actions">
            <input type="submit" name="submit" value="Perbarui Produk">
            <a href="view_products.php" class="btn-view">Kembali</a>
        </div>
    </form>
</div>
<?php include 'footer.php' ?>

