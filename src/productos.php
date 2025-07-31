<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$permiso = 'Administrador';
$id_user = $_SESSION['idUser'];
include "../conexion.php";
$sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (!empty($_POST)) {
    $alert = "";
    $id_producto = $_POST['id_producto'];
    $producto = $_POST['producto'];
    $id_tipo = $_POST['id_tipo'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    if (empty ($producto) || empty ($id_tipo) || empty ($precio) || empty ($cantidad) ) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todos los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                  </div>';
    } else {
        if (empty($id_producto)) {
            $query = mysqli_query($conexion, "SELECT * FROM productos WHERE producto = '$producto'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        El Producto ya existe
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO productos(producto,id_tipo,precio,cantidad) values ('$producto', '$id_tipo','$precio', '$cantidad')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Registrado Correctamente
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">
                    Error al registrar
                  </div>';
                }
            }
        } else {
            $query_update = mysqli_query($conexion, "UPDATE productos SET producto = '$producto', id_tipo = '$id_tipo', precio = '$precio', cantidad = '$cantidad' WHERE id_producto = $id_producto");
            if ($query_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Actualizado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al actualizar
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
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white titulo-centro">
                        Productos
                    </div>
                    <div class="card-body">
                        <form action="" method="post" autocomplete="off" id="formulario">
                            <?php echo isset($alert) ? $alert : ''; ?>
                            <div class="row">
                            <?php
                                    $sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
                                    $existe = mysqli_fetch_all($sql);
                                    if (empty($existe) && $id_user != 1) {
                                        echo '';
                                    }else{
                                        ?>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="producto">Producto</label>
                                        <input type="text" placeholder="Ingrese el nombre del Producto" name="producto" id="producto" class="form-control">
                                        <input type="hidden" id="id_producto" name="id_producto">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Tipo del Producto</label>
                                        <?php
                                            $query=mysqli_query($conexion, "SELECT * from tipo_productos");
                                        ?>
                                        <select class="form-control" name="id_tipo" id="id_tipo">
                                        <?php 
                                            while ($row = mysqli_fetch_array($query))
                                            {
                                            echo "<option value='".$row['id_tipo']."'>".$row['nombre_tipo']."</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="precio" class=" text-dark font-weight-bold"><svg width="18px" height="18px" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg" aria-labelledby="dolarIconTitle" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" color="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title id="dolarIconTitle">Dolar</title> <path d="M12 4L12 6M12 18L12 20M15.5 8C15.1666667 6.66666667 14 6 12 6 9 6 8.5 7.95652174 8.5 9 8.5 13.140327 15.5 10.9649412 15.5 15 15.5 16.0434783 15 18 12 18 10 18 8.83333333 17.3333333 8.5 16"></path> </g></svg> Precio </label>
                                        <input type="number" id="precio" name="precio" placeholder="Inserte el precio (Ejem: 20.12)" min="0" step="0.01" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cantidad" class=" text-dark font-weight-bold">Cantidad </label>
                                        <input type="number" placeholder="Ingrese la cantidad" name="cantidad" id="cantidad" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                     <input type="submit" class="btn btn-success" value="Enviar" id="btnAccion">
                                </div>
                                <?php ;} ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre del Producto</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <?php
                                $sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
                                $existe = mysqli_fetch_all($sql);
                                if (empty($existe) && $id_user != 1) {
                                    echo '';
                                } else { ?>
                                <th>Editar</th>
                            <?php ;} ?>
                            <?php
                                $sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
                                $existe = mysqli_fetch_all($sql);
                                if (empty($existe) && $id_user != 1) {
                                    echo '';
                                } else { ?>
                                <th>Eliminar</th>
                            <?php ;} ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = mysqli_query($conexion, "SELECT p.*, tp.nombre_tipo FROM productos p INNER JOIN tipo_productos tp ON p.id_tipo = tp.id_tipo") or die(mysqli_error($conexion));
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                        while($data=mysqli_fetch_assoc($query)){  
                            ?>
                            <tr>
                            <td><?php echo $data['producto'] ?></td>
                            <td><?php echo $data['nombre_tipo'] ?></td>
                            <td><?php echo $data['precio'] ?></td>
                            <td><?php echo $data['cantidad'] ?></td>
                            <?php
                                $sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
                                $existe = mysqli_fetch_all($sql);
                                if (empty($existe) && $id_user != 1) {
                                    echo '';
                                } else { ?>
                                <td>
                                    <a href="#" onclick="editarProductos(<?php echo $data['id_producto']; ?>)" class="btn btn-warning"><i class='fas fa-edit fa-lg'></i></a>
                                </td>
                            <?php ;} ?>
                            <?php
                                $sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
                                $existe = mysqli_fetch_all($sql);
                                if (empty($existe) && $id_user != 1) {
                                    echo '';
                                } else { ?>
                            <td>
                                <a class="btn btn-danger" href="delete_productos.php?del=<?php echo $data['id_producto']?>"><i class="fa fa-trash fa-lg"></i></a>
                                <?php ;} ?>
                            </td>

						<?php }}?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>