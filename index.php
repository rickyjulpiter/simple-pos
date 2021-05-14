<!DOCTYPE html>
<html lang="en">

<?php include './template/head.php' ?>

<body>
    <?php include './template/header.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php include './template/navbar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body sell-dashboard">
                            <h4> <span class="alignleft"> Penjualan hari ini</span> <span class="alignright">780</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
<script src="./assets/bootstrap/js/bootstrap.bundle.js"></script>

</html>