<?php 
require_once "../modelos/Categoria.php";
require_once "../config/Conexion.php";

$categoria=new Categoria();

$categoria->idcategoria=isset($_POST["idcategoria"])? $_POST["idcategoria"]:"";
$categoria->nombre=isset($_POST["nombre"])? $_POST["nombre"]:"";
$categoria->descripcion=isset($_POST["descripcion"])? $_POST["descripcion"]:"";

$idc=$categoria->idcategoria=isset($_POST["idcategoria"])? $_POST["idcategoria"]:"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idc)){
			$rspta=$categoria->insertar($categoria);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$categoria->editar($categoria);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;

	case 'desactivar':	
		$rspta=$categoria->desactivar($idc);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$categoria->activar($idc);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$categoria->mostrar($idc);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		
		$cnx=Conexion::conectarMySql();

		$sql="select * from categoria";

        $snt=$cnx->prepare($sql);

		$snt->execute();

 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$snt->fetch()){
 			$data[]=array(
 				"0"=>($reg['condicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idcategoria'].')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg['idcategoria'].')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg['idcategoria'].')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg['idcategoria'].')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg['nombre'],
 				"2"=>$reg['descripcion'],
 				"3"=>($reg['condicion'])?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
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