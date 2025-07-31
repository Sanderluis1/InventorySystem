<?php
session_start();
include_once "includes/header.php"; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header card-header-primary">
                Denegado
            </div>
            <div class="card-body text-center">
                <p style="font-weight:bold;">No tiene autorización para ver este proceso</p>
                <a class="btn btn-danger" href="index.php">Atras</a>
            </div>
        </div>
    </div>
</div>
<img class="character-figure" src="../assets/img/whiteguy.png" alt="">
<?php include_once "includes/footer.php"; ?>