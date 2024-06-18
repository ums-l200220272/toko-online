<?php
// Melakukan koneksi database
include "koneksi.php";
$conn = mysqli_connect("localhost","root","","toko_online");
// Mengambil data dari database
$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id_barang ASC");

include 'header.php';
include 'add_to_cart.php';
?>

<?php
// Koneksi ke database
include "koneksi.php";

// Cek apakah ada parameter ID barang yang dikirimkan
if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Query untuk mengambil data barang berdasarkan ID
    $query = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = $id_barang");

    // Memeriksa apakah data ditemukan
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);

        // Simpan informasi barang ke dalam variabel
        $nama_barang = $data['nama_barang'];
        $harga = $data['harga'];
        $keterangan_barang = $data['keterangan_barang'];
        $gambar_path = "gambar/" . $data['gambar']; // Sesuaikan path gambar dengan struktur Anda
    } else {
        // Jika barang tidak ditemukan, bisa ditangani di sini
        echo "Produk tidak ditemukan.";
        exit; // Keluar dari script jika produk tidak ditemukan
    }
} else {
    // Jika tidak ada parameter ID yang dikirimkan, bisa ditangani di sini
    echo "ID barang tidak ditemukan.";
    exit; // Keluar dari script jika ID barang tidak ditemukan
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
                    <h1 class="display-5 fw-bolder"><?php echo $nama_barang; ?></h1>
                    <div class="fs-5 mb-4">
                        <span>Rp.<?php echo number_format($harga, 2); ?></span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="me-2">Quantity:</h5>
                        <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 4rem;" />

                            <form method="post" action="add_to_cart.php">
                            <input type="hidden" name="id_keranjang" value="<?php echo $data['id_barang'];?>">
                            <input type="hidden" name="nama_barang" value="<?php echo $data['nama_barang']; ?>">
                            <button class="btn btn-danger flex-shrink-0" type="button" style="width: 10rem;" name="add_to_cart">
                                <i class="bi-cart-fill me-2"></i>
                                Add to cart
                            </button>
                            </form>

                           
                    </div>
                    <button class="btn btn-light flex-shrink-0" type="button">
                            <i class="bi-heart-fill me-1"></i> Add to wishlist
                        </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Detail product-->
    <section class="py-4 mt-1 bg-light">
            <div class="container px-4 px-lg-5 mt-1">
                <h2 class="fw-bolder mb-4">Details product</h2>
            </div>
            <div class="lead product-description container py-1 px-lg-1 mt-1">
                <p><ul>
                    <?php
                        $keterangan_lines = explode("\n", $keterangan_barang);
                        foreach ($keterangan_lines as $line) {
                            echo "<ul>" . htmlspecialchars($line) . "</ul>";
                        }
                    ?>
                </ul></p>
            </div>
    </section>

        <!-- Related items section-->
        <section class="py-5 ">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Fancy Product</h5>
                                    <!-- Product price-->
                                    $40.00 - $80.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Special Item</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$20.00</span>
                                    $18.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- fav badge-->
                            <div class="text-center badge text-black position-absolute" style="top: 0.2rem; right: 0.2rem">
                                        <!-- Icon and link to add to wishlist -->
                                        <a href="#" class="btn mt-auto">
                                            <i class="bi bi-heart "></i>
                                        </a>
                                    </div>
                            <!-- <div class="badge text-black position-absolute" style="top: 0.5rem; right: 0.5rem"><i class="bi bi-heart me-1"></i></div> -->
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Sale Item</h5>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$50.00</span>
                                    $25.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Popular Item</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    $40.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- Footer-->
<?php include 'footer.php';?>
