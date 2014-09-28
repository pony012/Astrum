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
		$this->status		= $this->driver->real_escape_string($status);
		$this->descripcion	= $this->driver->real_escape_string($descripcion);
		
		$result = $this->driver->query("INSERT INTO ConsultaStatus (Status,Descripcion) 
								VALUES('$this->status','$this->descripcion')");
		
		if($this->driver->error){
			return false;
		}
		return true;
	}
}
?>