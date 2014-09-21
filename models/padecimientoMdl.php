<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Padecimiento, que son datos del cliente
	*/
class PadecimientoMdl extends BaseMdl{
	private $diabetes;
	private $obesisdad;
	private $depresion;
	private $estres;
	private $sobrepeso;
	private $estrenimiento;
	private $colitis;
	private $retencionLiquidos;
	private $transtornoMes;
	private $cuidadoCorporal;
	private $embarazo;
	/**
	 *@param string $diabetes
	 *@param string $obesisdad
	 *@param string $depresion
	 *@param string $estres
	 *@param string $sobrepeso
	 *@param string $estrenimiento
	 *@param string $colitis
	 *@param string $retencionLiquidos
	 *@param string $transtornoMes
	 *@param string $cuidadoCorporal
	 *@param string $embarazo
	 *Crea un nuevo registro de Padecimiento
	 *@return true
	 */
	function create($diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
					$retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo){
		$this->diabetes 		 = $diabetes;
		$this->obesisdad  		 = $obesisdad;
		$this->depresion 		 = $depresion;
		$this->estres  			 = $estres;
		$this->sobrepeso 		 = $sobrepeso;
		$this->estrenimiento	 = $estrenimiento;
		$this->colitis 			 = $colitis;
		$this->retencionLiquidos = $retencionLiquidos;
		$this->transtornoMes 	 = $transtornoMes;
		$this->cuidadoCorporal   = $cuidadoCorporal;
		$this->embarazo   		 = $embarazo;
		
		return true;
	}
}
?>