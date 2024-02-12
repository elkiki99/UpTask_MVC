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
        $this->nombre = $args["nombre"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->password2 = $args["password2"] ?? "";
        $this->password_actual = $args["password_actual"] ?? "";
        $this->password_nuevo = $args["password_nuevo"] ?? "";
        $this->token = $args["token"] ?? "";
        $this->confirmado = $args["confirmado"] ?? 0;
    }
        
    public function validarLogin() : array {
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
    public function validarNuevaCuenta() : array {
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
    public function validarEmail() : array {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas["error"][] = "E-mail no válido";
        }
        return self::$alertas;
    }

    // Validar password
    public function validarPassword() : array {
        if(!$this->password) {
            self::$alertas["error"][] = "El password es obligatorio";
        }
        if(strlen($this->password) < 6) {
            self::$alertas["error"][] = "El password debe tener al menos 6 caracteres";
        }
        return self::$alertas;
    }

    public function validarPerfil() : array {
        if(!$this->nombre) {
            self::$alertas["error"][] = "El nombre es obligatorio";
        }
        if(!$this->email) {
            self::$alertas["error"][] = "El e-mail es obligatorio";
        }
        return self::$alertas;
    }

    public function nuevoPassword() : array {
        if(!$this->password_actual) {
            self::$alertas["error"][] = "El password es obligatorio";
        }
        if(!$this->password_nuevo) {
            self::$alertas["error"][] = "El password es obligatorio";
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas["error"][] = "El password debe contener al menos 6 caracteres";
        }
        return self::$alertas;
    }

    // Comprobar Password
    public function comprobarPassword() : bool {
        return password_verify($this->password_actual, $this->password);
    }

    // Hashear el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }
}