<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Alimentación, que son de datos del cliente
	*/
class AlimentacionMdl extends BaseMdl{
	private $estadoAlimentacion;
	/**
	 *@param string $estado
	 *Crea un nuevo registro de alimentacion
	 *@return true
	 */
	function create($estado){
		$this->estadoAlimentacion = $estado;
		
		return true;
	}
}
?>