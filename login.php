<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Datos recibidos:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "No se ha enviado ningún formulario aún.";
}

abstract class Sesion
{

    protected $tipo_documento;
    protected $numero_documento;
    protected $password;
    protected $fecha_inicio;



    public function __construct(
        $tipo_documento,
        $numero_documento,
        $password,
        $fecha_inicio
    ) {

        $this->tipo_documento = $tipo_documento;
        $this->numero_documento = $numero_documento;
        $this->password = $password;
        $this->fecha_inicio = $fecha_inicio;
    }

    public function getTipo_documento()
    {
        return $this->tipo_documento;
    }

    public function setTipo_documento($tipo_documento)
    {
        $this->tipo_documento = $tipo_documento;
    }

    public function getNumero_documento()
    {
        return $this->numero_documento;
    }

    public function setNumero_documento($numero_documento)
    {
        $this->numero_documento = $numero_documento;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getFecha_inicio()
    {
        return $this->fecha_inicio;
    }
    public function setFecha_inicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }



    abstract public function conectar($conexion);
    abstract public function ActualizarSesion($conexion, $id);

}

class Inicio extends Sesion
{
    //public $conexion= Conexion1::conectar();
    public function conectar($conexion): void
    {
        $fecha_inicio = date("Y-m-d");
        $conexion = Conexion1::conectar();
    
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        // Insertar en tabla inicio_sesion
        $sql = "INSERT INTO inicio_sesion (TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PASSWORD_USUARIO, FECHA_INGRESO) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $this->tipo_documento, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->numero_documento, PDO::PARAM_STR);
        $stmt->bindValue(3, $hashedPassword, PDO::PARAM_STR); // ✅ Aquí usamos el hash correcto
        $stmt->bindValue(4, $this->fecha_inicio, PDO::PARAM_STR);
        $stmt->execute();
    
        // Obtener el ID insertado
        $id = $conexion->lastInsertId();
    
        /*
        // Encriptar la contraseña
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
    
        // Insertar en tabla usuario
        $sqlInicio = "INSERT INTO inicio_sesion (id, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PASSWORD_USUARIO, FECHA_INGRESO) VALUES (?, ?, ?, ?, ?)";
        $stmtInicio = $conexion->prepare($sqlInicio);
        $stmtInicio->bindValue(1, $id, PDO::PARAM_INT);
        $stmtInicio->bindValue(2, $this->tipo_documento, PDO::PARAM_STR);
        $stmtInicio->bindValue(3, $this->numero_documento, PDO::PARAM_STR);
        $stmtInicio->bindValue(4, $hashedPassword, PDO::PARAM_STR); // ✅ Aquí usamos el hash correcto
        $stmtInicio->bindValue(5, $this->fecha_inicio, PDO::PARAM_STR);

        $stmtInicio->execute();
        */
    }


    public function ActualizarSesion($conexion, $id): void
    {
        // Actualización específica para Moto
        $sqlSesion = "UPDATE inicio_sesion SET FECHA_INGRESO = ? WHERE id = ?";
        $stmtSesion = $conexion->prepare($sqlSesion);
        $stmtSesion->execute([$this->fecha_inicio, $id]);

        $sqlInicio = "UPDATE inicio_sesion SET FECHA_INGRESO = ? WHERE id = ?";
        $stmtInicio = $conexion->prepare($sqlInicio);
        $stmtInicio->execute([$this->fecha_inicio, $id]);
    }


    public function borrarSesion($conexion, $id)
    {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();


            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM inicio_sesion WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM inicio_sesion WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Sesion Finalizada Exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al Finalizar Sesion: " . $e->getMessage();
        }
    }
    
}
class InicioSesion
{
    public static function crearSesion(
        $tipo_documento,
        $numero_documento,
        $password,
        $fecha_inicio
    ) {
        return new Inicio(
            $tipo_documento,
            $numero_documento,
            $password,
            $fecha_inicio
        );
    }


}


?>