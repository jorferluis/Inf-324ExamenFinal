<?php
session_start();
include "conectar.inc.php";

// Obtener los productos disponibles
$query = "SELECT id_producto, nombre_producto FROM Productos WHERE cantidad > 0";
$result = $con->query($query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error al ejecutar la consulta: " . $con->error);
}

// Verificar si hay productos disponibles
if ($result->num_rows == 0) {
    die("No hay productos disponibles.");
}
?>
<h1>Seleccionar Productos</h1>

<form action="seleccionarProductoUp.inc.php" method="POST">
    <table border="1">
        <thead>
            <tr>
                <th>Seleccionar</th>
                <th>Producto</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="productos[]" value="<?php echo $row['id_producto']; ?>">
                    </td>
                    <td><?php echo htmlspecialchars($row['nombre_producto']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <button type="submit">Confirmar Selección</button>
</form>
<?php
$con->close();
?>
