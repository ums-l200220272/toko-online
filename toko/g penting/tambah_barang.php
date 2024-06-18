<?php
// Melakukan koneksi database
include "koneksi.php";
$conn = mysqli_connect("localhost","root","","toko_online");
// Mengambil data dari database
$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id_barang ASC");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin Homepage - K-POP MERCH</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">ADMIN K-POP MERCH</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
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
                    <button class="btn btn-outline-dark mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#tambah_barang">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Barang</button></div> 
                </div>
            </div>
        </nav>

<div class="d-flex">
    <table class="table table-bordered table-padding table-center mt-3 mb-3 mx-5">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th width="30%">Keterangan</th>
            <th width="10%">Kategori</th>
            <th width="10%">Harga</th>
            <th width="5%">Stok</th>
            <th width="10%" colspan="3">Aksi</th>
        </tr>
        <?php
        $nomor = 1;
        while ($data = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo htmlspecialchars($data["nama_barang"]); ?></td>
                <td><?php echo htmlspecialchars($data["keterangan_barang"]); ?></td>
                <td><?php echo htmlspecialchars($data["kategori_barang"]); ?></td>
                <td><?php echo htmlspecialchars($data["harga"]); ?></td>
                <td><?php echo htmlspecialchars($data["stok"]); ?></td>
                <td><button class="btn btn-success btn-sm"><i class="bi bi-search me-1"></i></button></td>
                <td><button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_barang"><i class="bi bi-pencil me-1"><a class="edit" href="edit.php?id=<?php echo $data['id_barang'];?>"></a></i></button></td>
                <td><button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i></button></td>
            </tr>
        <?php } ?>
</table></div>
<!-- Modal Tambah Barang-->
<div class="modal fade" id="tambah_barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        dor
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>