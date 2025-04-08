<?php

class Conexion1 {

private static $host = "localhost";
private static $dbname = "croniclife";
private static $username = "root"; // Cambia este valor si tu usuario es diferente
private static $password = "admin";     // Cambia este valor si tienes una contraseña

//$conexion = new mysqli($host, $username, $password, $dbname);

public static function conectar() {
    try {
        $conexion = new PDO("mysql:host=localhost;dbname=croniclife", "root", "admin");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error en la conexión en la base de datos intente más tarde: " . $e->getMessage());
    }
}

}
?>

