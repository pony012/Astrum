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
}
?>