<!DOCTYPE html>
<html lang="en">

<?php

include './template/head.php';
include './config.php';

if (isset($_POST['btn-tambah-varian'])) {
    $nama = $_POST['nama'];
    $harga = clearSpecialCharacter($_POST['harga']);
    $kategori = $_POST['kategori'];

    $gambar = $_FILES['gambar']['name'];
    $gambar_temp = $_FILES['gambar']['tmp_name'];

    $extension_gambar = pathinfo($gambar, PATHINFO_EXTENSION);
    $nama_gambar = clearSpecialCharacter($nama) . "_" . time() . "." . $extension_gambar;
    $dirUpload = "assets/image/varian/";

    $query = "INSERT INTO varian (nama, harga, categories_id, gambar) VALUES('$nama', '$harga', '$kategori', '$nama_gambar') ";
    $sql = $pdo->prepare($query);

    if (move_uploaded_file($gambar_temp, $dirUpload . $nama_gambar) && $sql->execute()) {
        // proses upload berhasil
        redirect("varian");
    }
}

if (isset($_POST['btn-update-varian'])) {
    $id = $_GET['varianID'];
    $nama = $_POST['nama'];
    $harga = clearSpecialCharacter($_POST['harga']);
    $kategori = $_POST['kategori'];

    if ($_FILES['gambar']['name'] == "") {
        //jika tidak update image
        $query = "UPDATE varian SET nama = '$nama', harga = '$harga', categories_id = '$kategori' WHERE id = '$id'";
        $sql = $pdo->prepare($query);
        $sql->execute();

        redirect("varian");
    } else {
        //jika update image
        $gambar = $_FILES['gambar']['name'];
        $gambar_temp = $_FILES['gambar']['tmp_name'];

        $extension_gambar = pathinfo($gambar, PATHINFO_EXTENSION);
        $nama_gambar = clearSpecialCharacter($nama) . "_" . time() . "." . $extension_gambar;
        $dirUpload = "assets/image/varian/";

        $query = "UPDATE varian SET nama = '$nama', harga = '$harga', categories_id = '$kategori', gambar = '$nama_gambar' WHERE id = '$id'";
        $sql = $pdo->prepare($query);

        if (move_uploaded_file($gambar_temp, $dirUpload . $nama_gambar) && $sql->execute()) {
            // proses upload berhasil
            redirect("varian");
        }
    }
}

