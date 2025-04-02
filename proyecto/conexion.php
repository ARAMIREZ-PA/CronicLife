<?php
$host = "localhost";
$username = "root"; // Cambia este valor si tu usuario es diferente
$password = ""; // Cambia este valor si tienes una contraseña
$dbname = "gestion_vehiculos";
//$port=3306;

$conexion = new mysqli($host, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}
?>