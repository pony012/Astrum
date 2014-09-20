<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo HistorialMedico del cliente
	*/
class HistorialMedicoMdl extends BaseMdl{
	private $idCliente;
	private $fechaRegistro;
	private $idServicio;
	private $observaciones;
	
	/**
	 *@param integer $idCliente
	 *@param date $fechaRegistro
	 *@param integer $idServicio
	 *@param string $observaciones
	 *Crea un nuevo historial medico de un cliente
	 *@return true
	 */
	function create($idCliente, $fechaRegistro, $idServicio, $idServicio, $observaciones){
		$this->idCliente = $idCliente;
		$this->fechaRegistro	= $fechaRegistro;
		$this->idServicio	= $idServicio;
		$this->observaciones	= $observaciones;
		
		return true;
	}
}
?>