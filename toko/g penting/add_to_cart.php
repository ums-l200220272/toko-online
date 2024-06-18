<?php
// Melakukan koneksi database
include "koneksi.php";
$conn = mysqli_connect("localhost","root","","toko_online");
// Mengambil data dari database
$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id_barang ASC");

?>

<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $id_keranjang = $_POST['id_keranjang'];
    $nama_barang = $_POST['nama_barang'];

    // Periksa apakah barang sudah ada di keranjang
    $queryCheck = "SELECT * FROM keranjang WHERE id_barang = '$id_keranjang'";
    $resultCheck = mysqli_query($conn, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        // Jika barang sudah ada, update quantity
        $row = mysqli_fetch_assoc($resultCheck);
        $id_keranjang = $row['id_keranjang'];
        $quantity_barang = $row['quantity_barang'] + 1; // Tambah quantity

        $queryUpdate = "UPDATE keranjang SET quantity_barang = $quantity_barang WHERE id_keranjang = $id_keranjang";
        $resultUpdate = mysqli_query($conn, $queryUpdate);

        if ($resultUpdate) {
            // Hitung jumlah total barang di keranjang
            $queryTotal = "SELECT SUM(quantity_barang) AS total FROM keranjang";
            $resultTotal = mysqli_query($conn, $queryTotal);
            $rowTotal = mysqli_fetch_assoc($resultTotal);
            $total_barang = $rowTotal['total'];

            // Simpan total barang di session atau cookie untuk digunakan di halaman lain

            // Redirect kembali ke halaman sebelumnya atau halaman keranjang
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Gagal memperbarui quantity barang di keranjang.";
        }
    } else {
        // Jika barang belum ada, masukkan baru ke keranjang
        $queryInsert = "INSERT INTO keranjang (id_barang, nama_barang, quantity_barang) VALUES ('$id_keranjang', '$nama_barang', 1)";
        $resultInsert = mysqli_query($conn, $queryInsert);

        if ($resultInsert) {
            // Hitung jumlah total barang di keranjang
            $queryTotal = "SELECT SUM(quantity_barang) AS total FROM keranjang";
            $resultTotal = mysqli_query($conn, $queryTotal);
            $rowTotal = mysqli_fetch_assoc($resultTotal);
            $total_barang = $rowTotal['total'];

            // Simpan total barang di session atau cookie untuk digunakan di halaman lain

            // Redirect kembali ke halaman sebelumnya atau halaman keranjang
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Gagal menambahkan barang ke keranjang.";
        }
    }
}
?>


<?php
include 'koneksi.php';

// Query untuk mengambil semua barang di keranjang dan menggabungkannya dengan tabel barang
$queryCart = "SELECT kr.id_keranjang, kr.id_barang, kr.nama_barang, kr.quantity_barang, br.gambar AS gambar_barang, br.harga AS harga_barang 
              FROM keranjang kr 
              JOIN barang br ON kr.id_barang = br.id_barang 
              ORDER BY kr.id_barang ASC";
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
            $totalHarga += $row['harga_barang'] * $row['quantity_barang'];
        ?>
            <div class="d-flex mb-4">
                <img src="gambar/<?php echo $row['gambar_barang']; ?>" alt="Product Image" class="img-thumbnail" style="max-width: 80px; height: auto;">
                <div class="ms-3">
                    <h6 class="mb-0"><?php echo $row['nama_barang']; ?></h6>
                    <div>Rp<?php echo number_format($row['harga_barang'], 0, ',', '.'); ?></div>
                    <div class="d-flex align-items-center">
                        <input 
                            class="form-control text-center me-3 quantity-input" 
                            type="number" 
                            value="<?php echo $row['quantity_barang']; ?>" 
                            style="max-width: 4rem;" 
                            data-id="<?php echo $row['id_keranjang']; ?>" 
                            data-name="<?php echo $row['nama_barang']; ?>"
                        />
                        <a href="remove_from_cart.php?id=<?php echo $row['id_keranjang']; ?>" class="btn btn-danger btn-sm ms-2">Remove</a>
                    </div>
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
        const idKeranjang = this.getAttribute('data-id');
        const quantityBarang = this.value;

        if (quantityBarang < 1) {
            this.value = 1;
            return;
        }

        // Mengirim permintaan AJAX untuk memperbarui quantity
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Quantity updated successfully');
                location.reload(); // Refresh halaman untuk memperbarui total harga
            }
        };
        xhr.send('id_keranjang=' + idKeranjang + '&quantity_barang=' + quantityBarang);
    });
});
</script>





<!-- <?php
include 'koneksi.php';

// Query untuk mengambil semua barang di keranjang dan menggabungkannya dengan tabel barang
$queryCart = "SELECT kr.id_keranjang, kr.id_barang, kr.nama_barang, kr.quantity_barang, br.gambar AS gambar_barang, br.harga AS harga_barang 
              FROM keranjang kr 
              JOIN barang br ON kr.id_barang = br.id_barang 
              ORDER BY kr.id_barang ASC";
$resultCart = mysqli_query($conn, $queryCart);
?>

<div class="offcanvas offcanvas-end" style="width: 400px;" tabindex="-1" id="add_to_cart" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Shopping Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php while ($row = mysqli_fetch_assoc($resultCart)) { ?>
            <div class="d-flex mb-4">
                <img src="gambar/<?php echo $row['gambar_barang']; ?>" alt="Product Image" class="img-thumbnail" style="max-width: 80px; height: auto;">
                <div class="ms-3">
                    <h6 class="mb-0"><?php echo $row['nama_barang']; ?></h6>
                    <div>Rp<?php echo number_format($row['harga_barang'], 0, ',', '.'); ?></div>
                    <div class="d-flex align-items-center">
                        <input class="form-control text-center me-3" type="number" value="<?php echo $row['quantity_barang']; ?>" style="max-width: 4rem;" />
                        <a href="remove_from_cart.php?id=<?php echo $row['id_keranjang']; ?>" class="btn btn-danger btn-sm">Remove</a>
                    </div>
                </div>
            </div>
        <?php } ?>

        Tombol Checkout
        <div class="text-end">
            <button class="btn btn-primary mt-3">Checkout</button>
        </div>
    </div>
</div> -->
