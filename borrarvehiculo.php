<?php
require_once 'conexion.php';

// Obtener la lista de vehículos
try {
    $conexion = Conexion1::conectar();
    $sql = "SELECT id, marca, modelo,tipo FROM vehiculos"; // Consulta para obtener vehículos
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al obtener los vehículos: " . $e->getMessage();
}

// Procesar formulario para borrar vehículo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    if (empty($id) || empty($tipo)) {
        die("Por favor, selecciona un vehículo y su tipo para borrar.");
    }

    try {
        $conexion = Conexion1::conectar();

        switch ($tipo) {
            case 'moto':
                $tablaEspecifica = 'moto';
                break;
            case 'auto':
                $tablaEspecifica = 'auto';
                break;
            case 'camion':
                $tablaEspecifica = 'camion';
                break;
            default:
                throw new Exception("Tipo de vehículo no válido.");
        }

        $conexion->beginTransaction();

        // Borrar en la tabla específica
        $sqlEspecifico = "DELETE FROM $tablaEspecifica WHERE id = ?";
        $stmtEspecifico = $conexion->prepare($sqlEspecifico);
        $stmtEspecifico->execute([$id]);

        // Borrar en la tabla general
        $sqlGeneral = "DELETE FROM vehiculos WHERE id = ?";
        $stmtGeneral = $conexion->prepare($sqlGeneral);
        $stmtGeneral->execute([$id]);

        $conexion->commit();
        echo "¡Vehículo borrado exitosamente!";
    } catch (Exception $e) {
        $conexion->rollBack();
        echo "Error al borrar el vehículo: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrar Vehículo</title>
</head>
<body>
    <h1>Borrar Vehículo</h1>
    <form method="post">
        <label for="id">Selecciona el Vehículo:</label>
        <select name="id" id="id" required>
            <option value="">--Selecciona un Vehículo--</option>
            <?php if (!empty($vehiculos)) : ?>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <option value="<?= $vehiculo['id']; ?>">
                        ID: <?= $vehiculo['id']; ?> - <?= $vehiculo['marca']; ?> <?= $vehiculo['modelo']; ?> <?= $vehiculo['tipo']; ?>
                    </option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">No hay vehículos disponibles</option>
            <?php endif; ?>
        </select>
        <br><br>

        <label for="tipo">Tipo de Vehículo:</label>
        <select name="tipo" id="tipo" required>
            <option value="moto">Moto</option>
            <option value="auto">Auto</option>
            <option value="camion">Camión</option>
        </select>
        <br><br>

        <button type="submit">Borrar Vehículo</button>
    </form>
</body>
</html>