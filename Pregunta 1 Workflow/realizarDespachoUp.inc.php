<?php
session_start();
include "conectar.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idDespacho = $_POST['id_despacho'];
    $productos = $_POST['productos']; // Array con id_producto => cantidad

    // Validar cantidades ingresadas
    $detallesDespacho = []; // Almacenar productos y cantidades seleccionadas para el siguiente paso
    foreach ($productos as $idProducto => $cantidad) {
        $cantidad = (int)$cantidad;
        if ($cantidad > 0) {
            $detallesDespacho[$idProducto] = $cantidad;
        }
    }

    if (empty($detallesDespacho)) {
        die("Debe seleccionar al menos un producto con una cantidad mayor a 0.");
    }

    // Guardar los detalles en la sesión para el siguiente proceso
    $_SESSION['detalles_despacho'] = $detallesDespacho; // id_producto => cantidad
    $_SESSION['productos_seleccionados'] = array_keys($detallesDespacho); // IDs de productos seleccionados
    $_SESSION['id_despacho'] = $idDespacho;

    // Redirigir al proceso 4
    header("Location: flujo.php?flujo=F1&proceso=P4");
    exit();
}
?>
