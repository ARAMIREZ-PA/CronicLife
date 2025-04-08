<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Datos recibidos:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "No se ha enviado ningún formulario aún.";
}


abstract class Solicitudes
{

    protected $tipo_documento;
    protected $numero_documento;
    protected $nombre_completo;
    protected $direccion_residencia;
    protected $indicaciones;
    protected $ciudad_residencia;
    protected $departamento_residencia;
    protected $correo_electronico;
    protected $confirma_correo;
    protected $celular;
    protected $confirma_celular;
    protected $cargar_orden;
    protected $orden_medica;
    protected $confirma_terminos;
    


    public function __construct(
        $tipo_documento,
        $numero_documento,
        $nombre_completo,
        $direccion_residencia,
        $indicaciones,
        $ciudad_residencia,
        $departamento_residencia,
        $correo_electronico,
        $confirma_correo,
        $celular,
        $confirma_celular,
        $cargar_orden,
        $orden_medica,
        $confirma_terminos
    ) {

        $this->tipo_documento = $tipo_documento;
        $this->numero_documento = $numero_documento;
        $this->nombre_completo = $nombre_completo;
        $this->direccion_residencia = $direccion_residencia;
        $this->indicaciones = $indicaciones;
        $this->ciudad_residencia = $ciudad_residencia;
        $this->departamento_residencia = $departamento_residencia;
        $this->correo_electronico = $correo_electronico;
        $this->confirma_correo = $confirma_correo;
        $this->celular = $celular;
        $this->confirma_celular = $confirma_celular;
        $this->cargar_orden = $cargar_orden;
        $this->orden_medica = $orden_medica;
        $this->confirma_terminos = $confirma_terminos;

    }

    public function getTipo_documento()
    {
        return $this -> tipo_documento;
    }
    
    public function setTipo_documento($tipo_documento)
    {
        $this -> tipo_documento=$tipo_documento;
    }
    
    public function getNumero_documento(){
        return $this -> numero_documento;
    }
    
    public function setNumero_documento($numero_documento){
        $this -> numero_documento=$numero_documento;
    }
    
    public function getNombre_completo(){
        return $this -> nombre_completo;
    }
    
    public function setNombre_completo($nombre_completo){
        $this -> nombre_completo=$nombre_completo;  
    }
    
    public function getDireccion_residencia(){
        return $this -> direccion_residencia;
    }
    
    public function setDireccion_residencia($direccion_residencia){
        $this -> direccion_residencia=$direccion_residencia;    
    }
    
    public function getIndicaciones(){
        return $this -> indicaciones;
    }
    
    public function setIndicaciones($indicaciones){
        $this -> indicaciones=$indicaciones;    
    }
    
    public function getCiudad_residencia(){
        return $this -> ciudad_residencia;
    }
    
    public function setCiudad_residencia($ciudad_residencia){
        $this -> ciudad_residencia=$ciudad_residencia;
    }

    public function getDepartamento_residencia(){
        return $this -> departamento_residencia;
    }
    
    public function setDepartamento_residencia($departamento_residencia){
        $this -> departamento_residencia=$departamento_residencia;
    }
    
    public function getCorreo_electronico(){
        return $this -> correo_electronico;
    }
    
    public function setCorreo_electronico($correo_electronico){
        $this -> correo_electronico=$correo_electronico;
    }
    
    
    public function getConfirma_correo(){
        return $this -> confirma_correo;
    }
    
    public function setConfirma_correo($confirma_correo){
        $this -> confirma_correo=$confirma_correo;
    }
    
    public function getCelular(){
        return $this -> celular;
    }
    
    public function setCelular($celular){
        $this -> celular=$celular;
    }
    
    public function getConfirma_celular(){
        return $this -> confirma_celular;
    }
    
    public function setConfirma_celular($confirma_celular){
        $this -> confirma_celular=$confirma_celular;
    }
    
    public function getCargar_orden(){
        return $this -> cargar_orden;
    }
    
