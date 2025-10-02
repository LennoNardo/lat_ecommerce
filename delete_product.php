<?php
include 'config.php';
include 'header.php';
$message = "";
$success = false;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Cek data produk
    $sql = "SELECT image FROM products WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        
        // Hapus gambar dari folder uploads
        if (!empty($product['image']) && file_exists("uploads/" . $product['image'])) {
            unlink("uploads/" . $product['image']);
        }

        // Hapus produk dari database
        $sql = "DELETE FROM products WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $message = "Produk berhasil dihapus ✅";
            $success = true;
        } else {
            $message = "Terjadi kesalahan: " . $conn->error;
        }
    } else {
        $message = "Produk tidak ditemukan!";
    }
}
?>
<div class="container-delete">
    <h2>Status Penghapusan Produk</h2>
    <div class="msg <?php echo $success ? 'success' : 'error'; ?>">
        <?php echo $message; ?>
    </div>
    <a href="view_products.php" class="btn-delete-page">⬅ Kembali ke Daftar Produk</a>
</div>
<?php include 'footer.php' ?>

