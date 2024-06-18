<?php
include 'koneksi.php';

$search = '';
$query = false; // Initialize query as false to indicate no search yet
$noResults = false; // Initialize noResults as false to indicate results are available by default

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = mysqli_query($conn, "SELECT * FROM products WHERE product_name LIKE '%$search%' OR category LIKE '%$search%' OR artist LIKE '%$search%' ORDER BY id_product ASC");

    if (mysqli_num_rows($query) == 0) {
        $noResults = true; // Set noResults to true if no matching products are found
    }
}
?>

<div class="offcanvas offcanvas-end" style="width: 400px;" tabindex="-1" id="search" aria-labelledby="offcanvasSearch">
    <div class="offcanvas-header d-flex justify-content-between align-items-center">
        <!-- search bar -->
        <form action="" method="GET" class="d-flex flex-grow-1">
            <input class="form-control me-1" type="search" name="search" placeholder="Search" aria-label="Search" value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
        <button type="button" class="btn-close ms-1 mb-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php if ($query): ?>
            <?php if ($noResults): ?>
                <p>No products found matching your search query.</p>
            <?php else: ?>
                <?php while ($data = mysqli_fetch_array($query)) { ?>
                    <div class="d-flex mb-4">
                        <!-- gambar -->
                        <img src="../gambar/<?php echo $data['pict']; ?>" alt="Product Image" class="img-thumbnail" style="max-width: 80px; height: auto;">
                        <!-- nama dan harga -->
                        <div class="ms-3">
                            <a class="nav-link" href="detail_product.php?id=<?php echo $data['id_product']; ?>">
                                <h6 class="mb-0"><?php echo $data['product_name']; ?></h6>
                            </a>
                            <div>Rp<?php echo number_format($data['price'], 0, ',', '.'); ?></div>
                        </div>
                    </div>
                <?php } ?>
            <?php endif; ?>
        <?php else: ?>
            <p>Please enter a search term to see results.</p>
        <?php endif; ?>
    </div>
</div>