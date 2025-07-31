<?php
session_start();
require("../conexion.php");
$id_user = $_SESSION['idUser'];
$permiso = "Administrador";
$sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM clientes WHERE id_cliente = $id");
    mysqli_close($conexion);
    header("Location: clientes.php");
}
