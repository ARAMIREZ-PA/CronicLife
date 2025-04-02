<?php

abstract class Vehiculo {

    protected $marca;
    protected $modelo;

    protected $distancia;

    protected $costoPorKm;

    public function __construct($marca, $modelo, $distancia, $costoPorKm) {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->distancia = $distancia;
        $this->costoPorKm = $costoPorKm;
    }
    public function __getMarca()
{
    return $this->marca;
}

public function setMarca($marca) {
    $this->marca = $marca;
}


public function __getModelo()
{
    return $this->modelo;
}

public function setModelo($modelo) {
    $this->modelo = $modelo;
}

public function __getDistancia()
{
    return $this->distancia;
}

public function setDistancia($distancia) {
    $this->distancia = $distancia;
}


public function __getCostoPorKm()
{
    return $this->costoPorKm;
}

public function setCostoPorKm($costoPorKm) {
    $this->costoPorKm = $costoPorKm;
}

abstract public function guardar($conexion);

}

class Moto extends Vehiculo {

    public function guardar($conexion) {

        $sql = "INSERT INTO vehiculos (marca, modelo, tipo) VALUES (?,?, 'moto')";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $this->marca, $this->modelo );
        $stmt->execute();
        $id = $conexion->insert_id;
    
        $sqlMoto = "INSERT INTO moto (id, distancia, costoPorKm) VALUES (?,?,?) ";
        $stmtMoto = $conexion->prepare($sqlMoto);
        $stmtMoto->bind_param("idd", $id, $this->distancia, $this->costoPorKm);
        $stmtMoto->execute();
    
}
    

}


class Auto extends Vehiculo {

    public function guardar($conexion) {

        $sql = "INSERT INTO vehiculos (marca, modelo, tipo) VALUES (?,?, 'auto') ";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $this->marca, $this->modelo );
        $stmt->execute();
        $id = $conexion->insert_id;
    
        $sqlAuto = "INSERT INTO auto (id, distancia, costoPorKm) VALUES (?,?,?) ";
        $stmtAuto = $conexion->prepare($sqlAuto);
        $stmtAuto->bind_param("idd", $id, $this->distancia, $this->costoPorKm);
        $stmtAuto->execute();
    
}

}

class Camion extends Vehiculo {
    
    public function guardar($conexion) {

        $sql = "INSERT INTO vehiculos (marca, modelo, tipo) VALUES (?,?, 'camion') ";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $this->marca, $this->modelo );
        $stmt->execute();
        $id = $conexion->insert_id;
    
        $sqlCamion = "INSERT INTO camion (id, distancia, costoPorKm) VALUES (?,?,?) ";
        $stmtCamion = $conexion->prepare($sqlCamion);
        $stmtCamion->bind_param("idd", $id, $this->distancia, $this->costoPorKm);
        $stmtCamion->execute();
    
}

    }

    function crearVehiculo($tipo,$marca,$modelo,$distancia,$costoPorKm): Vehiculo{
        switch ($tipo) {
            case 'moto':
                return new Moto($marca, $modelo, $distancia,$costoPorKm);
                
            case 'auto':
                return new Auto($marca, $modelo, $distancia,$costoPorKm);
     
            case 'camion':
                return new Camion($marca, $modelo, $distancia,$costoPorKm);
                        
                default:
                throw new Exception("Tipo de vehiculo no valido");
    }


    }


?>