<?php
// Conexión a la base de datos
include('conectar.inc.php');

// Consultar los productos existentes
$query = "SELECT id_producto, nombre_producto FROM Productos";
$resultado = mysqli_query($con, $query);

if (!$resultado) {
    die("Error al obtener los productos: " . mysqli_error($con));
}

while ($row = mysqli_fetch_assoc($resultado)): ?>
    <label>
        <input type="checkbox" name="productos[]" value="<?= $row['id_producto'] ?>">
        <?= $row['nombre_producto'] ?>
    </label><br>
<?php endwhile;
?>
