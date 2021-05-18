<!DOCTYPE html>
<html lang="en">

<?php

include './template/head.php';
include './config.php';

if (isset($_POST['btn-tambah-produk'])) {
    $nama_kategori = $_POST['nama-kategori'];

    $gambar_kategori = $_FILES['gambar-kategori']['name'];
    $gambar_kategori_temp = $_FILES['gambar-kategori']['tmp_name'];

    $extension_gambar = pathinfo($gambar_kategori, PATHINFO_EXTENSION);
    $nama_gambar = clearSpecialCharacter($nama_kategori) . "_" . time() . "." . $extension_gambar;
    $dirUpload = "assets/image/category/";

    $query = "INSERT INTO categories (nama, gambar) VALUES('$nama_kategori', '$nama_gambar') ";
    $sql = $pdo->prepare($query);

    if (move_uploaded_file($gambar_kategori_temp, $dirUpload . $nama_gambar) && $sql->execute()) {
        // proses upload berhasil
        redirect("category");
    }
}

if (isset($_POST['btn-update-kategori'])) {
    $id_category = $_GET['categoryID'];
    $nama_kategori = $_POST['nama-kategori'];

    if ($_FILES['gambar-kategori']['name'] == "") {
        //jika tidak update image
        $query = "UPDATE categories SET nama = '$nama_kategori' WHERE id = '$id_category'";
        $sql = $pdo->prepare($query);
        $sql->execute();

        redirect("category");
    } else {
        //jika update image
        $gambar_kategori = $_FILES['gambar-kategori']['name'];
        $gambar_kategori_temp = $_FILES['gambar-kategori']['tmp_name'];

        $extension_gambar = pathinfo($gambar_kategori, PATHINFO_EXTENSION);
        $nama_gambar = clearSpecialCharacter($nama_kategori) . "_" . time() . "." . $extension_gambar;
        $dirUpload = "assets/image/category/";

        $query = "UPDATE categories SET nama = '$nama_kategori', gambar = '$nama_gambar' WHERE id = '$id_category'";
        $sql = $pdo->prepare($query);

        if (move_uploaded_file($gambar_kategori_temp, $dirUpload . $nama_gambar) && $sql->execute()) {
            // proses upload berhasil
            redirect("category");
        }
    }
}

if (isset($_GET['delete']) && isset($_GET['categoryID'])) {
    $id_category = $_GET['categoryID'];
    $query = "UPDATE categories SET status = 0 WHERE id = '$id_category'";
    $sql = $pdo->prepare($query);
    $sql->execute();
    redirect("category");
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
                    <a class="h2">Daftar Kategori Produk</a>
                    <button type="button" class="h5 btn btn-secondary btn-sm text-white" data-toggle="modal"
                        data-target="#tambahproduk"> <i class="fa fa-plus"> </i> Tambah Kategori</button>

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
                        $data_product = $pdo->query("SELECT * FROM categories WHERE status = 1 ORDER BY id DESC");
                        while ($data = $data_product->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <?= $categoryColumn ?>
                        <a href="?edit&categoryID=<?= $data['id'] ?>&nama=<?= $data['nama'] ?>" class="">
                            <div class="card">
                                <img class="card-img-top" src="./assets/image/category/<?= $data['gambar'] ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <h4 class="card-title text-center"><?= $data['nama'] ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php }
                ?>
                </div>
        </div>
        <?php
        if (isset($_GET['edit'])) {
        ?>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group row mb-1">
                            <label for="namaproduk" class="col-sm-4 col-form-label">Nama </label>
                            <div class="col-sm-8">
                                <input type="text" name="nama-kategori" class="form-control"
                                    value="<?= $_GET['nama'] ?>" placeholder="Nama Produk">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="col-sm-4 col-form-label">Gambar</label>
                            <div class="col-sm-8">
                                <input type="file" name="gambar-kategori" class="form-control" />
                            </div>
                        </div>
                        <button type="submit" name="btn-update-kategori"
                            class="btn btn-success btn-sm float-right mt-2">Update Kategori</button>

                        <a href="?delete&categoryID=<?= $_GET['categoryID'] ?>"
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal-add-product" method="POST" enctype="multipart/form-data">
                        <div class="form-group row mb-1">
                            <label for="namaproduk" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama-kategori" class="form-control" id="namaproduk"
                                    placeholder="Nama Kategori">
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="col-sm-4 col-form-label">Gambar</label>
                            <div class="col-sm-8">
                                <input type="file" name="gambar-kategori" class="form-control" id="customFile" />
                            </div>
                        </div>
                        <button type="submit" name="btn-tambah-produk" class="btn btn-success float-right mt-2">Tambah
                            Kategori</button>
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
    </script>
</body>


</html>