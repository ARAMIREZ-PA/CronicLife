<?php
session_start(); // Reanuda la sesión iniciada

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['nombre']) . "</h1>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Opciones</h2>
    <form method="post" action="logout.php">
        <button type="submit">Cerrar Sesión</button>
    </form>
</body>
</html>
