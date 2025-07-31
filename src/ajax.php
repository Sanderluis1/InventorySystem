<?php
require_once "../conexion.php";
session_start();
if (isset($_GET['q'])) {
    $datos = array();
    $nombre = $_GET['q'];
    $cliente = mysqli_query($conexion, "SELECT c.*, ct.codigo FROM clientes c LEFT JOIN codigo_telefono ct ON c.id_codigo = ct.id_codigo WHERE nombre_cliente LIKE '%$nombre%'");
    while ($row = mysqli_fetch_assoc($cliente)) {
        $data['label'] = $row['nombre_cliente'];
        $data['value'] = $row['nombre_cliente'];
        $data['id_cliente'] = $row['id_cliente'];
        $data['cedula_cliente'] = $row['cedula_cliente'];
        $data['nro_telefono'] = $row['codigo'] . $row['nro_telefono'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
}else if (isset($_GET['pro'])) {
    $datos = array();
    $nombre = $_GET['pro'];
    $producto = mysqli_query($conexion, "SELECT * FROM productos WHERE producto LIKE '%$nombre%'");
    while ($row = mysqli_fetch_assoc($producto)) {
        $data['id_producto'] = $row['id_producto'];
        $data['label'] = $row['producto'] . ' - ' .$row['cantidad'].' Unidades';
        $data['value'] = $row['producto'];
        $data['precio'] = $row['precio'];
        $data['cantidad'] = $row['cantidad'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
}else if (isset($_GET['detalle'])) {
    $id = $_SESSION['idUser'];
    $datos = array();
    $detalle = mysqli_query($conexion, "SELECT d.*, p.id_producto, p.producto FROM detalle_temp d INNER JOIN productos p ON d.id_producto = p.id_producto WHERE d.id_usuario = $id");
    while ($row = mysqli_fetch_assoc($detalle)) {
        $data['id'] = $row['id'];
        $data['producto'] = $row['producto'];
        $data['cantidad'] = $row['cantidad'];
        $data['descuento'] = $row['descuento'];
        $data['precio_venta'] = $row['precio_venta'];
        $data['sub_total'] = $row['total'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
} else if (isset($_GET['delete_detalle'])) {
    $id_detalle = $_GET['id'];
    $query = mysqli_query($conexion, "DELETE FROM detalle_temp WHERE id = $id_detalle");
    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }
    echo $msg;
    die();
} else if (isset($_GET['procesarVenta'])) {
    $id_cliente = $_GET['id_cliente'];
    $id_user = $_SESSION['idUser'];
    $consulta = mysqli_query($conexion, "SELECT total, SUM(total) AS total_pagar FROM detalle_temp WHERE id_usuario = $id_user");
    $result = mysqli_fetch_assoc($consulta);
    $total = $result['total_pagar'];
    $insertar = mysqli_query($conexion, "INSERT INTO ventas(id_cliente, total, id_usuario) VALUES ($id_cliente, '$total', $id_user)");
    if ($insertar) {
        $id_maximo = mysqli_query($conexion, "SELECT MAX(id_venta) AS total FROM ventas");
        $resultId = mysqli_fetch_assoc($id_maximo);
        $ultimoId = $resultId['total'];
        $consultaDetalle = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id_usuario = $id_user");
        while ($row = mysqli_fetch_assoc($consultaDetalle)) {
            $id_producto = $row['id_producto'];
            $cantidad = $row['cantidad'];
            $desc = $row['descuento'];
            $precio = $row['precio_venta'];
            $total = $row['total'];
            $insertarDet = mysqli_query($conexion, "INSERT INTO detalle_venta (id_producto, id_venta, cantidad, precio, descuento, total) VALUES ($id_producto, $ultimoId, $cantidad, '$precio', '$desc', '$total')");
            $stockActual = mysqli_query($conexion, "SELECT * FROM productos WHERE id_producto  = $id_producto");
            $stockNuevo = mysqli_fetch_assoc($stockActual);
            $stockTotal = $stockNuevo['cantidad'] - $cantidad;
            $stock = mysqli_query($conexion, "UPDATE productos SET cantidad = $stockTotal WHERE id_producto  = $id_producto");
        } 
        if ($insertarDet) {
            $eliminar = mysqli_query($conexion, "DELETE FROM detalle_temp WHERE id_usuario = $id_user");
            $msg = array('id_cliente' => $id_cliente, 'id_venta' => $ultimoId);
        } 
    }else{
        $msg = array('mensaje' => 'error');
    }
    echo json_encode($msg);
    die();
}else if (isset($_GET['descuento'])) {
    $id = $_GET['id'];
    $desc = $_GET['desc'];
    $consulta = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id = $id");
    $result = mysqli_fetch_assoc($consulta);
    $total_desc = $desc + $result['descuento'];
    $total = $result['total'] - $desc;
    $insertar = mysqli_query($conexion, "UPDATE detalle_temp SET descuento = $total_desc, total = '$total'  WHERE id = $id");
    if ($insertar) {
        $msg = array('mensaje' => 'descontado');
    }else{
        $msg = array('mensaje' => 'error');
    }
    echo json_encode($msg);
    die();
}else if(isset($_GET['editarCliente'])){
    $id_cliente = $_GET['id_cliente'];
    $sql = mysqli_query($conexion, "SELECT * FROM clientes WHERE id_cliente = $id_cliente");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarUsuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE id_usuario = $id_usuario");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarProductos'])) {
    $id_producto = $_GET['id_producto'];
    $sql = mysqli_query($conexion, "SELECT * FROM productos WHERE id_producto = $id_producto");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
}
if (isset($_POST['regDetalle'])) {
    $id = $_POST['id'];
    $cant = $_POST['cant'];
    $precio = $_POST['precio'];
    $id_user = $_SESSION['idUser'];
    $total = $precio * $cant;
    $verificar = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id_producto = $id AND id_usuario = $id_user");
    $result = mysqli_num_rows($verificar);
    $datos = mysqli_fetch_assoc($verificar);
    if ($result > 0) {
        $cantidad = $datos['cantidad'] + $cant;
        $total_precio = ($cantidad * $total);
        $query = mysqli_query($conexion, "UPDATE detalle_temp SET cantidad = $cantidad, total = '$total_precio' WHERE id_producto = $id AND id_usuario = $id_user");
        if ($query) {
            $msg = "actualizado";
        } else {
            $msg = "Error al ingresar";
        }
    }else{
        $query = mysqli_query($conexion, "INSERT INTO detalle_temp(id_usuario, id_producto, cantidad, precio_venta, total) VALUES ($id_user, $id, $cant,'$precio', '$total')");
        if ($query) {
            $msg = "registrado";
        }else{
            $msg = "Error al ingresar";
        }
    }
    echo json_encode($msg);
    die();
}else if (isset($_POST['cambio'])) {
    if (empty($_POST['actual']) || empty($_POST['nueva'])) {
        $msg = 'Los campos estan vacios';
    } else {
        $id = $_SESSION['idUser'];
        $actual = md5($_POST['actual']);
        $nueva = md5($_POST['nueva']);
        $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE clave = '$actual' AND idusuario = $id");
        $result = mysqli_num_rows($consulta);
        if ($result == 1) {
            $query = mysqli_query($conexion, "UPDATE usuario SET clave = '$nueva' WHERE idusuario = $id");
            if ($query) {
                $msg = 'ok';
            }else{
                $msg = 'error';
            }
        } else {
            $msg = 'dif';
        }
        
    }
    echo $msg;
    die();
    
}

