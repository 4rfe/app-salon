<?php 

namespace Controllers;

use Model\Servicio;
use Model\Citas;
use Model\CitasServicios;
use MVC\Router;

class APIController{

    public static function index( ){
        $servicios = Servicio::all(); 
        echo  json_encode($servicios); //mandar los servicios con echo
        
    }

    public static function guardar(){
        //Almacena la cita y el id
        $cita = new Citas($_POST); 
        $resultado = $cita->guardar();
        $id = $resultado["id"];

        //Almacena la cita y los servicios
        $idServicios = explode(",", $_POST["servicios"]);

        foreach($idServicios as $idServicio){
            $args = [
                "citasId" => $id,
                "serviciosId" => $idServicio
            ];
            
            $citaServicio = new CitasServicios($args);
            $citaServicio->guardar();
        }

        //Retornado una respuesta
         $respuesta = [
           "resultado" => $resultado
         ]; 

         
        echo json_encode($respuesta);
 
    }

    public static function eliminar(){
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $id = $_POST["id"];

            $cita = Citas::find($id);
            $cita->eliminar();

            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }

    }
}