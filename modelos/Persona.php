<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Persona{

public $idpersona;
public $tipoPersona;
public $nombre;
public $tipoDocumento;
public $num_documento;
public $direccion;
public $telefono;
public $email;

	//Implementamos nuestro constructor
	public function __construct(){}

    public function insertar($persona){

     $cnx=Conexion::conectarMySql();

     $sql="insert into persona(tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email)
     values(:tipoPersona, :nombre, :tipoDocumento, :num_documento, :direccion, :telefono, :email)";

     $snt=$cnx->prepare($sql);

     $snt->bindValue(":tipoPersona", $persona->tipoPersona);
     $snt->bindValue(":nombre", $persona->nombre);
     $snt->bindValue(":tipoDocumento", $persona->tipoDocumento);
     $snt->bindValue(":num_documento", $persona->num_documento);
     $snt->bindValue(":direccion", $persona->direccion);
     $snt->bindValue(":telefono", $persona->telefono);
     $snt->bindValue(":email", $persona->email);

     return $snt->execute();

    }

    public function editar($persona){

        $cnx=Conexion::conectarMySql();

        $sql="update persona set tipo_persona=:tipoPersona, nombre=:nombre, tipo_documento=:tipoDocumento, num_documento=:num_documento, direccion=:direccion, telefono=:telefono, email=:email 
        where idpersona=:idpersona";
   
        $snt=$cnx->prepare($sql);

        $snt->bindValue(":tipoPersona", $persona->tipoPersona);
        $snt->bindValue(":nombre", $persona->nombre);
        $snt->bindValue(":tipoDocumento", $persona->tipoDocumento);
        $snt->bindValue(":num_documento", $persona->num_documento);
        $snt->bindValue(":direccion", $persona->direccion);
        $snt->bindValue(":telefono", $persona->telefono);
        $snt->bindValue(":email", $persona->email);
        $snt->bindValue(":idpersona", $persona->idpersona);
        return $snt->execute();

    }

    public function eliminar($idpersona){
		
        
        $cnx=Conexion::conectarMySql();

		$sql="DELETE FROM persona WHERE idpersona=:idpersona";
		
        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":idpersona", $idpersona);

        return $snt->execute();
    }



    public function mostrar($idpersona){


		$cnx=Conexion::conectarMySql();

		$sql="select * from persona where idpersona=:idpersona";
		
        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":idpersona", $idpersona);
		
		//Ejecutar la sentencia
		$snt->execute();

		//Recuperar el registro
		$fila = $snt->fetch();

		//Leer los valores del registro
		//a las propiedades de este objeto
        $this->idpersona=$fila["idpersona"];
        $this->tipoPersona=$fila["tipo_persona"];
		$this->nombre=$fila["nombre"];
        $this->tipoDocumento=$fila["tipo_documento"];
        $this->num_documento=$fila["num_documento"];
		$this->direccion=$fila["direccion"];
		$this->telefono=$fila["telefono"];
        $this->email=$fila["email"];

		return $this;
    }

    public function listarp()
	{
		
		$cnx=Conexion::conectarMySql();

		$sql="select * from persona where tipo_persona='Proveedor'";

        $snt=$cnx->prepare($sql);

        return $snt->execute();

	}

    public function listarc()
	{
		
		$cnx=Conexion::conectarMySql();

		$sql="select * from persona where tipo_persona='Cliente'";

        $snt=$cnx->prepare($sql);

        return $snt->execute();

	}

}

?>