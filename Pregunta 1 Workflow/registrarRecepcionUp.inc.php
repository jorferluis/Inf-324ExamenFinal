<?php
// Conexión a la base de datos
include('conectar.inc.php');

// Iniciar la sesión
session_start();

if (isset($_SESSION['id_recepcion']) && isset($_SESSION['productos_seleccionados'])) {
    // Obtener el ID de la recepción y los productos seleccionados de la sesión
    $idRecepcion = $_SESSION['id_recepcion'];
    $productosSeleccionados = $_SESSION['productos_seleccionados'];

    // Insertar los productos seleccionados en la tabla RecepcionDetalles
    foreach ($productosSeleccionados as $idProducto) {
        // Puedes ajustar la cantidad según sea necesario (en este caso, se usa 1 como ejemplo)
        $cantidad = 1; // Cambiar según cómo quieras registrar la cantidad de productos

        $queryDetalle = "INSERT INTO RecepcionDetalles (id_recepcion, id_producto, cantidad) VALUES ($idRecepcion, $idProducto, $cantidad)";
        $resultadoDetalle = mysqli_query($con, $queryDetalle);

        if (!$resultadoDetalle) {
            echo "Error al registrar el producto $idProducto: " . mysqli_error($con);
            exit;
        }
    }

    // Limpiar la sesión después de realizar la inserción
    unset($_SESSION['id_recepcion']);
    unset($_SESSION['productos_seleccionados']);

    echo "Productos registrados con éxito en RecepcionDetalles.";
    header('Location: flujo.php?flujo=F2&proceso=P3'); // Redirigir al siguiente paso (ajustar según lo necesario)
    exit;
} else {
    echo "No se encontraron datos para procesar.";
}
?>
