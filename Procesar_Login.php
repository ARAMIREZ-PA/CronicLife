<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Datos recibidos:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "No se ha enviado ningún formulario aún.";
}

include 'conexion.php';
include 'login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Asegúrate de que los campos existen en el formulario

    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $password = $_POST['password'];
    $fecha_inicio = $_POST['fecha_inicio']; // Asegúrate de agregar este campo al formulario

    try {
        $Sesion = InicioSesion::crearSesion(
            $tipo_documento,
            $numero_documento,
            $password,
            $fecha_inicio
        );

    
        $conexion1 = Conexion1::conectar();
        $Sesion->conectar($conexion1);
        header("Location: Croniclife.html");
        exit();

    } catch (PDOException $e) {
        echo "Error en la base de datos:" . $e->getMessage();
    }
    


/*
        $conexion1 = Conexion1::conectar();
        $Sesion->conectar($conexion1);
        echo "¡Ingreso Exitoso!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
*/


}
?>