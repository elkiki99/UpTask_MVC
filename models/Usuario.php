<?php 
namespace Model;
#[\AllowDynamicProperties]
class Usuario extends ActiveRecord {

    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];

        // Declarar visibilidad         --          PARA PHP 8.2 
        public $id;
        public $nombre;
        public $email;
        public $password;
        public $token;
        public $confirmado;

    public function __construct($args = []) 
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? null;
        $this->email = $args["email"] ?? null;
        $this->password = $args["password"] ?? null;
        $this->password2 = $args["password2"] ?? null;
        $this->token = $args["token"] ?? null;
        $this->confirmado = $args["confirmado"] ?? 0;
    }
        
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas["error"][] = "E-mail no válido";
        }
        if(!$this->password) {
            self::$alertas["error"][] = "El password es obligatorio";
        }
        return self::$alertas;
    }

    // Validación de cuentas nuevas
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas["error"][] = "El nombre es obligatorio";
        }
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!$this->password) {
            self::$alertas["error"][] = "El password es obligatorio";
        }
        if(strlen($this->password) < 6) {
            self::$alertas["error"][] = "El password debe tener al menos 6 caracteres";
        }
        if($this->password !== $this->password2) {
            self::$alertas["error"][] = "Los passwords deben ser los mismos";
        }
        return self::$alertas;
    }

    // Validar email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas["error"][] = "E-mail no válido";
        }
        return self::$alertas;
    }

    // Validar password
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas["error"][] = "El password es obligatorio";
        }
        if(strlen($this->password) < 6) {
            self::$alertas["error"][] = "El password debe tener al menos 6 caracteres";
        }
        return self::$alertas;
    }

    // Hashear el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken() {
        $this->token = uniqid();
    }
}