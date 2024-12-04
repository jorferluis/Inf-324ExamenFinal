<?php
// Conexión a la base de datos
include('conectar.inc.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];

    if (empty($cantidades)) {
        echo "No se han ingresado cantidades.";
        exit;
    }

    $_SESSION['cantidades_recibidas'] = $cantidades;

    // Redirigir al proceso final
    header('Location: finalizarRecepcion.inc.php');
    exit;
}
?>