    public function setCargar_orden($cargar_orden){
        $this -> cargar_orden=$cargar_orden;
    }

    public function getOrden_medica(){
        return $this -> orden_medica;
    }
    
    public function setOrden_medica($orden_medica){
        $this -> orden_medica=$orden_medica;
    }

    public function getConfirma_terminos(){
        return $this -> confirma_terminos;
    }
    
    public function setConfirma_terminos($confirma_terminos){
        $this -> confirma_terminos=$confirma_terminos;
    }


    abstract public function conectar($conexion);
    abstract public function ActualizarSolicitud($conexion, $id);

}

class Autorizar extends Solicitudes
{
    //public $conexion= Conexion1::conectar();
    public function conectar($conexion): void
    {

        $conexion = Conexion1::conectar();
    

        // Insertar en tabla inicio_sesion
        $sql = "INSERT INTO solicitudes (TIPO_DOCUMENTO, NUMERO_DOCUMENTO, NOMBRE_COMPLETO, DIRECCION_RESIDENCIA, INDICACIONES,
        CIUDAD, DEPARTAMENTO, CORREO_ELECTRONICO, CONFIRMACION_CORREO, CELULAR, CONFIRMACION_CELULAR, CARGAR_ORDEN_MEDICA, ORDEN_MEDICA,
        CONFIRMA_TERMINOS) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $this->tipo_documento, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->numero_documento, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->nombre_completo, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->direccion_residencia, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->indicaciones, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->ciudad_residencia, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->departamento_residencia, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->correo_electronico, PDO::PARAM_STR);
        $stmt->bindValue(9, $this->confirma_correo, PDO::PARAM_STR);
        $stmt->bindValue(10, $this->celular, PDO::PARAM_STR);
        $stmt->bindValue(11, $this->confirma_celular, PDO::PARAM_STR);
        $stmt->bindValue(12, $this->cargar_orden, PDO::PARAM_STR);
        $stmt->bindValue(13, $this->orden_medica, PDO::PARAM_STR);
        $stmt->bindValue(14, $this->confirma_terminos, PDO::PARAM_STR);
        $stmt->execute();
        $id = $conexion->lastInsertId();

    }


    public function ActualizarSolicitud($conexion, $id): void
    {
        // Actualización específica para Moto
        $sqlSolicitudes = "UPDATE solicitudes SET CIUDAD = ?, INDICACIONES = ? WHERE id = ?";
        $stmtSolicitudes = $conexion->prepare($sqlSolicitudes);
        $stmtSolicitudes->execute([$this->ciudad_residencia, $this->indicaciones, $id]);

        $sqlAutorizar = "UPDATE solicitudes SET CIUDAD = ?, INDICACIONES = ? WHERE id = ?";
        $stmtAutorizar = $conexion->prepare($sqlAutorizar);
        $stmtAutorizar->execute([$this->ciudad_residencia, $this->indicaciones, $id]);
    }


    public function borrarSolicitud($conexion, $id)
    {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();


            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM solicitudes WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM solicitudes WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Solicitud realizada Exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al Realizar Solicitud: " . $e->getMessage();
        }
    }
    
}


class AutorizarSolicitud
{
    public static function crearSolicitud(
        $tipo_documento,
        $numero_documento,
        $nombre_completo,
        $direccion_residencia,
        $indicaciones,
        $ciudad_residencia,
        $departamento_residencia,
        $correo_electronico,
        $confirma_correo,
        $celular,
        $confirma_celular,
        $cargar_orden,
        $orden_medica,
        $confirma_terminos
    ) {
        return new Autorizar(
            $tipo_documento,
            $numero_documento,
            $nombre_completo,
            $direccion_residencia,
            $indicaciones,
            $ciudad_residencia,
            $departamento_residencia,
            $correo_electronico,
            $confirma_correo,
            $celular,
            $confirma_celular,
            $cargar_orden,
            $orden_medica,
            $confirma_terminos
        );
    }

}


?>