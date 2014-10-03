<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Producto
	*/
class ProductoMdl extends BaseMdl{
	private $idProductoTipo;
	private $producto;
	private $precioUnitario;
	private $foto;
	private $descripcion;
	
	/**
	 *@param integer $idProductoTipo
	 *@param string $producto
	 *@param decimal $precioUnitario
	 *@param string $foto
	 *@param string $descripcion
	 *Crea un nuevo producto
	 *@return true
	 */
	function create($idProductoTipo, $producto, $precioUnitario, $foto = NULL, $descripcion = NULL){
		$this->idProductoTipo = $idProductoTipo;
		$this->producto	= $producto;
		$this->precioUnitario	= $precioUnitario;
		$this->foto	= $foto;
		$this->descripcion	= $descripcion;
		
		return true;
	}
	
	/**
	* Consulta todos los productos registrados
	* @return array or false
	**/
	function lists(){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Producto')){

			if(!$stmt->execute())
				die('Error Al Consultar');

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);

				return $rows;
			}else
				die('No hay Resultados!!!');

		}else
			die('Error Al Consultar');
			
		return false;
	}
}
?>