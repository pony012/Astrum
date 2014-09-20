<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de los TIpos de Movimientos de Almacen
	*/
class MovimientoAlmacenTipoMdl extends BaseMdl{
	private $tipoMovimientoAlmacen;
	private $entradaSalida;
	private $descripcion;
	
	/**
	 *@param string $tipoMovimientoAlmacen
	 *@param string $entradaSalida
	 *@param string $descripcion
	 *Crea un nuevo tipo de movimiento de almacen
	 *@return true
	 */
	function create($tipoMovimientoAlmacen, $entradaSalida, $descripcion){
		$this->tipoMovimientoAlmacen = $tipoMovimientoAlmacen;
		$this->entradaSalida = $entradaSalida;
		$this->descripcion	= $descripcion;
		
		return true;
	}
}
?>