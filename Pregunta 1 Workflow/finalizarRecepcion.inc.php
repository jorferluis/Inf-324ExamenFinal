<?php
// Conexión a la base de datos
include('conectar.inc.php');

session_start();

if (!isset($_SESSION['productos_seleccionados'], $_SESSION['cantidades_recibidas'])) {
    echo "No hay información suficiente para mostrar la recepción.";
    exit;
}

$productosSeleccionados = $_SESSION['productos_seleccionados'];
$cantidadesRecibidas = $_SESSION['cantidades_recibidas'];

// Consultar los productos seleccionados
$query = "SELECT id_producto, nombre_producto FROM Productos WHERE id_producto IN (" . implode(',', array_map('intval', $productosSeleccionados)) . ")";
$resultado = mysqli_query($con, $query);

if (!$resultado) {
    die("Error al obtener los productos: " . mysqli_error($con));
}

$productos = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $productos[$row['id_producto']] = $row['nombre_producto'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Recepción</title>
</head>
<body>
    <h1>Finalizar Recepción</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad Recibida</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cantidadesRecibidas as $idProducto => $cantidad): ?>
            <tr>
                <td><?= htmlspecialchars($productos[$idProducto]) ?></td>
                <td><?= htmlspecialchars($cantidad) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <form action="finalizarRecepcionUp.inc.php" method="POST">
        <button type="submit" name="accion" value="finalizar">Finalizar Recepción</button>
        <button type="submit" name="accion" value="modificar">Modificar Cantidades</button>
    </form>
</body>
</html>
