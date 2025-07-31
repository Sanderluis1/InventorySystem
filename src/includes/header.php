<?php
$permiso = 'Administrador';
$id_user = $_SESSION['idUser'];
if (empty($_SESSION['active'])) {
    header('Location: ../');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="../assets/img/shortcut.png"/>
    <title>Proyecto 3</title>
    <link href="../assets/css/material-dashboard.css" rel="stylesheet" />
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/magic.css">
    <script src="../assets/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <div>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand home-button" href="index.php">
                            <img src="../assets/img/logo.png" width="80" height="80">
                        </a>
                    </div>
                    <button class="navbar-toggler" type="sidebar" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav"  style="white-space: nowrap;">
                            <li class="nav-item">
                                <a class="nav-link d-flex grow-btn" href="productos.php">
                                    Productos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex grow-btn" href="lista_ventas.php">
                                    Historial de Retiros
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex grow-btn" href="ventas.php">
                                    Retiros
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex grow-btn" href="clientes.php">
                                    Clientes
                                </a>
                            </li>
                            <!-- 
                                <li class="nav-item">
                                    <a class="nav-link d-flex grow-btn" href="estadisticas.php">
                                        Estadisticas
                                    </a>
                                </li>
                            -->
                        </ul>
                    </div>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProfile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                            <?php
                            $sql = mysqli_query($conexion, "SELECT p.*, u.* FROM permisos p INNER JOIN usuario u ON p.id_permiso = u.id_permiso WHERE u.id_usuario = '$id_user' AND p.nombre_permiso = '$permiso'");
                            $existe = mysqli_fetch_all($sql);
                            if (!empty($existe) || $id_user == 1) {
                                echo '<a class="dropdown-item" href="usuarios.php">Usuarios</a><div class="dropdown-divider"></div>';
                            }
                            ?>
                            <a class="dropdown-item" href="salir.php">Cerrar Sesión</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="ayuda.php">¿Ayuda?</a>
                        </div>
                    </li>
                </ul>
            </div>
         </div>
    </nav>
        <!-- End Navbar -->
            <div class="content bg">
                <div class="container-fluid">