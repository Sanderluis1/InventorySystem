<?php
session_start();
require_once "../conexion.php";
$id_user = $_SESSION['idUser'];
include_once "includes/header.php";
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
            <h3><center>⚠️SOPORTE⚠️</center></h3>
        
        <br><h5><center> En caso de que se presenten fallas en el sistema,
        por favor comunicarse por los siguientes medios.</center></h5></br> 

        <ul>
            <h5><li>Correo Electrónico: </li>
           
            <li>Número de Teléfono: (+58 412-9347349) </li></h5>
        </ul> 
        <div>
           Corporacion de Servicios DIVI ©.
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
