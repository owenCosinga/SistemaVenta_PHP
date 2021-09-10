<?php 
require_once "../config/Conexion.php";

switch ($_GET["op"]){


	case 'listar':
		
		$cnx=Conexion::conectarMySql();

		$sql="select * from permiso";

        $snt=$cnx->prepare($sql);

		$snt->execute();

 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$snt->fetch()){
 			$data[]=array(

 				"0"=>$reg['nombre']
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