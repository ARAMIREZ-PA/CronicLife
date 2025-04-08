<?php
interface Vehiculo{
    public function tipo();
} 
class Coche implements Vehiculo{
    public function tipo(){
        return "Soy un coche";
    }
}

class Motocicleta implements Vehiculo{

    public function tipo(){
        return "Soy una motocicleta";
    }
}

class VehiculoFactory {
    public static function crearVehiculo($tipo){
        if  ($tipo == 'motocicleta') {
            return new Motocicleta();
        }
        return null;echo "";
    }
}
$vehiculo1 = VehiculoFactory::crearVehiculo(tipo: 'coche');
echo $vehiculo1->tipo();

$vehiculo2 = VehiculoFactory::crearVehiculo(tipo: 'motocicleta');
echo $vehiculo2->tipo();


?>