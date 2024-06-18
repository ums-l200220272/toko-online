<?php
// Melakukan koneksi database
include "koneksi.php";
include 'header.php';
include 'cart_add.php';

// Cek apakah ada parameter ID produk yang dikirimkan
if (isset($_GET['id'])) {
    $id_product = $_GET['id'];

    // Query untuk mengambil data produk berdasarkan ID
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id_product = $id_product");

    // Memeriksa apakah data ditemukan
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);

        // Simpan informasi produk ke dalam variabel
        $product_name = $data['product_name'];
        $price = $data['price'];
        $description = $data['description'];
        $category = $data['category'];
        $stock = $data['stock'];
        $created_at = $data['created_at'];
        $updated_at = $data['updated_at'];
        $gambar_path = "../gambar/" . $data['pict']; // Sesuaikan path gambar dengan struktur Anda
    } else {
        // Jika produk tidak ditemukan, bisa ditangani di sini
        echo "Produk tidak ditemukan.";
        exit; // Keluar dari script jika produk tidak ditemukan
    }
} else {
    // Jika tidak ada parameter ID yang dikirimkan, bisa ditangani di sini
    echo "ID produk tidak ditemukan.";
    exit; // Keluar dari script jika ID produk tidak ditemukan
}
?>
<!-- Product section -->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-1">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0" src="<?php echo $gambar_path; ?>" alt="Product Image" />
            </div>
            <div class="col-md-6">
                <h1 class="display-5 fw-bolder"><?php echo $product_name; ?></h1>
                <div class="fs-5 mb-4">
                    <span>Rp.<?php echo number_format($price, 2); ?></span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <h5 class="me-2">Quantity:</h5>
                    <!-- <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 4rem;" /> -->
                    
                    <input 
                            class="form-control text-center me-3 quantity-input" 
                            type="number" 
                            value="<?php echo $row['quantity']; ?>" 
                            style="max-width: 4rem;" 
                            data-id="<?php echo $row['id_cart_item']; ?>" 
                            data-name="<?php echo $row['product_name']; ?>"
                        />

                    <form method="post" action="cart_add.php">
                        <input type="hidden" name="id_product" value="<?php echo $data['id_product'];?>">
                        <input type="hidden" name="product_name" value="<?php echo $data['product_name']; ?>">
                        <button class="btn btn-danger flex-shrink-0 mt-3" type="submit" style="width: 10rem;" name="add_to_cart">
                            <i class="bi-cart-fill me-2 "></i>
                            Add to cart
                        </button>
                    </form>

                </div>
                <!-- <button class="btn btn-light flex-shrink-0" type="button">
                    <i class="bi-heart-fill me-1"></i> Add to wishlist
                </button> -->
            </div>
        </div>
    </div>
</section>

<!-- Detail product -->
<section class="py-4 mt-1 bg-light">
    <div class="container px-4 px-lg-5 mt-1">
        <h2 class="fw-bolder mb-4">Product Details</h2>
    </div>
    <div class="lead product-description container py-1 px-lg-1 mt-1">
        <p><?php echo nl2br(htmlspecialchars($description)); ?></p>
    </div>
</section>


<!-- Footer-->
<?php include 'footer.php';?>