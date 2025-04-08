<?php

abstract class Registro
{

    protected $tipo_documento;
    protected $numero_documento;
    protected $primer_nombre;

    protected $segundo_nombre;
    protected $primer_apellido;

    protected $segundo_apellido;

    protected $telefono_celular;

    protected $correo_electronico;

    protected $confirmacion_correo;

    protected $password;

    protected $confirma_password;

    protected $tipo_usuario;
    protected $fecha_inicio;



    public function __construct(
        $tipo_documento,
        $numero_documento,
        $primer_nombre,
        $segundo_nombre,
        $primer_apellido,
        $segundo_apellido,
        $telefono_celular,
        $correo_electronico,
        $confirmacion_correo,
        $password,
        $confirma_password,
        $Tipo_usuario,
        $fecha_inicio
    ) {

        $this->tipo_documento = $tipo_documento;
        $this->numero_documento = $numero_documento;
        $this->primer_nombre = $primer_nombre;
        $this->segundo_nombre = $segundo_nombre;
        $this->primer_apellido = $primer_apellido;
        $this->segundo_apellido = $segundo_apellido;
        $this->telefono_celular = $telefono_celular;
        $this->correo_electronico = $correo_electronico;
        $this->confirmacion_correo = $confirmacion_correo;
        $this->password = $password;
        $this->confirma_password = $confirma_password;
        $this->Tipo_usuario = $Tipo_usuario;
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

    public function getPrimer_nombre()
    {
        return $this->primer_nombre;
    }

    public function setPrimer_nombre($primer_nombre)
    {
        $this->primer_nombre = $primer_nombre;
    }

    public function getSegundo_nombre()
    {
        return $this->segundo_nombre;
    }

    public function setSegundo_nombre($segundo_nombre)
    {
        $this->segundo_nombre = $segundo_nombre;
    }

    public function getPrimer_apellido()
    {
        return $this->primer_apellido;
    }

    public function setPrimer_apellido($primer_apellido)
    {
        $this->primer_apellido = $primer_apellido;
    }

    public function getSegundo_apellido()
    {
        return $this->segundo_apellido;
    }

    public function setSegundo_apellido($segundo_apellido)
    {
        $this->segundo_apellido = $segundo_apellido;
    }

    public function getTelefono_celular()
    {
        return $this->telefono_celular;
    }

    public function setTelefono_celular($telefono_celular)
    {
        $this->telefono_celular = $telefono_celular;
    }

    public function getCorreo_electronico()
    {
        return $this->correo_electronico;
    }

    public function setCorreo_electronico($correo_electronico)
    {
        $this->correo_electronico = $correo_electronico;
    }

    public function getConfirmacion_correo()
    {
        return $this->confirmacion_correo;
    }

    public function setConfirmacion_correo($confirmacion_correo)
    {
        $this->confirmacion_correo = $confirmacion_correo;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getConfirma_password()
    {
        return $this->confirma_password;
    }

    public function setConfirma_password($confirma_password)
    {
        $this->confirma_password = $confirma_password;
    }

    public function getTipo_usuario()
    {
        return $this->Tipo_usuario;
    }

    public function setTipo_usuario($Tipo_usuario)
    {
        $this->Tipo_usuario = $Tipo_usuario;
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
    abstract public function ActualizarRegistro($conexion, $id);

}

class Paciente extends Registro
{
    //public $conexion= Conexion1::conectar();
    public function conectar($conexion): void
    {
        $sql = "INSERT INTO usuario (TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, 
        TEL_USUARIO, CORREO_USUARIO, CORREO_CONFIRMADO, PASSWORD_USUARIO, PASSWORD_CONFIRMADO, TIPO_USUARIO) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $conexion = Conexion1::conectar();
        $stmt = $conexion->prepare($sql);

        if (empty($this->password)) {
            throw new Exception("La contraseña está vacía al momento de hashear.");
        }
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);



        $stmt->bindValue(1, $this->tipo_documento, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->numero_documento, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->primer_nombre, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->segundo_nombre, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->primer_apellido, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->segundo_apellido, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->telefono_celular, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->correo_electronico, PDO::PARAM_STR);
        $stmt->bindValue(9, $this->confirmacion_correo, PDO::PARAM_STR);
        $stmt->bindValue(10, $hashedPassword, PDO::PARAM_STR); // PASSWORD_USUARIO
        $stmt->bindValue(11, $this->confirma_password, PDO::PARAM_STR); // PASSWORD_CONFIRMADO
        $stmt->bindValue(12, $this->Tipo_usuario, PDO::PARAM_STR); // TIPO_USUARIO
        $stmt->execute();
        $id = $conexion->lastInsertId();


        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        $fecha_inicio = date("Y-m-d");
        $sqlPaciente = "INSERT INTO inicio_sesion (id, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PASSWORD_USUARIO, FECHA_INGRESO) 
        VALUES (?, ?, ?, ?, ?)";
        $stmtPaciente = $conexion->prepare($sqlPaciente);
        $stmtPaciente->bindValue(1, $id, PDO::PARAM_INT);
        $stmtPaciente->bindValue(2, $this->tipo_documento, PDO::PARAM_STR);
        $stmtPaciente->bindValue(3, $this->numero_documento, PDO::PARAM_STR);
        $stmtPaciente->bindValue(4, $hashedPassword, PDO::PARAM_STR); // PASSWORD_USUARIO
        $stmtPaciente->bindValue(5, $this->fecha_inicio, PDO::PARAM_STR); // ← esta sí es la 3era, no una 4ta

        try {
            $stmtPaciente->execute();
        } catch (PDOException $e) {
            echo "Error al ejecutar INSERT en inicio_sesion: " . $e->getMessage();
        }

    }




    public function ActualizarRegistro($conexion, $id): void
    {
        // Actualización específica para Moto
        $sqlRegistro = "UPDATE usuario SET TEL_USUARIO = ?, CORREO_USUARIO = ? WHERE id = ?";
        $stmtRegistro = $conexion->prepare($sqlRegistro);
        $stmtRegistro->execute([$this->telefono_celular, $this->correo_electronico, $id]);

        $sqlPaciente = "UPDATE inicio_sesion SET FECHA_INGRESO = ? WHERE id = ?";
        $stmtPaciente = $conexion->prepare($sqlPaciente);
        $stmtPaciente->execute([$this->fecha_inicio, $id]);
    }


    public function borrarRegistro($conexion, $id)
    {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();


            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM usuario WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM inicio_sesion WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Paciente Eliminado Exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al Borrar Paciente: " . $e->getMessage();
        }
    }




}

