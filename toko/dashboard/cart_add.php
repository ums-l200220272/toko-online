<?php
// Melakukan koneksi database
include "koneksi.php";
$conn = mysqli_connect("localhost","root","","merch_toko");
// Mengambil data dari database
$query = mysqli_query($conn, "SELECT * FROM products ORDER BY id_product ASC");

?>

<?php
include 'koneksi.php';
include 'cart_update.php';
include 'cart_delete.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $id_product = $_POST['id_product'];
    $product_name = $_POST['product_name'];

    // Fetch the product price from the database
    $queryProduct = "SELECT price FROM products WHERE id_product = '$id_product'";
    $resultProduct = mysqli_query($conn, $queryProduct);
    $product = mysqli_fetch_assoc($resultProduct);
    $price = $product['price'];

    // Periksa apakah product sudah ada di cart
    $queryCheck = "SELECT * FROM cart_items WHERE id_product = '$id_product'";
    $resultCheck = mysqli_query($conn, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        // Jika product sudah ada, update quantity
        $row = mysqli_fetch_assoc($resultCheck);
        $id_cart_item = $row['id_cart_item'];
        $newQuantity = $row['quantity'] + 1; // Tambah quantity
        $newTotalPrice = $newQuantity * $price;

        $queryUpdate = "UPDATE cart_items SET quantity = '$newQuantity', total_price = '$newTotalPrice', updated_at = CURRENT_TIMESTAMP  WHERE id_product = $id_product";
        $resultUpdate = mysqli_query($conn, $queryUpdate);

        if ($resultUpdate) {
            // Hitung jumlah total product di cart
            $queryTotal = "SELECT SUM(quantity) AS total FROM cart_items";
            $resultTotal = mysqli_query($conn, $queryTotal);
            $rowTotal = mysqli_fetch_assoc($resultTotal);
            $total_product = $rowTotal['total'];

            // Simpan total product di session atau cookie untuk digunakan di halaman lain

            // Redirect kembali ke halaman sebelumnya atau halaman cart
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Gagal memperbarui quantity product di cart.";
        }
    } else {
        // Jika product belum ada, masukkan baru ke cart
        $quantity = 1;
        $total_price = $quantity * $price;

        $queryInsert = "INSERT INTO cart_items (id_product, product_name, quantity, price, total_price) VALUES ('$id_product', '$product_name', '$quantity', '$price', '$total_price')";
        $resultInsert = mysqli_query($conn, $queryInsert);

        if ($resultInsert) {
            // Hitung jumlah total product di cart
            $queryTotal = "SELECT SUM(quantity) AS total FROM cart_items";
            $resultTotal = mysqli_query($conn, $queryTotal);
            $rowTotal = mysqli_fetch_assoc($resultTotal);
            $total_product = $rowTotal['total'];

            // Simpan total product di session atau cookie untuk digunakan di halaman lain

            // Redirect kembali ke halaman sebelumnya atau halaman cart
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Gagal menambahkan product ke cart.";
        }
    }
}
?>

<?php
include 'koneksi.php';

// Query untuk mengambil semua product di cart dan menggabungkannya dengan tabel product
$queryCart = "SELECT cr.id_cart_item, cr.id_product, cr.product_name, cr.quantity, cr.total_price, pd.pict AS pict, pd.price AS price
              FROM cart_items cr 
              JOIN products pd ON cr.id_product = pd.id_product
              ORDER BY cr.created_at ASC";
$resultCart = mysqli_query($conn, $queryCart);

// Inisialisasi total harga
$totalHarga = 0;
?>

<div class="offcanvas offcanvas-end" style="width: 400px;" tabindex="-1" id="add_to_cart" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Shopping Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php while ($row = mysqli_fetch_assoc($resultCart)) { 
            // Hitung total harga
            $totalHarga += $row['price'] * $row['quantity'];
        ?>
            <div class="d-flex mb-4">
                <img src="../gambar/<?php echo $row['pict']; ?>" alt="Product Image" class="img-thumbnail" style="max-width: 80px; height: auto;">
                <div class="ms-3">
                    <h6 class="mb-0"><?php echo $row['product_name']; ?></h6>
                    
                    <div class="d-flex align-items-center mt-1">
                        <input 
                            class="form-control text-center me-1 quantity-input" 
                            type="number" 
                            value="<?php echo $row['quantity']; ?>" 
                            style="max-width: 4rem;" 
                            data-id="<?php echo $row['id_cart_item']; ?>" 
                            data-name="<?php echo $row['product_name']; ?>"
                        />
                        <form method="post" action="cart_add.php">
                            <input type="hidden" name="id_cart_item" value="<?php echo $row['id_cart_item']; ?>">
                            <button class="btn btn-danger ms-1 mt-3" type="submit" name="delete_item">
                                <i class="bi bi-trash"></i> 
                            </button>
                        </form>
                        
                    </div>
                    <div >Rp<?php echo number_format($row['total_price'], 0, ',', '.'); ?></div>
                </div>
            </div>
        <?php } ?>

        <!-- Total harga dan tombol Checkout -->
        <!-- <div class="total-checkout" style="sticky: fixed; bottom: 0; background: #fff; padding: 10px; border-top: 2px solid #ddd; width: 365px">
            <h5>Total: Rp<?php echo number_format($totalHarga, 0, ',', '.'); ?></h5>
            <div class="text-end">
                <button class="btn btn-primary" style="width: 100%;">Checkout</button>
            </div>
        </div> -->
        <!-- Total harga dan tombol Checkout -->
        <!-- <div class="mt-4" style="position: sticky; bottom: 0; background: #fff; padding-top: 10px;">
            <h5>Total: Rp<?php echo number_format($totalHarga, 0, ',', '.'); ?></h5>
            <div class="text-end">
                <button class="btn btn-primary" style="width: 100%;">Checkout</button>
            </div>
        </div> -->
        <!-- Total harga dan tombol Checkout -->
        <div class="mt-4" style="position: sticky; bottom: 0; background: #fff; padding-top: 10px; padding-bottom: 20px;box-length: 20px;">
            <h5>Total: Rp<?php echo number_format($totalHarga, 0, ',', '.'); ?></h5>
            <div class="text-end">
                <button class="btn btn-primary" style="width: 100%;">Checkout</button>
            </div>
            
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', function() {
        const idcart = this.getAttribute('data-id');
        const quantityproduct = this.value;

        if (quantityproduct < 1) {
            this.value = 1;
            return;
        }

        // Mengirim permintaan AJAX untuk memperbarui quantity
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'cart_update.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Quantity updated successfully');
                location.reload(); // Refresh halaman untuk memperbarui total harga
            }
        };
        xhr.send('id_cart_item=' + idcart + '&quantity=' + quantityproduct);
    });
});
</script>
