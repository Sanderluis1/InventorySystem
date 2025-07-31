<?php
session_start();
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "Administrador";
$sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre_cliente']) || empty($_POST['nro_telefono']) || empty($_POST['cedula_cliente'])) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todos los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $id_cliente = $_POST['id_cliente'];
        $nombre_cliente = $_POST['nombre_cliente'];
        $cedula_cliente = $_POST['cedula_cliente'];
        $id_codigo = $_POST['id_codigo'];
        $nro_telefono = $_POST['nro_telefono'];
        $result = 0;
        if (empty($id_cliente)) {
            $query = mysqli_query($conexion, "SELECT * FROM clientes WHERE cedula_cliente = '$cedula_cliente'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        El cliente ya existe
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO clientes(cedula_cliente,nombre_cliente,id_codigo,nro_telefono) values ('$cedula_cliente','$nombre_cliente', '$id_codigo', '$nro_telefono')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Cliente Registrado
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
        }else{
            $sql_update = mysqli_query($conexion, "UPDATE clientes SET cedula_cliente = '$cedula_cliente', nombre_cliente = '$nombre_cliente', id_codigo = '$id_codigo', nro_telefono = '$nro_telefono' WHERE id_cliente = $id_cliente");
            if ($sql_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Cliente Modificado
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
include_once "includes/header.php";
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : '' ; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_cliente" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese el nombre y apellido" name="nombre_cliente" id="nombre_cliente" class="form-control">
                                <input type="hidden" name="id_cliente" id="id_cliente">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cedula_cliente" class="text-dark font-weight-bold">Cedula</label>
                                <input type="text" placeholder="Ingrese cedula" name="cedula_cliente" id="cedula_cliente" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="id_codigo">Teléfono</label>
                                <?php
                                    $query=mysqli_query($conexion, "SELECT * FROM codigo_telefono");
                                ?>
                                <select class="form-control" id="id_codigo" name="id_codigo">
                                    <?php 
                                        while ($row = mysqli_fetch_array($query))
                                        {
                                        echo "<option value='".$row['id_codigo']."'>".$row['codigo']."</option>";
                                        }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nro_telefono" class="text-dark font-weight-bold">Teléfono</label>
                                <input type="number" placeholder="Ingrese teléfono" name="nro_telefono" id="nro_telefono" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="submit" value="Registrar" class="btn btn-success" id="btnAccion">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tbl">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Cedula</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../conexion.php";

                            $query = mysqli_query($conexion, "SELECT c.*, ct.codigo FROM clientes c LEFT JOIN codigo_telefono ct ON c.id_codigo = ct.id_codigo");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['nombre_cliente']; ?></td>
                                        <td><?php echo $data['codigo'] .'-'. $data['nro_telefono']; ?></td>
                                        <td><?php echo $data['cedula_cliente']; ?></td>
                                        <td>
                                            <a href="#" onclick="editarCliente(<?php echo $data['id_cliente']; ?>)" class="btn btn-warning"><i class='fas fa-edit'></i></a>
                                            <form action="eliminar_cliente.php?id=<?php echo $data['id_cliente']; ?>" method="post" class="confirmar d-inline">
                                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>