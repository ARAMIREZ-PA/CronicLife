<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Datos recibidos:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "No se ha enviado ningún formulario aún.";
}



abstract class Tiroides
{

    protected $medico_tratante;
    protected $nombre_medicamento;
    protected $dosificacion;
    protected $descripcion;
    protected $laboratorio;
    protected $concentracion_medicamento;
    protected $ruta_administracion;
    protected $estado_medicamento;
    


    public function __construct(
        $medico_tratante,
        $nombre_medicamento,
        $dosificacion,
        $descripcion,
        $laboratorio,
        $concentracion_medicamento,
        $ruta_administracion,
        $estado_medicamento
    ) {

        $this->medico_tratante = $medico_tratante;
        $this->nombre_medicamento = $nombre_medicamento;
        $this->dosificacion = $dosificacion;
        $this->descripcion = $descripcion;
        $this->laboratorio = $laboratorio;
        $this->concentracion_medicamento = $concentracion_medicamento;
        $this->ruta_administracion = $ruta_administracion;
        $this->estado_medicamento = $estado_medicamento;

    }

    public function getMedico_tratante()
    {
        return $this -> medico_tratante;
    }
    
    public function setMedico_tratante($medico_tratante)
    {
        $this -> medico_tratante=$medico_tratante;
    }
    
    public function getNombre_medicamento(){
        return $this -> nombre_medicamento;
    }
    
    public function setNombre_medicamento($nombre_medicamento){
        $this -> nombre_medicamento=$nombre_medicamento;
    }
    
    public function getDosificacion(){
        return $this -> dosificacion;
    }
    
    public function setDosificacion($dosificacion){
        $this -> dosificacion=$dosificacion;  
    }
    
    public function getDescripcion(){
        return $this -> descripcion;
    }
    
    public function setDescripcion($descripcion){
        $this -> descripcion=$descripcion;    
    }
    
    public function getLaboratorio(){
        return $this -> laboratorio;
    }
    
    public function setLaboratorio($laboratorio){
        $this -> laboratorio=$laboratorio;    
    }
    
    public function getConcentracion_medicamento(){
        return $this -> concentracion_medicamento;
    }
    
    public function setConcentracion_medicamento($concentracion_medicamento){
        $this -> concentracion_medicamento=$concentracion_medicamento;
    }

    public function getRuta_administracion(){
        return $this -> ruta_administracion;
    }
    
    public function setRuta_administracion($ruta_administracion){
        $this -> ruta_administracion=$ruta_administracion;
    }
    
    public function getEstado_medicamento(){
        return $this -> estado_medicamento;
    }
    
    public function setEstado_medicamento($estado_medicamento){
        $this -> estado_medicamento=$estado_medicamento;
    }
    

    abstract public function conectar($conexion);
    abstract public function ActualizarMedicamento($conexion, $id);

}

class Medicamento extends Tiroides
{
    //public $conexion= Conexion1::conectar();
    public function conectar($conexion): void
    {

        $conexion = Conexion1::conectar();
    

        // Insertar en tabla inicio_sesion
        $sql = "INSERT INTO medicamentos (MEDICO_TRATANTE, NOMBRE_MEDICAMENTO, DOSIFICACION, DESCRIPCION, LABORATORIO,
        CONCENTRACION_MEDICAMENTO, RUTA_ADMINISTRACION, ESTADO_MEDICAMENTO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $this->medico_tratante, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->nombre_medicamento, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->dosificacion, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->descripcion, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->laboratorio, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->concentracion_medicamento, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->ruta_administracion, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->estado_medicamento, PDO::PARAM_STR);
        $stmt->execute();
        $id = $conexion->lastInsertId();

    }


    public function ActualizarMedicamento($conexion, $id): void
    {
        // Actualización específica para Moto
        $sqlTiroides = "UPDATE medicamentos SET DOSIFICACION = ?, LABORATORIO = ? WHERE id = ?";
        $stmtTiroides = $conexion->prepare($sqlTiroides);
        $stmtTiroides->execute([$this->dosificacion, $this->laboratorio, $id]);

        $sqlMedicamento = "UPDATE medicamentos SET DOSIFICACION = ?, LABORATORIO = ? WHERE id = ?";
        $stmtMedicamento = $conexion->prepare($sqlMedicamento);
        $stmtMedicamento->execute([$this->dosificacion, $this->laboratorio, $id]);
    }


    public function borrarTiroides($conexion, $id)
    {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();


            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM medicamentos WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM medicamentos WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Medicamento asignado Exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al asignar medicamento: " . $e->getMessage();
        }
    }
    
}

class AsignarMedicamento
{
    public static function crearMedicamento(
        $medico_tratante,
        $nombre_medicamento,
        $dosificacion,
        $descripcion,
        $laboratorio,
        $concentracion_medicamento,
        $ruta_administracion,
        $estado_medicamento
    ) {
        return new Medicamento(
            $medico_tratante,
            $nombre_medicamento,
            $dosificacion,
            $descripcion,
            $laboratorio,
            $concentracion_medicamento,
            $ruta_administracion,
            $estado_medicamento
        );
    }

}


?>