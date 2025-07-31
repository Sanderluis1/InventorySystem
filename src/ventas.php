<?php
session_start();
require("../conexion.php");
$id_user = $_SESSION['idUser'];
$permiso = "Administrador";
$sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
include_once "includes/header.php";
?>
<div class="card">
    <div class="card-body">    
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary text-white titulo-centro">
                        Datos del cliente
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="hidden" id="id_cliente" value="1" name="id_cliente" required>
                                        <label>Nombre</label>
                                        <input type="text" name="nombre_apellido" id="nombre_apellido" class="form-control" placeholder="Ingrese nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input type="number" name="nro_telefono" id="nro_telefono" class="form-control" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cédula</label>
                                        <input type="text" name="cedula_cliente" id="cedula_cliente" class="form-control" disabled required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-primary text-white titulo-centro">
                        Buscar Productos
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="producto">Código o Nombre</label>
                                    <input id="producto" class="form-control" type="text" name="producto" placeholder="Ingresa el código o nombre">
                                    <input id="id_producto" type="hidden" name="id_producto">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input id="cantidad" class="form-control" type="text" name="cantidad" placeholder="Presione Enter para confirmar" onkeyup="calcularPrecio(event)">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="sub_total">Sub Total</label>
                                    <input id="sub_total" class="form-control" type="text" name="sub_total" placeholder="Sub Total" disabled>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="tblDetalle">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Aplicar</th>
                                <th>Desc</th>
                                <th>Precio</th>
                                <th>Precio Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="detalle_venta">

                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td>Total </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
            <div class="col-md-6">
                <a href="#" class="btn btn-success" id="btn_generar"><i class="fas fa-save"></i> Generar Retiro</a>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>