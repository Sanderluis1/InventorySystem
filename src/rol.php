<?php
session_start();
$permiso = 'usuarios';
$id_user = $_SESSION['idUser'];
include "../conexion.php";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
$id = $_GET['id'];
$sqlpermisos = mysqli_query($conexion, "SELECT * FROM permisos");
$usuarios = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $id");
$consulta = mysqli_query($conexion, "SELECT * FROM detalle_permisos WHERE id_usuario = $id");
$resultUsuario = mysqli_num_rows($usuarios);
if (empty($resultUsuario)) {
    header("Location: usuarios.php");
}
$datos = array();
foreach ($consulta as $asignado) {
    $datos[$asignado['id_permiso']] = true;
}
if (isset($_POST['permisos'])) {
    $id_user = $_GET['id'];
    $permisos = $_POST['permisos'];
    mysqli_query($conexion, "DELETE FROM detalle_permisos WHERE id_usuario = $id_user");
    if ($permisos != "") {
        foreach ($permisos as $permiso) {
            $sql = mysqli_query($conexion, "INSERT INTO detalle_permisos(id_usuario, id_permiso) VALUES ($id_user,$permiso)");
        }
        $consulta = mysqli_query($conexion, "SELECT * FROM detalle_permisos WHERE id_usuario = $id_user");
        $datos = array();
        foreach ($consulta as $asignado) {
            $datos[$asignado['id_permiso']] = true;
        }
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Permisos Asignado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    
    }
}
include_once "includes/header.php";
?>
<a href=""></a>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-lg">
            <div class="card-header card-header-primary">
                Permisos
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <?php echo (isset($alert)) ? $alert : '' ; ?>
                    <div class="grid-container">
                    <?php while ($row = mysqli_fetch_assoc($sqlpermisos)) { ?>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label"><?php echo $row['view']; ?>
                            <input class="form-check-input" id="permisos" type="checkbox" name="permisos[]" value="<?php echo $row['id']; ?>"
                            <?php
                            if (isset($datos[$row['id']])) {
                                echo "checked";
                            }
                            ?>>
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                            </label>
                        </div>
                    <?php } ?>
                    </div>
                    <br>
                    <button class="btn btn-success btn-block" type="submit">Modificar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>