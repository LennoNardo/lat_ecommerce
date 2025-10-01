<?php

include 'config.php';
include 'header.php';

if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

$message = '';
$message_class = '';

if (isset($_POST['submit'])) {
    $name = trim(htmlspecialchars($_POST['name']));
    $description = trim(htmlspecialchars($_POST['description']));
    $price = floatval($_POST['price']);

    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $target = "uploads/" . basename($image);

    if (empty($name) || empty($description) || $price <= 0 || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $message = "Harap lengkapi semua bidang dengan benar.";
        $message_class = "error";
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $image);

        if ($stmt->execute()) {
            if (move_uploaded_file($tmp_name, $target)) {
                $message = "Produk " . $name . " berhasil ditambahkan dan gambar diunggah.";
                $message_class = "success";
            } else {
                $message = "Produk berhasil ditambahkan, tetapi gambar gagal diunggah. Cek izin folder `uploads/`.";
                $message_class = "error";
            }
        } else {
            $message = "Error saat menyimpan data: " . $stmt->error;
            $message_class = "error";
        }

        $stmt->close();
    }
}
?>

<?php if ($message): ?>
    <div class="status-message <?php echo $message_class; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div class="form-container">
    <h2>Tambah Produk Sepatu Baru</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Nama Produk:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Deskripsi Produk:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Harga Produk (Rp):</label>
        <input type="number" id="price" name="price" required min="1000">

        <label for="image">Gambar Produk:</label>
        <input type="file" id="image" name="image" required>

        <div class="form-actions">
            <input type="submit" name="submit" value="Tambah Produk">
            <a href="view_products.php" class="btn-view">Lihat Semua Produk</a>
        </div>
    </form>
</div>

<?php include 'footer.php' ?>