//_____________________________________________________________________________________________________//

class Medico extends Registro
{
    public function conectar($conexion): void
    {
        $sql = "INSERT INTO usuario (TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, 
        TEL_USUARIO, CORREO_USUARIO, CORREO_CONFIRMADO, PASSWORD_USUARIO, PASSWORD_CONFIRMADO, TIPO_USUARIO) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $conexion = Conexion1::conectar();
        $stmt = $conexion->prepare($sql);

        if (empty($this->password)) {
            throw new Exception("La contraseña está vacía al momento de hashear.");
        }
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);



        $stmt->bindValue(1, $this->tipo_documento, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->numero_documento, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->primer_nombre, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->segundo_nombre, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->primer_apellido, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->segundo_apellido, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->telefono_celular, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->correo_electronico, PDO::PARAM_STR);
        $stmt->bindValue(9, $this->confirmacion_correo, PDO::PARAM_STR);
        $stmt->bindValue(10, $hashedPassword, PDO::PARAM_STR); // PASSWORD_USUARIO
        $stmt->bindValue(11, $this->confirma_password, PDO::PARAM_STR); // PASSWORD_CONFIRMADO
        $stmt->bindValue(12, $this->Tipo_usuario, PDO::PARAM_STR); // TIPO_USUARIO
        $stmt->execute();
        $id = $conexion->lastInsertId();


        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        $fecha_inicio = date("Y-m-d");
        $sqlMedico= "INSERT INTO inicio_sesion (id, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PASSWORD_USUARIO, FECHA_INGRESO) 
        VALUES (?, ?, ?, ?, ?)";
        $stmtMedico = $conexion->prepare($sqlMedico);
        $stmtMedico->bindValue(1, $id, PDO::PARAM_INT);
        $stmtMedico->bindValue(2, $this->tipo_documento, PDO::PARAM_STR);
        $stmtMedico->bindValue(3, $this->numero_documento, PDO::PARAM_STR);
        $stmtMedico->bindValue(4, $hashedPassword, PDO::PARAM_STR); // PASSWORD_USUARIO
        $stmtMedico->bindValue(5, $this->fecha_inicio, PDO::PARAM_STR); // ← esta sí es la 3era, no una 4ta

        try {
            $stmtMedico->execute();
        } catch (PDOException $e) {
            echo "Error al ejecutar INSERT en inicio_sesion: " . $e->getMessage();
        }

    }


    public function ActualizarRegistro($conexion, $id): void
    {
        // Actualización específica para Moto
        $sqlRegistro = "UPDATE usuario SET TEL_USUARIO = ?, CORREO_USUARIO = ? WHERE id = ?";
        $stmtRegistro = $conexion->prepare($sqlRegistro);
        $stmtRegistro->execute([$this->telefono_celular, $this->correo_electronico, $id]);

        $sqlMedico = "UPDATE inicio_sesion SET FECHA_INGRESO = ? WHERE id = ?";
        $stmtMedico = $conexion->prepare($sqlMedico);
        $stmtMedico->execute([$this->fecha_inicio, $id]);
    }


    public function borrarRegistro($conexion, $id)
    {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();


            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM usuario WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM inicio_sesion WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Medico Eliminado Exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al Borrar Medico: " . $e->getMessage();
        }
    }

}

