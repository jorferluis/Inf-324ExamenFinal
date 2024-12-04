<?php
// Conexión a la base de datos
include "conectar.inc.php";

// Obtener los parámetros de la URL
$flujo = isset($_GET["flujo"]) ? $_GET["flujo"] : null;
$proceso = isset($_GET["proceso"]) ? $_GET["proceso"] : null;

// Validar que los parámetros existen
if (!$flujo || !$proceso) {
    die("Faltan los parámetros 'flujo' o 'proceso' en la URL.");
}

// Consultar la base de datos para obtener la información del proceso
$sql = "SELECT * FROM flujoprocesos WHERE flujo='$flujo' AND proceso='$proceso'";
$resultado = mysqli_query($con, $sql);

// Validar que la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($con));
}

$fila = mysqli_fetch_array($resultado);
$pantalla = $fila["pantalla"];
$siguiente = $fila["siguiente"]; // Obtener el siguiente proceso

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Flujo de Proceso</title>
</head>
<body>
    <h1>Proceso: <?php echo $proceso; ?></h1>

    <?php 
    // Aquí mostramos la pantalla correspondiente, que manejará su propio formulario.
    include $pantalla . ".inc.php"; 
    ?>
    </br>
    <!-- Botones de navegación -->
    <form action="controlador.php" method="GET">
        <input type="hidden" name="flujo" value="<?php echo $flujo; ?>">
        <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">
        <input type="submit" value="Anterior" name="Anterior">
        <input type="submit" value="Siguiente" name="Siguiente">
    </form>


    <?php
    // Lógica para manejar la redirección al siguiente proceso
    if (isset($_GET['Siguiente']) && $siguiente) {
        // Si hay un siguiente proceso, redirigir a él
        header("Location: flujo.php?flujo=$flujo&proceso=$siguiente");
        exit;  // Asegúrate de salir para evitar seguir ejecutando el código
    }
    ?>
</body>
</html>
