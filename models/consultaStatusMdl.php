<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo CosultaStatus
	*/
class ConsultaStatusMdl extends BaseMdl{
	private $status;
	private $descripcion;
	
	/**
	 *@param string $status
	 *@param string $descripcion
	 *Crea un nuevo status para las consultas
	 *@return true
	 */
	function create($status, $descripcion){
		$this->status = $status;
		$this->descripcion	= $descripcion;
		
		return true;
	}
}
?>