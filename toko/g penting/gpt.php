lakukan konfigurasi kode berdasarkan database merch_toko CREATE TABLE payment_methods (
id_payment_method INT AUTO_INCREMENT PRIMARY KEY,
method_name VARCHAR(100),
description TEXT
);

CREATE TABLE shipping_methods (
id_shipping_method INT AUTO_INCREMENT PRIMARY KEY,
method_name VARCHAR(100),
description TEXT,
cost DECIMAL(10, 2),
estimated_delivery_time VARCHAR(50)
);

CREATE TABLE orders (
id_order INT AUTO_INCREMENT PRIMARY KEY,
id_customer INT,
order_date DATETIME,
shipping_address VARCHAR(255),
shipping_method_id INT,
payment_method_id INT,
total_amount DECIMAL(10, 2),
order_status VARCHAR(50),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (id_customer) REFERENCES customers(id_customer),
FOREIGN KEY (shipping_method_id) REFERENCES shipping_methods(id_shipping_method),
FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id_payment_method)
);

CREATE TABLE order_items (
id_order_item INT AUTO_INCREMENT PRIMARY KEY,
id_order INT,
id_product INT,
product_name VARCHAR(255),
quantity INT,
price DECIMAL(10, 2),
total_price DECIMAL(10, 2),
FOREIGN KEY (id_order) REFERENCES orders(id_order),
FOREIGN KEY (id_product) REFERENCES products(id_product),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
id_product INT AUTO_INCREMENT PRIMARY KEY,
product_name VARCHAR(255),
description TEXT,
category VARCHAR(255),
price DECIMAL(10, 2),
stock INT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE cart_items (
id_cart_item INT AUTO_INCREMENT PRIMARY KEY
id_product INT,
product_name VARCHAR(255),
quantity INT,
price DECIMAL(10, 2),
total_price DECIMAL(10, 2),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
FOREIGN KEY (id_product) REFERENCES products(id_product)
);
CREATE TABLE customers (
id_customer INT AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(50),
last_name VARCHAR(50),
email VARCHAR(100),
phone VARCHAR(20),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

koneksi.php <?php
$server = "localhost";
$user = "root";
$password = "";
$nama_database = "toko_online";
$conn = mysqli_connect($server, $user, $password, $nama_database);
if(!$conn){
 die("gagal terhubung dengan database: " .mysqli_connect_error());
}
?>
header.php <?php
include 'add_to_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - K-POP MERCH</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet"/>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">K-POP MERCH</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                                <li><a class="dropdown-item" href="#!">Albums</a></li>
                            </ul>
                        </li>
                    </ul>
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="max-width: 13rem;">
                        <button class="btn" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                        <div>
php
Copy code
                    <?php
                    // Query untuk mengambil jumlah total barang di keranjang
                    $queryTotalCart = "SELECT SUM(quantity_barang) AS total FROM keranjang";
                    $resultTotalCart = mysqli_query($conn, $queryTotalCart);
                    $rowTotalCart = mysqli_fetch_assoc($resultTotalCart);
                    $total_barang_cart = $rowTotalCart['total'];
                    ?>

                    <div class="badge bg-dark text-white ms-1 rounded-pill position-absolute" style="bottom: 1.8rem; right: 11.5rem;">
                    <?php echo $total_barang_cart; ?></div>
                    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#add_to_cart" aria-controls="offcanvasExample" style="position: relative;">
                        <i class="bi bi-cart-fill mx-auto"></i>
                        <!-- <div class="badge text-dark ms-1 rounded-pill position-absolute" style="bottom: o.5rem; left: 1rem;">1323</div> -->
                        <!-- <span class="badge  text-dark rounded-pill position-absolute"style="right: 1.5rem; bottom: 1rem;">0</span> -->
                    </button>
                    </div>
                    <!-- <button class="btn" type="button">
                        <i class="bi-heart-fill"></i>
                    </button> -->
                    <button class="btn" type="button">
                        <i class="bi-person-fill"></i>
                    </button>
            </div>
        </div>
    </nav>
    index.php <?php
// Melakukan koneksi database
include "koneksi.php";
$conn = mysqli_connect("localhost","root","","toko_online");
// Mengambil data dari database
$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id_barang ASC");

include 'header.php';
include 'add_to_cart.php';
?>
<!-- carousel -->
<header>
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-inner">
<div class="carousel-item active">
<img src="slide_show/nayeon 2nd mini album ss.jpg" class="d-block w-100" alt="Nayeon 2nd mini album">
</div>
<div class="carousel-item">
<img src="slide_show/Red-_Velvet_Cosmic__-_- ss.jpg" class="d-block w-100" alt="Red velvet Cosmic">
</div>
<div class="carousel-item">
<img src="slide_show/Supernatural__-_- ss.jpg" class="d-block w-100" alt="New jeans Supernatural">
</div>
<div class="carousel-item">
<img src="slide_show/TWS-2nd-Mini-Album-_SUMMER-BEAT___-_- ss.jpg" class="d-block w-100" alt="TWS Summer beat">
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

php
Copy code
    <!-- Section-->
    <section class="py-5">

        <div class="container">
                <div class="container-fluid">
                <h2 class="text-center fw-bolder">BEST PRODUCT</h2>
                </div>
            </div>
    <!-- Section-->

    <!-- Section Product-->
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php while($data = mysqli_fetch_array($query)) {?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <?php
                        // Assuming your image filenames are stored in the database
                        $gambar_path = "gambar/" . $data['gambar']; // Adjust the folder path as needed
                        ?>
                        <img class="card-img-top" src="<?php echo $gambar_path; ?>" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <a class="nav-link" href="detail_barang.php?id=<?php echo $data['id_barang']; ?>">
                                    <h5 class="fw-bolder"><?php echo $data['nama_barang']; ?></h5></a>
                                <!-- Product price-->
                                <span>Rp<?php echo number_format($data['harga'], 0, ',', '.'); ?></span>
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
                                    <form method="post" action="add_to_cart.php">
                                        <input type="hidden" name="id_keranjang" value="<?php echo $data['id_barang'];?>">
                                        <input type="hidden" name="nama_barang" value="<?php echo $data['nama_barang']; ?>">
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
add_to_cart.php <?php
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
php
Copy code
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
update_cart.php <?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id_keranjang = $_POST['id_keranjang'];
$quantity_barang = $_POST['quantity_barang'];

php
Copy code
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
detail_barang.php <?php
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
php
Copy code
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