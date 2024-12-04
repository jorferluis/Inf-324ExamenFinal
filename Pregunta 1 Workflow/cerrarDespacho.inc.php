<?php
session_start();
include "conectar.inc.php";

// Verificar que se haya seleccionado un despacho en el proceso anterior
if (!isset($_SESSION['id_despacho'])) {
    die("No se seleccionó ningún despacho en el proceso anterior.");
}

$idDespacho = $_SESSION['id_despacho'];

// Consultar detalles del despacho seleccionado
$query = "SELECT id_despacho, descripcion FROM Despachos WHERE id_despacho = ? AND estado = 'Completado'";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $idDespacho);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("El despacho seleccionado no está en estado 'Completado'.");
}

$row = $result->fetch_assoc();
?>

<h1>Cerrar Despacho</h1>

<!-- Formulario para cerrar el despacho -->
<form action="cerrarDespachoUp.inc.php" method="POST">
    <p><strong>Despacho Seleccionado:</strong> <?php echo htmlspecialchars($row['descripcion']); ?></p>
    <input type="hidden" name="id_despacho" value="<?php echo htmlspecialchars($row['id_despacho']); ?>">
    <button type="submit">Cerrar Despacho</button>
</form>

<?php
$stmt->close();
$con->close();
?>
