<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo AguaAlDia que son parte de los datos del cliente
	*/
class AguaAlDiaMdl extends BaseMdl{
	private $estado;
	
	/**
	 *@param string $estado
	 *Crea un nuevo registro del consumo de agua diaria
	 *@return true
	 */
	function create($estado){
		$this->estado = $estado;
		
		return true;
	}
}
?>