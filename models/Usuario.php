<?php

namespace Model;

class Usuario extends ActiveRecord{
//Base de datos
protected static $tabla = 'usuarios';
protected static $columnasDB = ["id", "nombre", "apellido", "email", 
"password", "admin", "telefono", "confirmado", "token"];

public $id;
public $nombre;
public $apellido;
public $email;
public $password;
public $admin;
public $telefono;
public $confirmado;
public $token;
protected static $errores = [];

public function __construct($args = [])
{ 
    $this->id = $args["id"] ?? null ;
    $this->nombre = $args["nombre"] ?? "";
    $this->apellido = $args["apellido"] ?? "";
    $this->email = $args["email"] ?? " " ;
    $this->password = $args["password"] ?? "" ;
    $this->admin = $args["admin"] ?? "0";
    $this->telefono = $args["telefono"] ?? "";
    $this->confirmado = $args["confirmado"] ?? "0";
    $this->token = $args["token"] ?? " ";
}

//Mensajes de validacion para la creacion de cuenta
public function validar() {
 
if(!$this->nombre){
  self::$alertas["error"] [] = "El nombre es obligatorio";
}
if(!$this->apellido){
  self::$alertas["error"] [] = "El apellido es obligatorio";
} 
if(!$this->email){
  self::$alertas["error"] [] = "El email es obligatorio o no es valido";
}
if(!$this->password){
  self::$alertas["error"] [] = "La contraseña es obligatoria";
} 
if(strlen($this->password) < 8){
    self::$alertas["error"] [] = "La contraseña debe tener al menos 8 caracteres";
}
if(!$this->telefono){
  self::$alertas["error"] [] = "El telefono es obligatoria";
} 

return self::$alertas;

}

public function existeUser(){
    $query = "SELECT * FROM " .  self::$tabla . " WHERE email = '" .  $this->email . " ' LIMIT 1";

    $resultado = self::$db->query($query);

    if($resultado->num_rows){
        self::$alertas["error"] [] = "El usuario está registrado";
    }

    return $resultado;
}

public function hashpassword(){
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
}

public function creartoken(){
    $this->token = uniqid();
}

public function validarPassword(){
    if(!$this->password){
    self::$alertas["error"][] = "El password es obligatorio";
    }
    if(strlen($this->password) < 8){
    self::$alertas["error"] [] = "La contraseña debe tener al menos 8 caracteres";
    }

    return self::$alertas;
}

public function validarLogin(){
  if(!$this->email){
    self::$alertas["error"][] = "El email es obligatorio";
  }
  if(!$this->password){
    self::$alertas["error"][] = "El password es obligatorio";
  }
  return self::$alertas;
}

public function comprobarUsuario($password){
   $resultado = password_verify($password, $this->password);

   if(!$resultado || !$this->confirmado){
     self::$alertas["error"][] = "El usuario no esta confirmada o la contraseña es incorrecta";
   }else{
     return true;
   }
}

public function validadEmail() {
  if(!$this->email){
    self::$alertas["error"][] = "El email es obligatorio";
  }

  return self::$alertas;
}
 
}