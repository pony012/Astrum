<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de Ajuste de Salida
	*/
class AjusteSalidaMdl extends BaseMdl{
	private $idAjusteSalidaTipo;
	private $idProveedor;
	private $folio;
	private $observaciones;
	
	private $idAjusteSalida;
	private $idProductoServicio;
	private $cantidad;
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idAjusteSalidaTipo
	 *@param integer $idProveedor
	 *@param integer $folio
	 *@param string $observaciones
	 *@param integer $idAjusteSalida
	 *@param array $idProductos
	 *@param array $cantidades
	 *Crea un nuevo ajuste de salida
	 *@return true
	 */
	function create($idAjusteSalidaTipo, $idProveedor = NULL, $folio, $observaciones,$idProductos,$cantidades){
		$this->idAjusteSalidaTipo = $idAjusteSalidaTipo;
		$this->idProveedor	= $idProveedor;
		$this->folio	= $folio;
		$this->observaciones	= $observaciones;
		for($i = 0;$i < count($idProductos);$i++){
			if(!$this->createDetails(1,$idProductos[$i],$cantidades[$i]))
				return false;
		}
		return true;
	}
	
	/**
	 *@param integer $idAjusteSalida
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *Crea un nuevo detalle de un ajuste de salida
	 *@return true
	 */
	function createDetails($idAjusteSalida, $idProductoServicio, $cantidad){
		$this->idAjusteSalida = $idAjusteSalida;
		$this->idProductoServicio = $idProductoServicio;
		$this->cantidad	= $cantidad;
		
		return true;
	}
}
?>