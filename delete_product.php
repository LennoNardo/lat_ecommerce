<?php
include 'config.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Hapus gambar produk
    $sql = "SELECT image FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
    unlink("uploads/" . $product['image']); // Menghapus gambar dari folder uploads
    // Hapus produk dari database
    $sql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Produk berhasil dihapus";
    } else {
        echo "Error: " . $conn->error;
    }
}
