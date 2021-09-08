<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
    public $idarticulo;
    public $idcategoria;
    public $codigo;
    public $nombre;
    public $stock;
	public $descripcion;
    public $imagen;
	public $condicion;

	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($articulo)
	{
		$cnx=Conexion::conectarMySql();
		
        $sql="insert into articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion) 
        values(:idcategoria, :codigo, :nombre, :stock, :descripcion, :imagen, 1)";

        $snt=$cnx->prepare($sql);

        $snt->bindValue(":idcategoria", $articulo->idcategoria);
        $snt->bindValue(":codigo", $articulo->codigo);
		$snt->bindValue(":nombre", $articulo->nombre);
        $snt->bindValue(":stock", $articulo->stock);
		$snt->bindValue(":descripcion", $articulo->descripcion);
        $snt->bindValue(":imagen", $articulo->imagen);
        return $snt->execute();
		
	}

	//Implementamos un método para editar registros
	public function editar($articulo)
	{
		$cnx=Conexion::conectarMySql();
		
        $sql="update articulo set idcategoria=:idcategoria, codigo=:codigo, nombre=:nombre, stock=:stock, descripcion=:descripcion, imagen=:imagen 
        where idarticulo=:idarticulo";

        $snt=$cnx->prepare($sql);
        $snt->bindValue(":idarticulo", $articulo->idarticulo);
        $snt->bindValue(":idcategoria", $articulo->idcategoria);
        $snt->bindValue(":codigo", $articulo->codigo);
		$snt->bindValue(":nombre", $articulo->nombre);
        $snt->bindValue(":stock", $articulo->stock);
		$snt->bindValue(":descripcion", $articulo->descripcion);
        $snt->bindValue(":imagen", $articulo->imagen);

        return $snt->execute();
		
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idarticulo)
	{

		$cnx=Conexion::conectarMySql();

		$sql="UPDATE articulo SET condicion='0' WHERE idarticulo=:idarticulo";
		
        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":idarticulo", $idarticulo);

        return $snt->execute();

	}

	//Implementamos un método para activar categorías
	public function activar($idarticulo)
	{

		$cnx=Conexion::conectarMySql();

		$sql="UPDATE articulo SET condicion='1' WHERE idarticulo=:idarticulo";
		
        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":idarticulo", $idarticulo);

        return $snt->execute();

	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{

		$cnx=Conexion::conectarMySql();

		$sql="select * from articulo where idarticulo=:idarticulo";
		
        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":idarticulo", $idarticulo);
		
		//Ejecutar la sentencia
		$snt->execute();

		//Recuperar el registro
		$fila = $snt->fetch();

		//Leer los valores del registro
		//a las propiedades de este objeto
        $this->idarticulo=$fila["idarticulo"];
        $this->idcategoria=$fila["idcategoria"];
        $this->codigo=$fila["codigo"];
		$this->nombre=$fila["nombre"];
        $this->stock=$fila["stock"];
		$this->descripcion=$fila["descripcion"];
        $this->imagen=$fila["imagen"];
		$this->condicion=$fila["condicion"];

		return $this;

	}

	//Implementar un método para listar los registros
	public function listar()
	{
		
		$cnx=Conexion::conectarMySql();

		$sql="select a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.descripcion,a.imagen,a.condicion from articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";

        $snt=$cnx->prepare($sql);

        return $snt->execute();

	}


}

?>