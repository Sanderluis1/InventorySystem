<?php
extract($_REQUEST);
include('../conexion.php');

$sql=mysqli_query($conexion,"SELECT * from productos where id_producto='$del'");
$row=mysqli_fetch_array($sql);

mysqli_query($conexion,"DELETE from productos where id_producto='$del'");

header("Location:productos.php");
?>