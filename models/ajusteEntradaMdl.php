<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de Ajuste de Entrada
	*/
class AjusteEntradaMdl extends BaseMdl{
	private $idMovimientoAlmacen;
	private $idAjusteEntradaTipo;
	private $idCliente;
	private $folio;
	private $observaciones;
	
	private $idAjusteEntrada
	private $idProductoServicio
	private $cantidad
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idAjusteEntradaTipo
	 *@param integer $idCliente
	 *@param integer $folio
	 *@param string $observaciones
	 *Crea un nuevo ajuste de entrada
	 *@return true
	 */
	function create($idMovimientoAlmacen, $idAjusteEntradaTipo, $idCliente = NULL, $folio, $observaciones){
		$this->idMovimientoAlmacen = $idMovimientoAlmacen;
		$this->idAjusteEntradaTipo = $idAjusteEntradaTipo;
		$this->idCliente	= $idCliente;
		$this->folio	= $folio;
		$this->observaciones	= $observaciones;
		
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