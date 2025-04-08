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
include 'solicitudes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Asegúrate de que los campos existen en el formulario
    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $nombre_completo = $_POST['nombre_completo'];
    $direccion_residencia = $_POST['direccion_residencia'];
    $indicaciones = $_POST['indicaciones'];
    $ciudad_residencia = $_POST['ciudad_residencia'];
    $departamento_residencia = $_POST['departamento_residencia'];
    $correo_electronico = $_POST['correo_electronico'];
    $confirma_correo = $_POST['confirma_correo'];
    $celular = $_POST['celular'];
    $confirma_celular = $_POST['confirma_celular'];
    $cargar_orden = $_POST['cargar_orden'];
    $orden_medica = $_POST['orden_medica'];
    $confirma_terminos = isset($_POST['confirma_terminos']) ? 1 : 0;
    

    try {
        $Solicitudes = AutorizarSolicitud::crearSolicitud(
            $tipo_documento,
            $numero_documento,
            $nombre_completo,
            $direccion_residencia,
            $indicaciones,
            $ciudad_residencia,
            $departamento_residencia,
            $correo_electronico,
            $confirma_correo,
            $celular,
            $confirma_celular,
            $cargar_orden,
            $orden_medica,
            $confirma_terminos
        );

    
        $conexion1 = Conexion1::conectar();
        $Solicitudes->conectar($conexion1);
        header("Location: Solicitud_Exitosa.html");
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