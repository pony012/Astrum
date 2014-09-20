<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Existencias de los productos
	*/
class ExistenciaMdl extends BaseMdl{
	private $fechaReferencia;
	private $idProducto;
	private $precioUnitario;
	private $cantidad;
	
	/**
	 *@param string $fechaReferencia
	 *@param integer $idProducto
	 *@param decimal $precioUnitario
	 *@param decimal $cantidad
	 *Crea un registro de existencia de un determinado producto-servicio
	 *@return true
	 */
	function create($fechaReferencia, $idProducto, $precioUnitario, $cantidad){
		$this->fechaReferencia = $fechaReferencia;
		$this->idProducto	= $idProducto;
		$this->precioUnitario	= $precioUnitario;
		$this->cantidad	= $cantidad;
		
		return true;
	}
}
?>