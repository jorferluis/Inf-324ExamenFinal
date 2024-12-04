<?php
session_start();
include "conectar.inc.php";

// Validar que existan los datos necesarios en la sesión
if (!isset($_SESSION['detalles_despacho'], $_SESSION['productos_seleccionados'])) {
    die("No se encontraron datos del despacho. Vuelve al paso anterior.");
}

$detallesDespacho = $_SESSION['detalles_despacho']; // id_producto => cantidad
$productosSeleccionados = $_SESSION['productos_seleccionados']; // IDs de productos seleccionados

// Obtener todos los despachos en estado pendiente
$queryDespachos = "SELECT id_despacho, descripcion FROM Despachos WHERE estado = 'Pendiente'";
$resultDespachos = $con->query($queryDespachos);

if ($resultDespachos->num_rows == 0) {
    die("No hay despachos pendientes para seleccionar.");
}
?>

<h1>Confirmar Entrega</h1>

<!-- Seleccionar despacho -->
<form action="confirmarEntregaUp.inc.php" method="POST">
    <label for="id_despacho"><strong>Seleccione un despacho:</strong></label>
    <select name="id_despacho" id="id_despacho" required>
        <option value="">-- Seleccione --</option>
        <?php while ($despacho = $resultDespachos->fetch_assoc()): ?>
            <option value="<?php echo htmlspecialchars($despacho['id_despacho']); ?>">
                <?php echo htmlspecialchars($despacho['descripcion']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <!-- Mostrar tabla con productos y cantidades -->
    <h2>Detalles del Despacho</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad a Despachar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Obtener nombres de los productos seleccionados
            $placeholders = implode(',', array_fill(0, count($productosSeleccionados), '?'));
            $queryProductos = "SELECT id_producto, nombre_producto 
                               FROM Productos 
                               WHERE id_producto IN ($placeholders)";
            $stmt = $con->prepare($queryProductos);
            $stmt->bind_param(str_repeat('i', count($productosSeleccionados)), ...$productosSeleccionados);
            $stmt->execute();
            $resultProductos = $stmt->get_result();

            while ($producto = $resultProductos->fetch_assoc()):
                $idProducto = $producto['id_producto'];
                $cantidad = $detallesDespacho[$idProducto] ?? 0;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                    <td><?php echo htmlspecialchars($cantidad); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </br>            
    <!-- Botón de confirmación -->
    <button type="submit">Confirmar Despacho</button>
</form>
