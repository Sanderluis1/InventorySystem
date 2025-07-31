<?php
require "../conexion.php";
$eliminar = 'eliminar';
session_start();
$regimen = mysqli_query($conexion, "SELECT * FROM regimen");
$total['regimen'] = mysqli_num_rows($regimen);
$importador = mysqli_query($conexion, "SELECT * FROM importador");
$total['importador'] = mysqli_num_rows($importador);
$aduanas = mysqli_query($conexion, "SELECT * FROM aduanas");
$total['aduanas'] = mysqli_num_rows($aduanas);
$mercancia = mysqli_query($conexion, "SELECT * FROM mercancia");
$total['mercancia'] = mysqli_num_rows($mercancia);
include_once "includes/header.php";
?>
<div class="card-body">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <a href="regimen.php" class="card-category text-success font-weight-bold">
                            Regimen Aduanero
                        </a>
                        <h3 class="card-title"><?php echo $total['regimen']; ?></h3>
                    </div>
                    <div class="card-footer bg-secondary text-white"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fab fa-product-hunt fa-2x"></i>
                        </div>
                        <a href="importador.php" class="card-category text-danger font-weight-bold">
                            Importadores
                        </a>
                        <h3 class="card-title"><?php echo $total['importador']; ?></h3>
                    </div>
                    <div class="card-footer bg-primary"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <a href="aduanas.php" class="card-category text-info font-weight-bold">
                            Agentes de Aduanas
                        </a>
                        <h3 class="card-title"><?php echo $total['aduanas']; ?></h3>
                    </div>
                    <div class="card-footer bg-secondary text-white"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-cash-register fa-2x"></i>
                        </div>
                        <a href="mercancia.php" class="card-category text-info font-weight-bold">
                            Mercancia
                        </a>
                        <h3 class="card-title"><?php echo $total['mercancia']; ?></h3>
                    </div>
                    <div class="card-footer bg-primary"></div>
                </div>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-lg">
                                <div class="card-header bg-primary text-white titulo-centro">
                                    Regimen Aduanero
                                </div>
                                <div class="card-body">
                                    <div class="card-header">
                                        Proximos registros que estan a 20 o menos dias de expirar
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-danger table-bordered" id="tbl">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Tipo de Persona</th>
                                                    <th>Tipo de Regimen</th>
                                                    <th>Tipo de Solicitud</th>
                                                    <th>Nro de Autorizacion</th>
                                                    <th>Fecha de Autorizacion</th>
                                                    <th>Tiempo de Autorizacion</th>
                                                    <th>Fecha de Vencimiento</th>
                                                    <th>Fecha de Manifiesto</th>
                                                    <th>Nro. de DUA</th>
                                                    <th>Nro. de Bill of Lading (B/L)</th>
                                                    <?php
                                                        $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$eliminar'");
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
                                                    $query = mysqli_query($conexion, "SELECT r.*, r.id FROM regimen r WHERE r.vencimiento != '0000-00-00' AND r.vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 20 DAY)");
                                                    $result = mysqli_num_rows($query);
                                                    if ($result > 0) {
                                                        while ($data = mysqli_fetch_assoc($query)) { ?>
                                                            <tr>
                                                                <td><?php echo $data['tipo_persona']; ?></td>
                                                                <td><?php echo $data['tipo_regimen']; ?></td>
                                                                <td><?php echo $data['tipo_solicitud']; ?></td>
                                                                <td><?php echo $data['nro_autorizacion']; ?></td>
                                                                <td><?php echo $data['fecha_autorizacion']; ?></td>
                                                                <td><?php echo $data['tiempo_autorizacion']; ?></td>
                                                                <td><?php echo $data['fecha_vencimiento']; ?></td>
                                                                <td><?php echo $data['nro_DUA']; ?></td>
                                                                <td><?php echo $data['tipo_transporte'] ?></td>
                                                                <td><?php echo $data['nro_transporte'] ?></td>
                                                                <td>
                                                                    <?php
                                                                        $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$eliminar'");
                                                                        $existe = mysqli_fetch_all($sql);
                                                                        if (empty($existe) && $id_user != 1) {
                                                                            echo '';
                                                                        } else { ?>
                                                                        <a class="btn btn-danger" href="delete_regimen.php?del=<?php echo $data['id']?>"><i class="fa fa-trash fa-lg"></i></a>
                                                                    <?php ;} ?>
                                                                </td>
                                                            </tr>
                                                <?php }} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include_once "includes/footer.php"; ?>