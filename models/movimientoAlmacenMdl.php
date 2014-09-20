<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Movimiento de Almacen
	*/
class MovimientoAlmacenMdl extends BaseMdl{
	private $idMovimientoAlmacenTipo;
	private $fecha;
	private $idEmpleado;
	private $referencia;
	
	/**
	 *@param integer $idMovimientoAlmacenTipo
	 *@param date $fecha
	 *@param integer $idEmpleado
	 *@param string $referencia
	 *Crea un nuevo movimiento de almacen
	 *@return true
	 */
	function create($idMovimientoAlmacenTipo, $fecha, $idEmpleado, $referencia){
		$this->idMovimientoAlmacenTipo = $idMovimientoAlmacenTipo;
		$this->fecha	= $fecha;
		$this->idEmpleado	= $idEmpleado;
		$this->referencia	= $referencia;
		
		return true;
	}
}
?>