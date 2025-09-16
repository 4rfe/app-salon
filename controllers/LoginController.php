<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Clases\Email;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //COmprobar que el usuario existe
                $usuario = Usuario::where("email", $auth->email); 
                if($usuario){
                    //Verificar password
                    if($usuario->comprobarUsuario($auth->password)){  
                        session_start();

                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido; 
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true; 

                        //Redireccional
                        if($usuario->admin){ 
                        $_SESSION["admin"] = $usuario->admin;
                        header("Location: /admin");
                        }else{
                        header("Location: /citas"); 
                        }
                    }
 
                }else{
                    Usuario::setAlerta("error", "Usuario no encontrado");
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/login", [
            "alertas" => $alertas
        ]);
    }

    public static function logout(Router $router){
        $_SESSION = [];

        header("Location: /");
    }

    public static function olvide(Router $router){
        $usuario = new Usuario();
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth = new Usuario($_POST);
            $auth->validadEmail();

            if(empty($alertas)){
                $usuario = Usuario::where("email", $auth->email);

                if($usuario && $usuario->confirmado === "1"){

                    //Crear token
                    $usuario->creartoken();
                    $usuario->guardar(); 

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Mensaje de exito
                    Usuario::setAlerta("exito", "Revisa tu email");
                    $alertas = Usuario::getAlertas();
                }else{
                    Usuario::setAlerta("error", "El usuario no existe o no está confirmado");
                    $alertas = Usuario::getAlertas();
                }

            }
        }
        
        $router->render("auth/olvide", [
            "alertas" => $alertas
        ]);
    }

    public static function recuperar(Router $router){ 
        $alertas = [];
        $error = false;

        $token = s($_GET["token"]);

        //Buscar usuario
        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            Usuario::setAlerta("error", "Token no válido");
            $error = true;
        } 

         if($_SERVER["REQUEST_METHOD"] === "POST"){
            //Leer el nuevo password
            $password = new Usuario($_POST);

            $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;
                 
                $usuario->password = $password->password;
                $usuario->hashpassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if($resultado){
                    header("Location: /");
                }
            }
         }

         $alertas = Usuario::getAlertas();
         $router->render("auth/recuperar-password", [
            "alertas" => $alertas,
            "error" => $error
        ]);
    }
 
    public static function crear(Router $router){
        $usuario = new Usuario();
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar();

            //Revisar que alertas este vacio
            if(empty($alertas)){
            //verificar que el usuario no este registrado
            $resultado = $usuario->existeUser();

            if($resultado->num_rows){
             $alertas = Usuario::getAlertas();
            }else{
                //Si no esta registrado

                //Hashear password
                $usuario->hashpassword();

                //Generar un token unico
                $usuario->creartoken();

                //Enviar el email
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                $email->enviarConfirmacion();

                //Crear el usuario
                $resultado = $usuario->guardar();

                if($resultado){
                    header("Location: /mensaje");
                }
            }
            }
        }

        $router->render("auth/crear-cuenta", [
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function confirmar(Router $router){
        $alertas = [];
         
        $token = trim(s($_GET["token"])); 
        $usuario = Usuario::where("token", $token); 

        if(empty($usuario)){
            //Mostrar mensaje de error
            $mensaje = "Token no válido";
            Usuario::setAlerta("error", $mensaje);

        }else{
            //Modificar a usuario confirmado
            $mensaje = "Cuenta comprobada correctamente"; 
            $usuario->confirmado = "1"; 
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta("exito", $mensaje);
        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/confirmar-cuenta", [ 
            "alertas" => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render("auth/mensaje", [ 
        ]);
    }
}