<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServiciosController{

    public static function index(Router $router){
        isAdmin();
        $nombre = $_SESSION["nombre"];
        $servicios = Servicio::all();

        $router->render("/servicios/index", [
            "nombre" => $nombre,
            "servicios" => $servicios
        ]);
    }

    public static function crear(Router $router){
        isAdmin();
        $nombre = $_SESSION["nombre"];
        $servicio = new Servicio;
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header("Location: /servicios");
            }
        }

        $router->render("/servicios/crear", [
            "nombre" => $nombre,
            "servicio" => $servicio,
            "alertas" => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        isAdmin();
        $nombre = $_SESSION["nombre"];
        $id = $_GET["id"];
        if(!is_numeric($id)) return;
        $servicio = Servicio::find($id);
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header("Location: /servicios");
            }

        }

        $router->render("/servicios/actualizar", [
            "nombre" => $nombre,
            "servicio" => $servicio,
             "alertas" => $alertas
        ]);
    }

    public static function eliminar(){
        isAdmin();
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio = Servicio::find($_POST["id"]);

            $servicio->eliminar();
            header("Location: /servicios");
        }
    }
}