//-------------------------------------------------------------------------------------------------------//



class Tecnico_Laboratorio extends Registro
{
    public function conectar($conexion): void
    {
        $sql = "INSERT INTO usuario (TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, 
        TEL_USUARIO, CORREO_USUARIO, CORREO_CONFIRMADO, PASSWORD_USUARIO, PASSWORD_CONFIRMADO, TIPO_USUARIO) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $conexion = Conexion1::conectar();
        $stmt = $conexion->prepare($sql);

        if (empty($this->password)) {
            throw new Exception("La contraseña está vacía al momento de hashear.");
        }
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);



        $stmt->bindValue(1, $this->tipo_documento, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->numero_documento, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->primer_nombre, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->segundo_nombre, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->primer_apellido, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->segundo_apellido, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->telefono_celular, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->correo_electronico, PDO::PARAM_STR);
        $stmt->bindValue(9, $this->confirmacion_correo, PDO::PARAM_STR);
        $stmt->bindValue(10, $hashedPassword, PDO::PARAM_STR); // PASSWORD_USUARIO
        $stmt->bindValue(11, $this->confirma_password, PDO::PARAM_STR); // PASSWORD_CONFIRMADO
        $stmt->bindValue(12, $this->Tipo_usuario, PDO::PARAM_STR); // TIPO_USUARIO
        $stmt->execute();
        $id = $conexion->lastInsertId();


        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        $fecha_inicio = date("Y-m-d");
        $sqlTecnico_Laboratorio= "INSERT INTO inicio_sesion (id, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PASSWORD_USUARIO, FECHA_INGRESO) 
        VALUES (?, ?, ?, ?, ?)";
        $stmtTecnico_Laboratorio = $conexion->prepare($sqlTecnico_Laboratorio);
        $stmtTecnico_Laboratorio->bindValue(1, $id, PDO::PARAM_INT);
        $stmtTecnico_Laboratorio->bindValue(2, $this->tipo_documento, PDO::PARAM_STR);
        $stmtTecnico_Laboratorio->bindValue(3, $this->numero_documento, PDO::PARAM_STR);
        $stmtTecnico_Laboratorio->bindValue(4, $hashedPassword, PDO::PARAM_STR); // PASSWORD_USUARIO
        $stmtTecnico_Laboratorio->bindValue(5, $this->fecha_inicio, PDO::PARAM_STR); // ← esta sí es la 3era, no una 4ta

        try {
            $stmtTecnico_Laboratorio->execute();
        } catch (PDOException $e) {
            echo "Error al ejecutar INSERT en inicio_sesion: " . $e->getMessage();
        }
    }

    public function ActualizarRegistro($conexion, $id): void
    {
        // Actualización específica para Moto
        $sqlRegistro = "UPDATE usuario SET TEL_USUARIO = ?, CORREO_USUARIO = ? WHERE id = ?";
        $stmtRegistro = $conexion->prepare($sqlRegistro);
        $stmtRegistro->execute([$this->telefono_celular, $this->correo_electronico, $id]);

        $sqlTecnico_Laboratorio = "UPDATE inicio_sesion SET FECHA_INGRESO = ? WHERE id = ?";
        $stmtTecnico_Laboratorio = $conexion->prepare($sqlTecnico_Laboratorio);
        $stmtTecnico_Laboratorio->execute([$this->fecha_inicio, $id]);
    }


    public function borrarRegistro($conexion, $id)
    {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();


            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM usuario WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM inicio_sesion WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Tecnico Laboratorio Eliminado Exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al Borrar Tecnico Laboratorio: " . $e->getMessage();
        }
    }

}

//_____________________________________________________________________________________________________//


class Administrador extends Registro
{
    public function conectar($conexion): void
    {
        $sql = "INSERT INTO usuario (TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, 
        TEL_USUARIO, CORREO_USUARIO, CORREO_CONFIRMADO, PASSWORD_USUARIO, PASSWORD_CONFIRMADO, TIPO_USUARIO) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $conexion = Conexion1::conectar();
        $stmt = $conexion->prepare($sql);

