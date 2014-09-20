<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Remisas
	*/
class RemisionMdl extends BaseMdl{
	private $idMovimientoAlmacen;
	private $idCliente;
	private $folio;
	private $fechaRemision;
	private $total;
	
	private $idRemision
	private $idProductoServicio
	private $cantidad
	private $precioUnitario
	private $iva
	private $descuento
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idCliente
	 *@param integer $folio
	 *@param date $fechaRemision
	 *@param decimal $total
	 *Crea una nueva remision
	 *@return true
	 */
	function create($idMovimientoAlmacen, $idCliente, $folio, $fechaRemision, $total){
		$this->idMovimientoAlmacen = $idMovimientoAlmacen;
		$this->idCliente = $idCliente;
		$this->folio	= $folio;
		$this->fechaRemision	= $fechaRemision;
		$this->total	= $total;
		
		return true;
	}
	
	/**
	 *@param integer $idRemision
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *@param decimal $precioUnitario
	 *@param decimal $iva
	 *@param decimal $descuento
	 *Crea un nuevo detalle de una remision
	 *@return true
	 */
	function createDetails($idRemision, $idProductoServicio, $cantidad, $idProductoServicio, $cantidad){
		$this->idRemision = $idRemision;
		$this->idProductoServicio = $idProductoServicio;
		$this->cantidad	= $cantidad;
		$this->precioUnitario	= $precioUnitario;
		$this->iva	= $iva;
		$this->descuento	= $descuento;
		
		return true;
	}
}
?>