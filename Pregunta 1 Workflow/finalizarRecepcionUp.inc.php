<?php
// Conexión a la base de datos
include('conectar.inc.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = isset($_POST['accion']) ? $_POST['accion'] : null;

    if ($accion === 'modificar') {
        // Volver al proceso de verificar inventario
        header('Location: verificarInventario.inc.php');
        exit;
    } elseif ($accion === 'finalizar') {
        // Limpiar los datos de sesión y finalizar el proceso
        unset($_SESSION['productos_seleccionados'], $_SESSION['cantidades_recibidas'], $_SESSION['id_recepcion']);
        echo "Recepción finalizada con éxito.";
    } else {
        echo "Acción no válida.";
    }
}
?>
