<?php
// Conexión a la base de datos
require_once('conectar.inc.php');

// Obtener lista de transportes disponibles
$queryTransportes = "SELECT id_transporte, nombre_transporte, capacidad FROM transporte WHERE disponible = 1";
$resultTransportes = $con->query($queryTransportes);

// Obtener lista de despachos pendientes
$queryDespachos = "SELECT id_despacho, descripcion FROM despachos WHERE estado = 'Pendiente'";
$resultDespachos = $con->query($queryDespachos);
?>

<h1>Asignar Transporte</h1>

<form action="asignarTransporteUp.inc.php" method="POST">
    <label for="id_despacho">Selecciona el despacho:</label>
    <select name="id_despacho" id="id_despacho" required>
        <option value="">--Selecciona un despacho--</option>
        <?php while ($row = $resultDespachos->fetch_assoc()): ?>
            <option value="<?php echo $row['id_despacho']; ?>">
                <?php echo htmlspecialchars($row['descripcion']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <label for="id_transporte">Selecciona el transporte:</label>
    <select name="id_transporte" id="id_transporte" required>
        <option value="">--Selecciona un transporte--</option>
        <?php while ($row = $resultTransportes->fetch_assoc()): ?>
            <option value="<?php echo $row['id_transporte']; ?>">
                <?php echo htmlspecialchars($row['nombre_transporte']) . " (Capacidad: " . $row['capacidad'] . ")"; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <button type="submit">Asignar Transporte</button>
</form>
