<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Recepciones
	*/
class RecepcionMdl extends BaseMdl{
	private $idProveedor;
	private $folio;
	private $fechaRecepcion;
	private $total;
	
	private $idRecepcion;
	private $idProductoServicio;
	private $cantidad;
	private $precioUnitario;
	private $iva;
	private $descuento;
	
	/**
	 *@param integer $idProveedor
	 *@param integer $folio
	 *@param date $fechaRemision
	 *@param decimal $total
	 *Crea una nueva recepcion
	 *@return true
	 */
	function create($idProveedor, $folio, $fechaRecepcion,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos){
		$this->idProveedor = $idProveedor;
		$this->folio	= $folio;
		$this->fechaRecepcion	= $fechaRecepcion;
		$total = 0;
		for($i = 0;$i < count($idProductos);$i++){
			if(!$this->createDetails(1,$idProductos[$i],$cantidades[$i],$precioUnitario[$i],$ivas[$i],$descuentos[$i]))
				return false;
			$total += $cantidades[$i]*$precioUnitario[$i];
		}
		$this->total = $total;
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
	function createDetails($idRecepcion,$idProductoServicio,$cantidad,$precioUnitario,$iva,$descuento){
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