if (isset($_GET['delete']) && isset($_GET['varianID'])) {
    $id_varian = $_GET['varianID'];
    $query = "UPDATE varian  SET status = 0 WHERE id = '$id_varian'";
    $sql = $pdo->prepare($query);
    $sql->execute();
    redirect("varian");
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
                    <a class="h2">Daftar Varian Produk</a>
                    <button type="button" class="h5 btn btn-secondary btn-sm text-white" data-toggle="modal"
                        data-target="#tambahproduk"> <i class="fa fa-plus"> </i> Tambah Varian</button>

                </div>
                <!-- data kategori produk start -->
                <div class="row">
                    <?php
                    if (isset($_GET['edit'])) {
                        echo ' <div class="col-md-7">';
                        $categoryColumn = '<div class="col-md-6 mb-3">';
                    } else {
                        echo ' <div class="col-md-12">';
                        $categoryColumn = '<div class="col-md-4 mb-3">';
                    }
                    ?>
                    <div class="row">
                        <?php
                        $data_product = $pdo->query("SELECT A.id, A.nama, A.gambar, A.harga, B.nama AS nama_produk FROM varian A, products B WHERE A.status = 1 AND A.categories_id = B.id ORDER BY A.id DESC");
                        while ($data = $data_product->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <?= $categoryColumn ?>
                        <a href="?edit&varianID=<?= $data['id'] ?>&nama=<?= $data['nama'] ?>" class="">
                            <div class="card">
                                <img class="card-img-top" src="./assets/image/varian/<?= $data['gambar'] ?>">
                                <!-- <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <p class=""><?= $data['nama'] ?></p>
                                            <p>(<?= $data['nama_produk'] ?>)</p>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="card-title"><?= $data['nama'] ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p
                                                class="card-title float-right text-success font-weight-bold product-detail">
                                                <span><?= rupiah($data['harga']) ?></span>
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <small class="badge bg-info float-right"><?= $data['nama_produk'] ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php }
                ?>
                </div>
        </div>
        <?php
        if (isset($_GET['edit']) && isset($_GET['varianID'])) {
            $varian_id = $_GET['varianID'];
            $query = "SELECT * FROM varian WHERE id = '$varian_id'";
            $detailVarian = $pdo->query($query);
            $detailVarianData = $detailVarian->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group row mb-1">
                            <label for="namaproduk" class="col-sm-4 col-form-label">Nama </label>
                            <div class="col-sm-8">
                                <input type="text" name="nama" class="form-control"
                                    value="<?= $detailVarianData['nama'] ?>" placeholder="Nama Produk">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="namaproduk" class="col-sm-4 col-form-label">Harga</label>
                            <div class="col-sm-8">
                                <input type="text" id="rupiah" name="harga" min="0" class="form-control"
                                    placeholder="Harga" value="<?= $detailVarianData['harga'] ?>">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="col-sm-4 col-form-label">Kategori</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="kategori" aria-label="Default select example">
                                    <option selected="true" disabled="disabled">Pilih Produk
                                    </option>
                                    <?php
                                        $category = $pdo->query("SELECT * FROM products WHERE status = 1 ORDER BY id DESC");
                                        while ($categorySelect = $category->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                    <option value="<?= $categorySelect['id'] ?>">
                                        <?= $categorySelect['nama'] ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="col-sm-4 col-form-label">Gambar</label>
                            <div class="col-sm-8">
                                <input type="file" name="gambar" class="form-control" />
                            </div>
                        </div>
                        <button type="submit" name="btn-update-varian"
                            class="btn btn-success btn-sm float-right mt-2">Update Varian</button>

                        <a href="?delete&varianID=<?= $_GET['varianID'] ?>"
                            class="btn btn-danger btn-sm float-left mt-2">Delete</a>
                    </form>
                </div>
            </div>
        </div>
        <?php
        }
        ?>


    </div>
    <!-- data kategori produk end -->
    </main>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="tambahproduk" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Varian</h5>
                    <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal-add-product" method="POST" enctype="multipart/form-data">
                        <div class="form-group row mb-1">
                            <label for="namaproduk" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama" class="form-control" id="namaproduk"
                                    placeholder="Nama Varian">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="namaproduk" class="col-sm-4 col-form-label">Harga</label>
                            <div class="col-sm-8">
                                <input type="text" id="rupiah" name="harga" min="0" class="form-control"
                                    placeholder="Harga">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="col-sm-4 col-form-label">Kategori</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="kategori" aria-label="Default select example">
                                    <option selected="true" disabled="disabled">Pilih Produk
                                    </option>
                                    <?php
                                    $category = $pdo->query("SELECT * FROM products WHERE status = 1 ORDER BY id DESC");
                                    while ($categorySelect = $category->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?= $categorySelect['id'] ?>">
                                        <?= $categorySelect['nama'] ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="col-sm-4 col-form-label">Gambar</label>
                            <div class="col-sm-8">
                                <input type="file" name="gambar" class="form-control" id="customFile" />
                            </div>
                        </div>
                        <button type="submit" name="btn-tambah-varian" class="btn btn-success float-right mt-2">Tambah
                            Varian</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    <?php include './template/script.php' ?>

    <script>
    $(document).ready(function() {
        $('#btn_tampil').click(function() {
            $('#tampil').load('demo.php');
        });
    });

    //add product process

    $("modal-add-product").submit(function(event) {
        event.preventDefault();

        console.log("tombol-diklik")
    })

    let rupiah = document.getElementById('rupiah');


    rupiah.addEventListener('keyup', function(e) {
        rupiah.value = formatRupiah(this.value, 'Rp. ');
    });
    </script>


</body>


</html>