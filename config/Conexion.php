<?php 
require_once "global.php";

class Conexion{

//estamos editando la cnx en github
public static function conectarMySql(){
 
 $cadena=DB_HOST;
 $user=DB_USERNAME;
 $password=DB_PASSWORD;

  $conexion=new PDO($cadena, $user, $password);

  return $conexion;

}



}


?>
