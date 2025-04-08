<?php

abstract class UsuarioAbstracto {
    protected $nombre;
    protected $username;
    protected $password;

    public function __construct($nombre, $username, $password) {
        $this->nombre = $nombre;
        $this->username = $username;
        $this->password = $password;
    }
    //abstract public function guardar1($conexion);
    abstract public function validarUsuario();
    abstract public function validarPassword();

}

    class Usuario extends UsuarioAbstracto {
        private $correo;
        private $direccion;
        private $id_rol;
    
        public function __construct($nombre, $correo, $direccion, $username, $password, $id_rol) {
            parent::__construct($nombre, $username, $password);
            $this->correo = $correo;
            $this->direccion = $direccion;
            $this->id_rol = $id_rol;
        }
    
        public function validarUsuario() {
            return strlen($this->username) >= 5 ? true : "El nombre de usuario debe tener al menos 5 caracteres.";
        }
    
        public function validarPassword() {
            // Validar la longitud mínima de la contraseña
            if (strlen($this->password) < 8) {
                return "La contraseña debe tener al menos 8 caracteres.";
            }
        
            // Validar la presencia de letras minúsculas y mayúsculas
            if (!preg_match('/[a-z]/', $this->password) || !preg_match('/[A-Z]/', $this->password)) {
                return "La contraseña debe incluir mayúsculas y minúsculas.";
            }
        
            // Validar la presencia de al menos un carácter especial
            if (!preg_match('/[\W_]/', $this->password)) {
                return "La contraseña debe incluir al menos un carácter especial (ej. !, @, #, $, etc.).";
            }
        
            // Si pasa todas las validaciones, retorna true
            return true;
        }
        
}




class UsuarioFactory {
    public static function crearUsuario($nombre, $correo, $direccion, $username, $password, $id_rol) {
        return new Usuario($nombre, $correo, $direccion, $username, $password, $id_rol);
    }
}
?>