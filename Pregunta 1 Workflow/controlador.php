<?php

// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar que los parámetros GET están presentes
if (!isset($_GET["flujo"]) || !isset($_GET["proceso"])) {
    die("Faltan los parámetros 'flujo' o 'proceso'.");
}

$flujo = $_GET["flujo"];
$proceso = $_GET["proceso"];
$accion = isset($_GET["Anterior"]) ? "Anterior" : (isset($_GET["Siguiente"]) ? "Siguiente" : null);

// Validar que se haya presionado un botón
if (!$accion) {
    die("No se recibió ninguna acción.");
}

// Conectar a la base de datos
include "conectar.inc.php";

// Consultar el proceso actual en la base de datos
$sql = "SELECT * FROM flujoprocesos WHERE flujo='$flujo' AND proceso='$proceso'";
$resultado = mysqli_query($con, $sql);

// Validar que la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($con));
}

// Verificar si el proceso fue encontrado
if (mysqli_num_rows($resultado) == 0) {
    die("No se encontró el proceso '$proceso' para el flujo '$flujo'.");
}

$fila = mysqli_fetch_array($resultado);
$siguiente = $fila["siguiente"];
$pantalla = $fila["pantalla"];

// Calcular el proceso anterior dinámicamente
$anterior = null;
$sql_anterior = "SELECT proceso FROM flujoprocesos WHERE flujo='$flujo' AND siguiente='$proceso'";
$resultado_anterior = mysqli_query($con, $sql_anterior);
if ($resultado_anterior && mysqli_num_rows($resultado_anterior) > 0) {
    $fila_anterior = mysqli_fetch_array($resultado_anterior);
    $anterior = $fila_anterior["proceso"];
}

// Lógica para manejar las acciones
if ($accion === "Siguiente") {
    if ($siguiente) {
        // Redirigir al siguiente proceso
        header("Location: flujo.php?flujo=$flujo&proceso=$siguiente");
        exit;
    } else {
        echo "No hay siguiente proceso.<br>";
    }
} elseif ($accion === "Anterior") {
    if ($anterior) {
        // Redirigir al proceso anterior
        header("Location: flujo.php?flujo=$flujo&proceso=$anterior");
        exit;
    } else {
        echo "No puedes retroceder desde el proceso inicial.<br>";
    }
}
?>
