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
include 'tiroides_doc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Asegúrate de que los campos existen en el formulario
    $medico_tratante = $_POST['medico_tratante'];
    $nombre_medicamento = $_POST['nombre_medicamento'];
    $dosificacion = $_POST['dosificacion'];
    $descripcion = $_POST['descripcion'];
    $laboratorio = $_POST['laboratorio'];
    $concentracion_medicamento = $_POST['concentracion_medicamento'];
    $ruta_administracion = $_POST['ruta_administracion'];
    $estado_medicamento = $_POST['estado_medicamento'];
    

    try {
        $Tiroides = AsignarMedicamento::crearMedicamento(
            $medico_tratante,
            $nombre_medicamento,
            $dosificacion,
            $descripcion,
            $laboratorio,
            $concentracion_medicamento,
            $ruta_administracion,
            $estado_medicamento
        );

    

        $conexion1 = Conexion1::conectar();
        $Tiroides->conectar($conexion1);
        header("Location: asignacion_exitosa.html");
        exit();

    } catch (PDOException $e) {
        echo "Error en la base de datos:" . $e->getMessage();
    }

/*
        $conexion1 = Conexion1::conectar();
        $Tiroides->conectar($conexion1);
        echo "¡Asignación Exitosa!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

*/

}
?>