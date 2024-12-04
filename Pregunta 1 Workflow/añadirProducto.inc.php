<?php
// Conexión a la base de datos
include('conectar.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($con, $_POST['nombre_producto']);
    $descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
    $cantidad = (int)$_POST['cantidad'];

    $query = "INSERT INTO Productos (nombre_producto, descripcion, cantidad) VALUES ('$nombre', '$descripcion', $cantidad)";
    $resultado = mysqli_query($con, $query);

    if ($resultado) {
        echo "Producto añadido con éxito.";
        header('Location: flujo.php?flujo=F2&proceso=P1');
        exit;
    } else {
        echo "Error al añadir producto: " . mysqli_error($con);
    }
}
?>
