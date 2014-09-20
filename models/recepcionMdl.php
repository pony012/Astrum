<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Recepciones
	*/
class RecepcionMdl extends BaseMdl{
	private $idMovimientoAlmacen;
	private $idProveedor;
	private $folio;
	private $fechaRecepcion;
	private $total;
	
	private $idRecepcion
	private $idProductoServicio
	private $cantidad
	private $precioUnitario
	private $iva
	private $descuento
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idProveedor
	 *@param integer $folio
	 *@param date $fechaRemision
	 *@param decimal $total
	 *Crea una nueva recepcion
	 *@return true
	 */
	function create($idMovimientoAlmacen, $idProveedor, $folio, $fechaRemision, $total){
		$this->idMovimientoAlmacen = $idMovimientoAlmacen;
		$this->idProveedor = $idProveedor;
		$this->folio	= $folio;
		$this->fechaRemision	= $fechaRemision;
		$this->total	= $total;
		
		return true;
	}
	
	/**
	 *@param integer $idRecepcion
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *@param decimal $precioUnitario
	 *@param decimal $iva
	 *@param decimal $descuento
	 *Crea un nuevo detalle de una recepcion
	 *@return true
	 */
	function createDetails($idRecepcion, $idProductoServicio, $cantidad, $idProductoServicio, $cantidad){
		$this->idRecepcion = $idRecepcion;
		$this->idProductoServicio = $idProductoServicio;
		$this->cantidad	= $cantidad;
		$this->precioUnitario	= $precioUnitario;
		$this->iva	= $iva;
		$this->descuento	= $descuento;
		
		return true;
	}
}
?>