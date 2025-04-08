<?php
interface Inventario{
    public function CuentaInventario();

}

class electronicos implements Inventario{
    public function CuentaInventario(){
        return "Existen 20 portátiles";
}
}
class Ropa implements Inventario{
    public function CuentaInventario(){
        return "Existen 15 unidades";
}
}
class Alimentos implements Inventario{
    public function CuentaInventario(){
        return "Existen 20 bolsas de leche";
}
}

class IventarioFactory {
    public static function CrearInventario($tipo){
        if ($tipo === 'electronicos'){
            return new electronicos();
        }elseif($tipo === 'Ropa'){
            return new Ropa();
    }else return new Alimentos();
}   

}
$Inventario1= IventarioFactory:: CrearInventario('electronicos');
echo $Inventario1->tipo();

$Inventario2= IventarioFactory:: CrearInventario('Ropa');
echo $Inventario2->tipo();

$Inventario3= IventarioFactory:: CrearInventario('Alimentos');
echo $Inventario3->tipo();
?>