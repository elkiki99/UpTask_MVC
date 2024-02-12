<?php 
namespace Controllers;
use MVC\Router;
use Model\Proyecto;
use Model\Usuario;

class DashboardController {

    public static function index(Router $router) {

        if(!isset($_SESSION)) {
            session_start();
        }
        isAuth();

        $id = $_SESSION["id"];
        $proyectos = Proyecto::belongsTo("propietarioId", $id);

        $router->render("dashboard/index", [
            "titulo" => "Proyectos",
            "proyectos" => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router) {

        $alertas = [];

        if(!isset($_SESSION)) {
            session_start();
        }
        isAuth();

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $proyecto = new Proyecto($_POST);
            // Validación
            $alertas = $proyecto->validarProyecto();
            if(empty($alertas)) {
                // Generar una URL única
                $hash = md5(uniqid());
                $proyecto->url = $hash;
                // Almacenar el CRUD del usuario 
                $proyecto->propietarioId = $_SESSION["id"];
                // Guardar Proyecto
                $proyecto->guardar();
                // Redireccionar
                header("Location: /proyecto?id=" . $proyecto->url);
            }
        }

        $router->render("dashboard/crear-proyecto", [
            "titulo" => "Crear Proyectos",
            "alertas" => $alertas
        ]);
    }

    public static function eliminar_proyecto() {
        if(!isset($_SESSION)) {
            session_start();
        }
        isAuth();
 
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
 
            if($id) {
                $proyecto = Proyecto::find($id);
                if($proyecto->propietarioId === $_SESSION['id']) {
                    $id = $_POST['id'];
                    $proyecto = Proyecto::find($id);
                    $proyecto->eliminar();
                
                // Redireccionar
                header('Location: /dashboard'); 
                }
            }
        }
    }

    public static function proyecto(Router $router) {
        if(!isset($_SESSION)) {
            session_start();
        }
        isAuth();

        $token = $_GET["id"];
        if(!$token) header("Location: /dashboard");
        // Revisar que la persona que visita el proyecto es quien lo creó
        $proyecto = Proyecto::where("url", $token); 
        if($proyecto->propietarioId !== $_SESSION["id"]) {
            header("Location: /dashboard");
        }

        $router->render("dashboard/proyecto", [
            "titulo" => $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router) {

        if(!isset($_SESSION)) {
            session_start();
        }
        isAuth();

        $usuario = Usuario::find($_SESSION["id"]);
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPerfil();

            if(empty($alertas)) {
                $existeUsuario = Usuario::where("email", $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    // Mostrar una alerta
                    Usuario::setAlerta("error", "El e-mail ya está registrado");
                } else {
                    // Guardamos el registro
                    $usuario->guardar();

                    Usuario::setAlerta("exito", "Guardado correctamente");
    
                    // Asignamos el nombre nuevo a la barra
                    $_SESSION["nombre"] = $usuario->nombre;
                }
            }

            $alertas = $usuario->getAlertas();
        }

        $router->render("dashboard/perfil", [
            "titulo" => "Perfil",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function cambiar_password(Router $router) {
        if(!isset($_SESSION)) {
            session_start();
        }
        isAuth();
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = Usuario::find($_SESSION["id"]);
            // Sincronizar los datos con el usuario
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevoPassword();
            
            if(empty($alertas)) {
                $resultado = $usuario->comprobarPassword();

                if(!$resultado) {
                    Usuario::setAlerta("error", "Tu Password Actual es Incorrecto");

                } elseif($usuario->password_actual === $usuario->password_nuevo) {
                    Usuario::setAlerta("error", "Tu Password Nueva Debe Ser Distinta a la Actual");
                } else {
                    $usuario->password = $usuario->password_nuevo;
                    // Eliminar propiedades no necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);
                    // Hashear el nuevo password
                    $usuario->hashPassword();
                    // Actualizar 
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        Usuario::setAlerta("exito", "Password Guardado Correctamente");
                    }
                }
            }
            $alertas = $usuario->getAlertas();
        }


        $router->render("dashboard/cambiar-password", [
            "titulo" => "Cambiar Password",
            "alertas" => $alertas
        ]);
    }
}