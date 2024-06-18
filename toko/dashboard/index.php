<?php
// Melakukan koneksi database
include "koneksi.php";
$conn = mysqli_connect("localhost", "root", "", "merch_toko");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Mengambil data dari database
$query = mysqli_query($conn, "SELECT * FROM products ORDER BY id_product ASC");

// Check if the query was successful
if (!$query) {
    die("Query failed: " . mysqli_error($conn));
}

include 'header.php';
include 'cart_add.php';
?>      
        <!-- carousel -->
        <header>
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../slide_show/nayeon 2nd mini album ss.jpg" class="d-block w-100" alt="Nayeon 2nd mini album">
                    </div>
                    <div class="carousel-item">
                        <img src="../slide_show/Red-_Velvet_Cosmic__-_- ss.jpg" class="d-block w-100" alt="Red velvet Cosmic">
                    </div>
                    <div class="carousel-item">
                        <img src="../slide_show/Supernatural__-_- ss.jpg" class="d-block w-100" alt="New jeans Supernatural">
                    </div>
                    <div class="carousel-item">
                        <img src="../slide_show/TWS-2nd-Mini-Album-_SUMMER-BEAT___-_- ss.jpg" class="d-block w-100" alt="TWS Summer beat">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </header>

        <!-- Section-->
        <section class="py-5">
            <div class="container">
                <div class="container-fluid">
                    <h2 class="text-center fw-bolder">BEST PRODUCT</h2>
                </div>
            </div>

            <!-- Section Product-->
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php while ($data = mysqli_fetch_array($query)) { ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <?php
                                // Assuming your image filenames are stored in the database
                                $gambar_path = "../gambar/" . $data['pict'];  // Adjust the folder path as needed
                                ?>
                                <img class="card-img-top" src="<?php echo $gambar_path; ?>" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <a class="nav-link" href="detail_product.php?id=<?php echo $data['id_product']; ?>">
                                            <h5 class="fw-bolder"><?php echo $data['product_name']; ?></h5>
                                        </a>
                                        <!-- Product price-->
                                        <span>Rp<?php echo number_format($data['price'], 0, ',', '.'); ?></span>
                                    </div>
                                </div>
                                <!-- Product favorite actions-->
                                <!-- <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View</a></div>
                                </div> -->
                                <!-- fav badge--> 
                              
                                <!-- add to cart -->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="d-flex justify-content-center">
                                        <!-- cart -->
                                        <div class="text-center me-2">
                                            <!-- Icon and link to add to cart -->
                                            <form method="post" action="cart_add.php">
                                                <input type="hidden" name="id_product" value="<?php echo $data['id_product']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo $data['product_name']; ?>">
                                                <button class="btn btn-dark mt-auto" type="submit" name="add_to_cart">
                                                    <i class="bi bi-cart me-2"></i>
                                                    Add to cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

<!-- Footer-->
<?php include 'footer.php';?>
