<?php 
require_once "../modelos/Persona.php";
require_once "../config/Conexion.php";

$persona=new Persona();

$persona->idpersona=isset($_POST["idpersona"])? $_POST["idpersona"]:"";
$persona->tipoPersona=isset($_POST["tipo_persona"])? $_POST["tipo_persona"]:"";
$persona->nombre=isset($_POST["nombre"])? $_POST["nombre"]:"";
$persona->tipoDocumento=isset($_POST["tipo_documento"])? $_POST["tipo_documento"]:"";
$persona->num_documento=isset($_POST["num_documento"])? $_POST["num_documento"]:"";
$persona->direccion=isset($_POST["direccion"])? $_POST["direccion"]:"";
$persona->telefono=isset($_POST["telefono"])? $_POST["telefono"]:"";
$persona->email=isset($_POST["email"])? $_POST["email"]:"";

$id=$persona->idpersona=isset($_POST["idpersona"])? $_POST["idpersona"]:"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			$rspta=$persona->insertar($persona);
			echo $rspta ? "Proveedor registrado" : "Proveedor no se pudo registrar";
		}
		else {
			$rspta=$persona->editar($persona);
			echo $rspta ? "Proveedor actualizado" : "Proveedor no se pudo actualizar";
		}
	break;

	case 'eliminar':	
		$rspta=$persona->eliminar($id);
 		echo $rspta ? "Proveedor Eliminado" : "Proveedor no se puede eliminar";
 		break;
	break;

	case 'mostrar':
		$rspta=$persona->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listarp':
		
		$cnx=Conexion::conectarMySql();

		$sql="select * from persona where tipo_persona='Proveedor'";

        $snt=$cnx->prepare($sql);

		$snt->execute();

 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$snt->fetch()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg['idpersona'].')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg['idpersona'].')"><i class="fa fa-trash"></i></button>',
 				"1"=>$reg['nombre'],
 				"2"=>$reg['tipo_documento'],
                "3"=>$reg['num_documento'],
                "4"=>$reg['telefono'],
 				"5"=>$reg['email']
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarc':
		
		$cnx=Conexion::conectarMySql();

		$sql="select * from persona where tipo_persona='Cliente'";

        $snt=$cnx->prepare($sql);

		$snt->execute();

 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$snt->fetch()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg['idpersona'].')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg['idpersona'].')"><i class="fa fa-trash"></i></button>',
 				"1"=>$reg['nombre'],
 				"2"=>$reg['tipo_documento'],
                "3"=>$reg['num_documento'],
                "4"=>$reg['telefono'],
 				"5"=>$reg['email']
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

}
?>