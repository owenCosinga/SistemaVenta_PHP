<?php

require_once "../modelos/Articulo.php";
require_once "../config/Conexion.php";

$articulo=new Articulo();

$articulo->idarticulo=isset($_POST["idarticulo"])? $_POST["idarticulo"]:"";
$articulo->idcategoria=isset($_POST["idcategoria"])? $_POST["idcategoria"]:"";
$articulo->codigo=isset($_POST["codigo"])? $_POST["codigo"]:"";
$articulo->nombre=isset($_POST["nombre"])? $_POST["nombre"]:"";
$articulo->stock=isset($_POST["stock"])? $_POST["stock"]:"";
$articulo->descripcion=isset($_POST["descripcion"])? $_POST["descripcion"]:"";
$articulo->imagen=isset($_POST["imagen"])? $_POST["imagen"]:"";

$id = $articulo->idarticulo=isset($_POST["idarticulo"])? $_POST["idarticulo"]:"";


switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$articulo->imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$articulo->imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $articulo->imagen);
			}
		}
		if (empty($id)){
			$rspta=$articulo->insertar($articulo);
			echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$articulo->editar($articulo);
			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$articulo->desactivar($id);
 		echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$articulo->activar($id);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$articulo->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':

		$cnx=Conexion::conectarMySql();

		$sql="select a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.descripcion,a.imagen,a.condicion from articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";

        $snt=$cnx->prepare($sql);

		$snt->execute();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$snt->fetch()){
 			$data[]=array(
				"0"=>($reg['condicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idarticulo'].')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg['idarticulo'].')"><i class="fa fa-close"></i></button>':
				' <button class="btn btn-warning" onclick="mostrar('.$reg['idarticulo'].')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg['idarticulo'].')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg['nombre'],
 				"2"=>$reg['categoria'],
 				"3"=>$reg['codigo'],
 				"4"=>$reg['stock'],
 				"5"=>"<img src='../files/articulos/".$reg['imagen']."' height='50px' width='50px' >",
 				"6"=>($reg['condicion'])?'<span class="label bg-green">Activado</span>':
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

	case "selectCategoria":
		$cnx=Conexion::conectarMySql();

		$sql="select * from categoria where condicion=1";

        $snt=$cnx->prepare($sql);

		$snt->execute();

		while ($reg = $snt->fetch())
				{
					echo '<option value=' . $reg['idcategoria'] . '>' . $reg['nombre'] . '</option>';
				}
	break;
}



?>