<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de Ajuste de Entrada
	*/
class AjusteEntradaMdl extends BaseMdl{
	private $idAjusteEntradaTipo;
	private $idCliente;
	private $folio;
	private $observaciones;
	
	private $idAjusteEntrada
	private $idProductoServicio
	private $cantidad
	
	/**
	 *@param integer $idAjusteEntradaTipo
	 *@param integer $idCliente
	 *@param integer $folio
	 *@param string $observaciones
	 *@param integer $idAjusteEntrada
	 *@param array $idProductos
	 *@param array $cantidades
	 *Crea un nuevo ajuste de entrada
	 *@return true
	 */
	function create( $idAjusteEntradaTipo, $idCliente = NULL, $folio, $observaciones,$idProductos,$cantidades){
		$this->idAjusteEntradaTipo = $idAjusteEntradaTipo;
		$this->idCliente	= $idCliente;
		$this->folio	= $folio;
		$this->observaciones	= $observaciones;
		for($i = 0;$i < count($idProductos);$i++){
			if(!$this->createDetails(1,$idProductos[$i],$cantidades[$i])
				return false;
		}
		return true;
	}
	
	/**
	 *@param integer $idAjusteEntrada
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *Crea un nuevo detalle de un ajuste de entrada
	 *@return true
	 */
	function createDetails($idAjusteEntrada, $idProductoServicio, $cantidad){
		$this->idAjusteEntrada = $idAjusteEntrada;
		$this->idProductoServicio = $idProductoServicio;
		$this->cantidad	= $cantidad;
		
		return true;
	}
}
?>