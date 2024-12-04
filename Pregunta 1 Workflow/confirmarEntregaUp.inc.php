<?php
session_start();
include "conectar.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que se haya seleccionado un despacho
    if (empty($_POST['id_despacho'])) {
        die("Debe seleccionar un despacho.");
    }

    $idDespacho = $_POST['id_despacho'];

    // Cambiar el estado del despacho a "Completado"
    $query = "UPDATE Despachos 
            SET estado = 'Completado' 
            WHERE id_despacho = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $idDespacho);

    if ($stmt->execute()) {
        // Guardar el despacho seleccionado en la sesión para usarlo en P5
        $_SESSION['id_despacho'] = $idDespacho;

        // Redirigir al siguiente proceso P5
        header("Location: flujo.php?flujo=F1&proceso=P5");
        exit();
    } else {
        die("Error al actualizar el estado del despacho: " . $stmt->error);
    }
}
?>
