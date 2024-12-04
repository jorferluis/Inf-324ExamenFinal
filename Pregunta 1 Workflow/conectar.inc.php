<?php
$con = mysqli_connect("localhost", "root", "", "controlenvios");


if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}


