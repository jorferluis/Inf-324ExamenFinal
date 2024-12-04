<?php
// Conexión a la base de datos
require_once('conectar.inc.php');

// Validar si se enviaron datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_despacho']) && !empty($_POST['id_transporte'])) {
    $id_despacho = (int)$_POST['id_despacho'];
    $id_transporte = (int)$_POST['id_transporte'];

    // Iniciar transacción para garantizar consistencia
    $con->begin_transaction();
    try {
        // Verificar que el transporte está disponible
        $queryVerificar = "SELECT disponible FROM Transporte WHERE id_transporte = ?";
        $stmt = $con->prepare($queryVerificar);
        $stmt->bind_param('i', $id_transporte);
        $stmt->execute();
        $stmt->bind_result($disponible);
        $stmt->fetch();
        $stmt->close();

        if (!$disponible) {
            throw new Exception("El transporte seleccionado no está disponible.");
        }


        // Marcar el transporte como no disponible
        $queryActualizarTransporte = "UPDATE Transporte SET disponible = 0 WHERE id_transporte = ?";
        $stmt = $con->prepare($queryActualizarTransporte);
        $stmt->bind_param('i', $id_transporte);
        $stmt->execute();
        $stmt->close();

        // Registrar en el flujo de seguimiento
        $querySeguimiento = "INSERT INTO FlujoSeguimiento (flujo, proceso, usuario, fecha_inicio) 
                            VALUES ('F1', 'P2', ?, NOW())";
        $stmt = $con->prepare($querySeguimiento);
        $usuario_id = 1; // Cambiar por el ID del usuario actual (de la sesión, por ejemplo)
        $stmt->bind_param('i', $usuario_id);
        $stmt->execute();
        $stmt->close();

        // Confirmar transacción
        $con->commit();
        echo "Transporte asignado correctamente.";
        header('Location: flujo.php?flujo=F1&proceso=P3');
        exit;
    } catch (Exception $e) {
        // Revertir los cambios si ocurre un error
        $con->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Por favor selecciona un despacho y un transporte.";
}
?>
