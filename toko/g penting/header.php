<?php
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
        