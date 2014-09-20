<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Consulta
	*/
class ConsultaMdl extends BaseMdl{
	private $idcliente;
	private $idTerapeuta;
	private $fechaCita;
	private $idConsultaStatus;
	private $observaciones;
	
	/**
	 *@param integer $idcliente
	 *@param integer $idTerapeuta
	 *@param date $fechaCita
	 *@param integer $idConsultaStatus
	 *@param string $observaciones
	 *Crea una nueva consulta
	 *@return true
	 */
	function create($idcliente, $idTerapeuta, $fechaCita, $idConsultaStatus, $observaciones){
		$this->idcliente = $idcliente;
		$this->idTerapeuta	= $idTerapeuta;
		$this->fechaCita	= $fechaCita;
		$this->idConsultaStatus	= $idConsultaStatus;
		$this->observaciones	= $observaciones;
		
		return true;
	}
}
?>