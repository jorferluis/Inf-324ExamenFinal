<?php
session_start();
include "conectar.inc.php";

// Verificar que se haya recibido el id_despacho
if (!isset($_POST['id_despacho'])) {
    die("No se recibió el ID del despacho.");
}

$idDespacho = $_POST['id_despacho'];

// Verificar que el despacho exista y esté en estado 'Completado'
$query = "SELECT descripcion FROM Despachos WHERE id_despacho = ? AND estado = 'Completado'";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $idDespacho);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("El despacho no existe o no está en estado 'Completado'.");
}

$row = $result->fetch_assoc();
$descripcion = $row['descripcion'];

// Actualizar el estado del despacho a 'Cerrado'
$query = "UPDATE Despachos SET estado = 'Cerrado' WHERE id_despacho = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $idDespacho);

if ($stmt->execute()) {
    echo "El despacho '$descripcion' ha sido cerrado exitosamente.";
    // Eliminar la sesión para evitar reutilización
    unset($_SESSION['id_despacho']);
} else {
    die("Error al cerrar el despacho: " . $stmt->error);
}

$stmt->close();
$con->close();
?>
