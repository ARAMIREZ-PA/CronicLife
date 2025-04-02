<?php
include 'conexion.php';
 
$sqlMoto = "SELECT v.marca, v.modelo, m.distancia, m.costoPorKm, (m.distancia * m.costoPorKm) AS costoTotal
            FROM moto m
            JOIN vehiculos v ON m.id = v.id";
 
$sqlAuto = "SELECT v.marca, v.modelo, a.distancia, a.costoPorKm, (a.distancia * a.costoPorKm) AS costoTotal
            FROM auto a
            JOIN vehiculos v ON a.id = v.id";
 
$sqlCamion = "SELECT v.marca, v.modelo, c.distancia, c.costoPorKm, (c.distancia * c.costoPorKm) AS costoTotal
              FROM camion c
              JOIN vehiculos v ON c.id = v.id";
 
// Ejecutar las consultas
$resultMoto = $conexion->query($sqlMoto);
$resultAuto = $conexion->query($sqlAuto);
$resultCamion = $conexion->query($sqlCamion);
 
// Generar el reporte
echo "<h1>Reporte de Costos por Ruta</h1>";
 
// Mostrar motos
echo "<h2>Motos</h2>";
if ($resultMoto->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Marca</th><th>Modelo</th><th>Distancia (km)</th><th>Costo/Km</th><th>Costo Total</th></tr>";
    while ($row = $resultMoto->fetch_assoc()) {
        echo "<tr>
                <td>{$row['marca']}</td>
                <td>{$row['modelo']}</td>
                <td>{$row['distancia']}</td>
                <td>{$row['costoPorKm']}</td>
                <td>{$row['costoTotal']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay datos de motos.";
}
 
// Mostrar autos
echo "<h2>Autos</h2>";
if ($resultAuto->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Marca</th><th>Modelo</th><th>Distancia (km)</th><th>Costo/Km</th><th>Costo Total</th></tr>";
    while ($row = $resultAuto->fetch_assoc()) {
        echo "<tr>
                <td>{$row['marca']}</td>
                <td>{$row['modelo']}</td>
                <td>{$row['distancia']}</td>
                <td>{$row['costoPorKm']}</td>
                <td>{$row['costoTotal']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay datos de autos.";
}
 
// Mostrar camiones
echo "<h2>Camiones</h2>";
if ($resultCamion->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Marca</th><th>Modelo</th><th>Distancia (km)</th><th>Costo/Km</th><th>Costo Total</th></tr>";
    while ($row = $resultCamion->fetch_assoc()) {
        echo "<tr>
                <td>{$row['marca']}</td>
                <td>{$row['modelo']}</td>
                <td>{$row['distancia']}</td>
                <td>{$row['costoPorKm']}</td>
                <td>{$row['costoTotal']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay datos de camiones.";
}
?>