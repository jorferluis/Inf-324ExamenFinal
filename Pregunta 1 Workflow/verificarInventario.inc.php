<?php
// Conexión a la base de datos
include('conectar.inc.php');

session_start();

// Recuperar productos seleccionados de la sesión
$productosSeleccionados = isset($_SESSION['productos_seleccionados']) ? $_SESSION['productos_seleccionados'] : [];

if (empty($productosSeleccionados)) {
    echo "No se han seleccionado productos.";
    exit;
}

// Consultar los productos seleccionados
$query = "SELECT id_producto, nombre_producto, cantidad FROM Productos WHERE id_producto IN (" . implode(',', array_map('intval', $productosSeleccionados)) . ")";
$resultado = mysqli_query($con, $query);

if (!$resultado) {
    die("Error al obtener los productos: " . mysqli_error($con));
}

$productos = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $productos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Inventario</title>
</head>
<body>
    <h1>Verificar Inventario</h1>
    
    <form action="verificarInventarioUp.inc.php" method="POST">
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad Actual</th>
                    <th>Cantidad Recibida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= htmlspecialchars($producto['nombre_producto']) ?></td>
                    <td><?= $producto['cantidad'] ?></td>
                    <td>
                        <input type="number" name="cantidades[<?= $producto['id_producto'] ?>]" value="0" min="0" required>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
