<?php
// Conexión a la base de datos
include('conectar.inc.php');

// Iniciar la sesión
session_start();

// Consultar los productos existentes
$query = "SELECT id_producto, nombre_producto FROM Productos";
$resultado = mysqli_query($con, $query);

if (!$resultado) {
    die("Error al obtener los productos: " . mysqli_error($con));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $productos = isset($_POST['productos']) ? $_POST['productos'] : [];
    $observaciones = mysqli_real_escape_string($con, $_POST['observaciones']);

    if (!empty($productos)) {
        // Registrar la recepción general
        $queryRecepcion = "INSERT INTO Recepciones (fecha, observaciones) VALUES (NOW(), '$observaciones')";
        $resultadoRecepcion = mysqli_query($con, $queryRecepcion);

        if ($resultadoRecepcion) {
            // Obtener el ID de la recepción generada
            $idRecepcion = mysqli_insert_id($con);

            // Guardar el ID de la recepción y los productos seleccionados en la sesión
            $_SESSION['id_recepcion'] = $idRecepcion;
            $_SESSION['productos_seleccionados'] = $productos;

            echo "Recepción registrada con éxito. Se han guardado los productos seleccionados.";
            header('Location: flujo.php?flujo=F2&proceso=P2'); // Redirigir a proceso P2
            exit;
        } else {
            echo "Error al registrar la recepción: " . mysqli_error($con);
        }
    } else {
        echo "No se seleccionaron productos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Recepción</title>
    <script>
        // Actualizar la lista de productos sin recargar la página
        async function actualizarProductos() {
            const respuesta = await fetch('actualizarListaProductos.inc.php');
            const listaProductos = await respuesta.text();
            document.getElementById('listaProductos').innerHTML = listaProductos;
        }
    </script>
</head>
<body>
    <h1>Registrar Recepción</h1>
    
    <form action="registrarRecepcion.inc.php" method="POST">
        <div id="listaProductos">
            <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <label>
                    <input type="checkbox" name="productos[]" value="<?= $row['id_producto'] ?>">
                    <?= $row['nombre_producto'] ?>
                </label><br>
            <?php endwhile; ?>
        </div>

        <div>
            <label for="observaciones">Observaciones:</label><br>
            <textarea name="observaciones" rows="4" cols="50" placeholder="Escriba aquí las observaciones..." required></textarea>
        </div>

        <button type="submit">Registrar Recepción</button>
    </form>
    
    <form action="añadirProducto.inc.php" method="POST" onsubmit="setTimeout(actualizarProductos, 500); return true;">
        <h2>Añadir Nuevo Producto</h2>
        <label for="nombre">Nombre del Producto:</label><br>
        <input type="text" name="nombre_producto" required><br>
        
        <label for="descripcion">Descripción:</label><br>
        <textarea name="descripcion" rows="4" cols="50" placeholder="Escriba aquí la descripción..."></textarea><br>
        
        <label for="cantidad">Cantidad:</label><br>
        <input type="number" name="cantidad" min="1" required><br>
        
        <button type="submit">Añadir Producto</button>
    </form>
</body>
</html>
