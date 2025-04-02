<?php
include "conexion.php";
include "clases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $tipo = $_POST['tipo'];
    $distancia = $_POST['distancia'];
    $costoPorKm = $_POST['costoPorKm'];

    try {
        $vehiculo = crearVehiculo($tipo, $marca, $modelo, $distancia, $costoPorKm);
        $vehiculo->guardar($conexion);
        echo "¡Vehículo registrado exitosamente!";
    } catch (Exception $e) {
        echo "Error en la conexión a la base de datos intente más tarde" . $e->getMessage();
    }
}
?>