        if (empty($this->password)) {
            throw new Exception("La contraseña está vacía al momento de hashear.");
        }
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);



        $stmt->bindValue(1, $this->tipo_documento, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->numero_documento, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->primer_nombre, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->segundo_nombre, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->primer_apellido, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->segundo_apellido, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->telefono_celular, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->correo_electronico, PDO::PARAM_STR);
        $stmt->bindValue(9, $this->confirmacion_correo, PDO::PARAM_STR);
        $stmt->bindValue(10, $hashedPassword, PDO::PARAM_STR); // PASSWORD_USUARIO
        $stmt->bindValue(11, $this->confirma_password, PDO::PARAM_STR); // PASSWORD_CONFIRMADO
        $stmt->bindValue(12, $this->Tipo_usuario, PDO::PARAM_STR); // TIPO_USUARIO
        $stmt->execute();
        $id = $conexion->lastInsertId();


        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        $fecha_inicio = date("Y-m-d");
        $sqlAdministrador= "INSERT INTO inicio_sesion (id, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, PASSWORD_USUARIO, FECHA_INGRESO) 
        VALUES (?, ?, ?, ?, ?)";
        $stmtAdministrador = $conexion->prepare($sqlAdministrador);
        $stmtAdministrador->bindValue(1, $id, PDO::PARAM_INT);
        $stmtAdministrador->bindValue(2, $this->tipo_documento, PDO::PARAM_STR);
        $stmtAdministrador->bindValue(3, $this->numero_documento, PDO::PARAM_STR);
        $stmtAdministrador->bindValue(4, $hashedPassword, PDO::PARAM_STR); // PASSWORD_USUARIO
        $stmtAdministrador->bindValue(5, $this->fecha_inicio, PDO::PARAM_STR); // ← esta sí es la 3era, no una 4ta

        try {
            $stmtAdministrador->execute();
        } catch (PDOException $e) {
            echo "Error al ejecutar INSERT en inicio_sesion: " . $e->getMessage();
        }
    }



    public function ActualizarRegistro($conexion, $id): void
    {
        // Actualización específica para Moto
        $sqlRegistro = "UPDATE usuario SET TEL_USUARIO = ?, CORREO_USUARIO = ? WHERE id = ?";
        $stmtRegistro = $conexion->prepare($sqlRegistro);
        $stmtRegistro->execute([$this->telefono_celular, $this->correo_electronico, $id]);

        $sqlAdministrador = "UPDATE inicio_sesion SET FECHA_INGRESO = ? WHERE id = ?";
        $stmtAdministrador = $conexion->prepare($sqlAdministrador);
        $stmtAdministrador->execute([$this->fecha_inicio, $id]);
    }


    public function borrarRegistro($conexion, $id)
    {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();


            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM usuario WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM inicio_sesion WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Administrador Eliminado Exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al Borrar Administrador: " . $e->getMessage();
        }
    }

}



// Función Factory
function crearRegistro(
    $tipo_documento,
    $numero_documento,
    $primer_nombre,
    $segundo_nombre,
    $primer_apellido,
    $segundo_apellido,
    $telefono_celular,
    $correo_electronico,
    $confirmacion_correo,
    $password,
    $confirma_password,
    $Tipo_usuario,
    $fecha_inicio
): Paciente|Medico|Tecnico_Laboratorio|Administrador {

    echo "<pre>Tipo de usuario recibido:\n";
    var_dump($Tipo_usuario);
    echo "</pre>";

    $Tipo_usuario = trim($Tipo_usuario);
    switch ($Tipo_usuario) {
        case 'Paciente':
            return new Paciente(
                $tipo_documento,
                $numero_documento,
                $primer_nombre,
                $segundo_nombre,
                $primer_apellido,
                $segundo_apellido,
                $telefono_celular,
                $correo_electronico,
                $confirmacion_correo,
                $password,
                $confirma_password,
                $Tipo_usuario,
                $fecha_inicio
            );
        case 'Medico':
            return new Medico(
                $tipo_documento,
                $numero_documento,
                $primer_nombre,
                $segundo_nombre,
                $primer_apellido,
                $segundo_apellido,
                $telefono_celular,
                $correo_electronico,
                $confirmacion_correo,
                $password,
                $confirma_password,
                $Tipo_usuario,
                $fecha_inicio
            );
        case 'Tecnico_Laboratorio':
            return new Tecnico_Laboratorio(
                $tipo_documento,
                $numero_documento,
                $primer_nombre,
                $segundo_nombre,
                $primer_apellido,
                $segundo_apellido,
                $telefono_celular,
                $correo_electronico,
                $confirmacion_correo,
                $password,
                $confirma_password,
                $Tipo_usuario,
                $fecha_inicio
            );

        case 'Administrador':
            return new Administrador(
                $tipo_documento,
                $numero_documento,
                $primer_nombre,
                $segundo_nombre,
                $primer_apellido,
                $segundo_apellido,
                $telefono_celular,
                $correo_electronico,
                $confirmacion_correo,
                $password,
                $confirma_password,
                $Tipo_usuario,
                $fecha_inicio
            );

        default:
            throw new Exception("Tipo de Usuario no válido.");




    }


}


?>