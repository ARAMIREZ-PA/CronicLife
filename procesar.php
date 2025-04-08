<?php
include 'conexion.php';
include 'clases.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $tipo = $_POST['tipo'];
    $distancia = $_POST['distancia'];
    $costoPorKm = $_POST['costoPorKm'];

    try {
        $vehiculo = crearVehiculo($tipo, $marca, $modelo, $distancia, $costoPorKm);
        $conexion1 = Conexion1::conectar();
        $vehiculo->conectar($conexion1);
        echo "¡Vehículo registrado exitosamente!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>