<?php
session_start();
include "conectar.inc.php";

// Validar si existen productos seleccionados en la sesión
if (!isset($_SESSION['productos_seleccionados']) || empty($_SESSION['productos_seleccionados'])) {
    die("No hay productos seleccionados. Vuelve al paso anterior.");
}

$productosSeleccionados = $_SESSION['productos_seleccionados']; // IDs de productos seleccionados

// Obtener los datos del despacho actual
$flujo = $_GET['flujo'];
$proceso = $_GET['proceso'];

$query = "SELECT d.id_despacho, d.descripcion 
        FROM Despachos d
        JOIN FlujoProcesos fp ON fp.flujo = ? 
        WHERE fp.proceso = ? AND d.estado = 'Pendiente'";
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $flujo, $proceso);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("No hay despachos pendientes.");
}

$row = $result->fetch_assoc();
$id_despacho = $row['id_despacho'];
?>

<h1>Realizar Despacho</h1>
<form action="realizarDespachoUp.inc.php" method="POST">
    <input type="hidden" name="id_despacho" value="<?php echo htmlspecialchars($id_despacho); ?>">

    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad Disponible</th>
                <th>Cantidad a Despachar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consultar los productos seleccionados
            $placeholders = implode(',', array_fill(0, count($productosSeleccionados), '?'));
            $query = "SELECT id_producto, nombre_producto, cantidad 
                    FROM Productos 
                    WHERE id_producto IN ($placeholders)";
            $stmt = $con->prepare($query);
            $stmt->bind_param(str_repeat('i', count($productosSeleccionados)), ...$productosSeleccionados);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombre_producto']); ?></td>
                    <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                    <td>
                        <input type="number" name="productos[<?php echo $row['id_producto']; ?>]" 
                            min="0" max="<?php echo $row['cantidad']; ?>" required>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button type="submit">Continuar</button>
</form>
