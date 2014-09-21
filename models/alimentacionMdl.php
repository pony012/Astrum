<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Alimentación, que son de datos del cliente
	*/
class AlimentacionMdl extends BaseMdl{
	private $estado;
	/**
	 *@param string $estado
	 *Crea un nuevo registro de alimentacion
	 *@return true
	 */
	function create($estado){
		$this->estado = $estado;
		
		return true;
	}
}
?>