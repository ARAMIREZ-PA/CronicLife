<?php
require_once 'conexion.php';
require_once 'usuarioabstracto.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id_rol = $_POST['id_rol'];

    $usuario = UsuarioFactory::crearUsuario($nombre, $correo, $direccion, $username, $password, $id_rol);

    // Validar usuario y contraseña
   
    $validacionUsuario = $usuario->validarUsuario();
    $validacionPassword = $usuario->validarPassword();

    if ($validacionUsuario === true && $validacionPassword === true) {
        $conexion = Conexion1::conectar();
        $stmt = $conexion->prepare("INSERT INTO usuario (nombre, correo, direccion, username, password, id_rol) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $direccion, $username, password_hash($password, PASSWORD_BCRYPT), $id_rol]);
        echo "¡Usuario registrado exitosamente!";
    } else {
        echo $validacionUsuario !== true ? $validacionUsuario : $validacionPassword;
    }
}

?>