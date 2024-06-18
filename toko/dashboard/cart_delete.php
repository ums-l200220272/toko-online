<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_item'])) {
    $id_cart_item = $_POST['id_cart_item'];

    $queryDelete = "DELETE FROM cart_items WHERE id_cart_item = '$id_cart_item'";
    $resultDelete = mysqli_query($conn, $queryDelete);

    if ($resultDelete) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Gagal menghapus item dari cart.";
    }
}
?>
