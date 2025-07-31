<?php
session_start();
$permiso = 'Administrador';
$id_user = $_SESSION['idUser'];
include "../conexion.php";
$sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
if (!empty($_POST)) {
    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $user = $_POST['usuario'];
    $id_permiso = $_POST['id_permiso'];
    $alert = "";
    if (empty($nombre) || empty($cedula) || empty($user) || empty($id_permiso)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todos los campos son obligatorios
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    } else {
        if (empty($id_usuario)) {
            $clave = $_POST['clave'];
            if (empty($clave)) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    La contraseña es requerida
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $clave = md5($_POST['clave']);
                $query = mysqli_query($conexion, "SELECT * FROM usuario where cedula = '$cedula'");
                $result = mysqli_fetch_array($query);
                if ($result > 0) {
                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    El usuario ya existe
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                } else {
                    $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,cedula,usuario,clave,id_permiso) values ('$nombre', '$cedula', '$user', '$clave', '$id_permiso')");
                    if ($query_insert) {
                        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario Registrado
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                    } else {
                        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error al registrar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                    }
                }
            }
        } else {
            $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', cedula = '$cedula' , usuario = '$user' WHERE id_usuario = $id_usuario");
            if ($sql_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario Modificado
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error al modificar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
        }
    }
}
include "includes/header.php";
?>
<div class="card">
    <div class="card-body">
        <form action="" method="post" autocomplete="off" id="formulario">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" placeholder="Ingrese nombre" name="nombre" id="nombre">
                        <input type="hidden" id="id_usuario" name="id_usuario">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cedula">Cédula</label>
                        <input type="text" class="form-control" placeholder="Ingrese su Cedula" name="cedula" id="cedula">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="id_permiso">Tipo de Usuario</label>
                        <select class="form-control" id="id_permiso" name="id_permiso">
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" placeholder="Ingrese usuario" name="usuario" id="usuario">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="clave">Contraseña</label>
                        <input type="password" class="form-control" placeholder="Ingrese contraseña" name="clave" id="clave">
                    </div>
                </div>
            </div>
            <input type="submit" value="Registrar" class="btn btn-success" id="btnAccion">
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered mt-2" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conexion, "SELECT * FROM usuario");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['cedula']; ?></td>
                        <td><?php echo $data['usuario']; ?></td>
                        <td>
                            <a href="#" onclick="editarUsuario(<?php echo $data['id_usuario']; ?>)" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
                            <form action="eliminar_usuario.php?id=<?php echo $data['id_usuario']; ?>" method="post" class="confirmar d-inline">
                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<?php include_once "includes/footer.php"; ?>