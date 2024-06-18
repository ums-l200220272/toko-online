<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_keranjang = $_POST['id_keranjang'];
    $quantity_barang = $_POST['quantity_barang'];

    // Pastikan quantity minimal 1
    if ($quantity_barang < 1) {
        $quantity_barang = 1;
    }

    // Update quantity di tabel keranjang
    $queryUpdate = "UPDATE keranjang SET quantity_barang = $quantity_barang WHERE id_keranjang = $id_keranjang";
    $resultUpdate = mysqli_query($conn, $queryUpdate);

    if ($resultUpdate) {
        echo "Quantity updated successfully";
    } else {
        echo "Failed to update quantity";
    }
}
?>
