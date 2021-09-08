<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Categoria
{
 
    public $idcategoria;
    public $nombre;
	public $descripcion;
	public $condicion;

	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($categoria)
	{
		$cnx=Conexion::conectarMySql();
		
        $sql="insert into categoria (nombre,descripcion,condicion) values(:nombre, :descripcion, 1)";

        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":nombre", $categoria->nombre);
		$snt->bindValue(":descripcion", $categoria->descripcion);
		
        return $snt->execute();
		
	}

	//Implementamos un método para editar registros
	public function editar($categoria)
	{
		$cnx=Conexion::conectarMySql();
		
        $sql="update categoria set nombre=:nombre, descripcion=:descripcion where idcategoria=:idcategoria";

        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":nombre", $categoria->nombre);
		$snt->bindValue(":descripcion", $categoria->descripcion);
		$snt->bindValue(":idcategoria", $categoria->idcategoria);

        return $snt->execute();
		
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcategoria)
	{

		$cnx=Conexion::conectarMySql();

		$sql="UPDATE categoria SET condicion='0' WHERE idcategoria=:idcategoria";
		
        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":idcategoria", $idcategoria);

        return $snt->execute();

	}

	//Implementamos un método para activar categorías
	public function activar($idcategoria)
	{

		$cnx=Conexion::conectarMySql();

		$sql="UPDATE categoria SET condicion='1' WHERE idcategoria=:idcategoria";
		
        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":idcategoria", $idcategoria);

        return $snt->execute();

	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcategoria)
	{

		$cnx=Conexion::conectarMySql();

		$sql="select * from categoria where idcategoria=:idcategoria";
		
        $snt=$cnx->prepare($sql);
		
		$snt->bindValue(":idcategoria", $idcategoria);
		
		//Ejecutar la sentencia
		$snt->execute();

		//Recuperar el registro
		$fila = $snt->fetch();

		//Leer los valores del registro
		//a las propiedades de este objeto
        $this->idcategoria=$fila["idcategoria"];
		$this->nombre=$fila["nombre"];
		$this->descripcion=$fila["descripcion"];
		$this->condicion=$fila["condicion"];

		return $this;

	}

	//Implementar un método para listar los registros
	public function listar()
	{
		
		$cnx=Conexion::conectarMySql();

		$sql="select * from categoria";

        $snt=$cnx->prepare($sql);

        return $snt->execute();

	}

	public function select()
	{
		
		$cnx=Conexion::conectarMySql();

		$sql="select * from categoria where condicion=1";

        $snt=$cnx->prepare($sql);

        return $snt->execute();

	}

}

?>