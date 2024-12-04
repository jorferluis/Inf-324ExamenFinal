<?php
session_start();
include "conectar.inc.php";

// Validar si se seleccionaron productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['productos'])) {
    $productosSeleccionados = $_POST['productos']; // Array con IDs de productos seleccionados

    // Guardar los productos seleccionados en la sesión
    $_SESSION['productos_seleccionados'] = $productosSeleccionados;

    // Redirigir al siguiente proceso
    header('Location: flujo.php?flujo=F1&proceso=P2');
    exit;
} else {
    echo "No se seleccionaron productos.";
}
?>
