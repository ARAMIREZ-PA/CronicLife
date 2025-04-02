<!DOCTYPE html>
<html>
<head>
    <title>Registro de Vehículos</title>
</head>
<body>
    <h1>Registrar Vehículo</h1>
    <form action="procesar.php" method="POST">
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required><br><br>
 
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required><br><br>
 
        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="moto">Moto</option>
            <option value="auto">Auto</option>
            <option value="camion">Camión</option>
        </select><br><br>
 
        <label for="distancia">Distancia (km):</label>
        <input type="number" id="distancia" name="distancia" step="0.01" required><br><br>
 
        <label for="costoPorKm">Costo por Km:</label>
        <input type="number" id="costoPorKm" name="costoPorKm" step="0.01" required><br><br>
 
        <button type="submit">Registrar</button>
    </form>
</body>
</html>