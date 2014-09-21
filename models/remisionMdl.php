<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Remisas
	*/
class RemisionMdl extends BaseMdl{
	private $idCliente;
	private $folio;
	private $fechaRemision;
	private $total;
	
	private $idRemision;
	private $idProductoServicio;
	private $cantidad;
	private $precioUnitario;
	private $iva;
	private $descuento;
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idCliente
	 *@param integer $folio
	 *@param date $fechaRemision
	 *@param array $idProductos
	 *@param array $cantidades
	 *@param array $precioUnitario
	 *@param array $ivas
	 *@param array $descuentos
	 *Crea una nueva remision
	 *@return true
	 */
	function create($idCliente, $folio, $fechaRemision,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos){
		$this->idCliente 		= $idCliente;
		$this->folio			= $folio;
		$this->fechaRemision	= $fechaRemision;
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
	 *@param integer $idRemision
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *@param decimal $precioUnitario
	 *@param decimal $iva
	 *@param decimal $descuento
	 *Crea un nuevo detalle de una remision
	 *@return true
	 */
	function createDetails($idRemision,$idProductoServicio,$cantidad,$precioUnitario,$iva,$descuento){
		$this->idRemision 		  = $idRemision;
		$this->idProductoServicio = $idProductoServicio;
		$this->cantidad			  = $cantidad;
		$this->precioUnitario	  = $precioUnitario;
		$this->iva				  = $iva;
		$this->descuento		  = $descuento;
		
		return true;
	}
}
?>