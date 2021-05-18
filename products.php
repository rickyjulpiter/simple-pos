<!DOCTYPE html>
<html lang="en">

<?php

include './template/head.php';
include './config.php';

if (isset($_POST['btn-tambah-produk'])) {
    $nama_produk = $_POST['nama-produk'];
    $harga_jual_langsung = clearSpecialCharacter($_POST['harga-jual-langsung']);
    $harga_jual_delivery =  clearSpecialCharacter($_POST['harga-jual-delivery']);
    $kategori = $_POST['kategori'];

    $gambar_produk = $_FILES['gambar-produk']['name'];
    $gambar_produk_temp = $_FILES['gambar-produk']['tmp_name'];

    $extension_gambar = pathinfo($gambar_produk, PATHINFO_EXTENSION);
    $nama_gambar = clearSpecialCharacter($nama_produk) . "_" . time() . "." . $extension_gambar;
    $dirUpload = "assets/image/product/";

    $query = "INSERT INTO products (nama, harga_jual_langsung, harga_jual_pengantaran, kategori, gambar) VALUES('$nama_produk', '$harga_jual_langsung', '$harga_jual_delivery', '$kategori', '$nama_gambar') ";
    $sql = $pdo->prepare($query);

    if (move_uploaded_file($gambar_produk_temp, $dirUpload . $nama_gambar) && $sql->execute()) {
        // proses upload berhasil
    }
}
?>

<body>
    <?php include './template/header.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php include './template/navbar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <a class="h2">Daftar Produk</a>
                    <button type="button" class="h5 btn btn-secondary btn-sm text-white" data-toggle="modal"
                        data-target="#tambahproduk"> <i class="fa fa-plus"> </i> Tambah Produk</button>

                </div>
                <!-- data produk start -->
                <div class="row">
                    <?php
                    $data_product = $pdo->query("SELECT * FROM products WHERE status = 1 ORDER BY id DESC");
                    while ($data = $data_product->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="col-md-3 mb-3">
                        <a href="" class="">
                            <div class="card">
                                <img class="card-img-top" src="./assets/image/product/<?= $data['gambar'] ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="card-title"><?= $data['nama'] ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p
                                                class="card-title float-right text-success font-weight-bold product-detail">
                                                <span><?= rupiah($data['harga_jual_langsung']) ?></span>
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <small class="badge bg-info float-right"><?= $data['kategori'] ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php }
                    ?>
                </div>
                <!-- data produk end -->
            </main>
            <!-- Modal -->
            <div class="modal fade bd-example-modal-lg" id="tambahproduk" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                            <button type="button" class="close btn btn-secondary" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-add-product" method="POST" enctype="multipart/form-data">
                                <div class="form-group row mb-1">
                                    <label for="namaproduk" class="col-sm-4 col-form-label">Nama Produk</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nama-produk" class="form-control" id="namaproduk"
                                            placeholder="Nama Produk">
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Harga Jual Langsung</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="rupiah" name="harga-jual-langsung" min="0"
                                            class="form-control" placeholder="Harga Jual Langsung">
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Harga Jual Delivery</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="rupiah2" name="harga-jual-delivery" min="0"
                                            class="form-control" placeholder="Harga Jual Pengantaran">
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Kategori</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="kategori" aria-label="Default select example">
                                            <option selected="true" disabled="disabled">Pilih Kategori</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Gambar Produk</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="gambar-produk" class="form-control" id="customFile" />
                                    </div>
                                </div>
                                <button type="submit" name="btn-tambah-produk"
                                    class="btn btn-success float-right mt-2">Tambah Produk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
<?php include './template/script.php' ?>

<script>
$(document).ready(function() {
    $('#btn_tampil').click(function() {
        $('#tampil').load('demo.php');
    });
});
</script>

<script type="text/javascript">
let rupiah = document.getElementById('rupiah');
let rupiah2 = document.getElementById('rupiah2');

rupiah.addEventListener('keyup', function(e) {
    rupiah.value = formatRupiah(this.value, 'Rp. ');
});
rupiah2.addEventListener('keyup', function(e) {
    rupiah2.value = formatRupiah(this.value, 'Rp. ');
});
</script>

<script>
//add product process

$("modal-add-product").submit(function(event) {
    event.preventDefault();

    console.log("tombol-diklik")
})
</script>

</html>