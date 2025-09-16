<?php

namespace Model;

class CitasServicios extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'citaservicios';
    protected static $columnasDB = ["id", "citasId","serviciosId"];

    public $id;
    public $citasId;
    public $serviciosId; 

      public function __construct($args = [])
    { 
    $this->id = $args["id"] ?? null ;
    $this->citasId = $args["citasId"] ?? "";
    $this->serviciosId = $args["serviciosId"] ??  ""; 
    }
}