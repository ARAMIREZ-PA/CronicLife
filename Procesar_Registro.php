<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

include 'conexion.php';
include 'registro_persona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Asegúrate de que los campos existen en el formulario

    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $telefono_celular = $_POST['telefono_celular'];
    $password = $_POST['password'];
    $confirma_password = $_POST['confirma_password'];
    $correo_electronico = $_POST['correo_electronico'];
    $confirmacion_correo = $_POST['confirmacion_correo'];
    $Tipo_usuario = $_POST['Tipo_usuario'];
    $fecha_inicio = $_POST['fecha_inicio']; // Asegúrate de agregar este campo al formulario

    try {
        $Registro = crearRegistro(
            $tipo_documento,
            $numero_documento,
            $primer_nombre,
            $segundo_nombre,
            $primer_apellido,
            $segundo_apellido,
            $telefono_celular,
            $correo_electronico,
            $confirmacion_correo,
            $password,
            $confirma_password,
            $Tipo_usuario,
            $fecha_inicio
        );


        $conexion1 = Conexion1::conectar();
        $Registro->conectar($conexion1);
        header("Location: Registro_exitoso.html");
        exit();

    } catch (PDOException $e) {
        echo "Error en la base de datos:" . $e->getMessage();
    }


/*
    $conexion1 = Conexion1::conectar();
    $Registro->conectar($conexion1);
    echo "¡Usuario registrado exitosamente!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
*/

}
?>