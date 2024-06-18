<?php
include 'koneksi.php';
include 'cart_add.php';
include 'search.php';

// Query to get the total quantity of items in the cart
$queryTotalCart = "SELECT SUM(quantity) AS total FROM cart_items";
$resultTotalCart = mysqli_query($conn, $queryTotalCart);
$rowTotalCart = mysqli_fetch_assoc($resultTotalCart);
$total_barang_cart = isset($rowTotalCart['total']) ? $rowTotalCart['total'] : 0;
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
    <link href="../css/styles.css" rel="stylesheet">
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
                        <li><a class="dropdown-item" href="albums.php">Albums</a></li>
                    </ul>
                </li>
            </ul>
            <!-- <form class="d-flex"> -->
                <!-- <a class="nav-link" href="search.php"></a>

                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="max-width: 13rem;">
                <button class="btn" type="button">
                    <i class="bi bi-search"></i>
                </button> -->

            <!-- search -->
            <div class="d-flex align-items-center">
                <button class="btn me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#search" aria-controls="offcanvasSearch" style="position: relative;">
                    <i class="bi bi-search"></i>   
                </button>
            </div>
            <!-- cart icon -->
            <div class="d-flex align-items-center">
                <div class="badge bg-dark text-white ms-1 rounded-pill position-absolute" style="bottom: 1.8rem; right: 12rem;">
                        <?php echo $total_barang_cart; ?></div>
                        <button class="btn me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#add_to_cart" aria-controls="offcanvasExample" style="position: relative;">
                            <i class="bi bi-cart-fill mx-auto"></i>
                <!-- <button class="btn" type="button">
                    <i class="bi bi-heart-fill"></i>
                </button> -->

                <!-- profile -->
                <button class="btn" type="button">
                    <i class="bi bi-person-fill"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
