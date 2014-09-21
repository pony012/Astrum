<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo
	*/
class ExploracionMdl extends BaseMdl{
	private $pesoIni;
	private $bustoIni;
	private $diafragmaIni;
	private $brazoIni;
	private $cinturaIni;
	private $abdomenIni;
	private $caderaIni;
	private $musloIni;
	
	private $pesoFin;
	private $bustoFin;
	private $diafragmaFin;
	private $brazoFin;
	private $cinturaFin;
	private $abdomenFin;
	private $caderaFin;
	private $musloFin;
	
	/**
	 *@param decimal $pesoIni
	 *@param decimal $bustoIni
	 *@param decimal $diafragmaIni
	 *@param decimal $brazoIni
	 *@param decimal $cinturaIni
	 *@param decimal $abdomenIni
	 *@param decimal $caderaIni
	 *@param decimal $musloIni
	 *Crea una nueva exploracion con los datos iniciales de un cliente
	 *@return true
	 */
	function createInit($pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni){
		$this->pesoIni = $pesoIni;
		$this->bustoIni = $bustoIni;
		$this->diafragmaIni = $diafragmaIni;
		$this->brazoIni = $brazoIni;
		$this->cinturaIni = $cinturaIni;
		$this->abdomenIni = $abdomenIni;
		$this->caderaIni = $caderaIni;
		$this->musloIni = $musloIni;
		
		return true;
	}
	
	/**
	 *@param decimal $pesoFin
	 *@param decimal $bustoFin
	 *@param decimal $diafragmaFin
	 *@param decimal $brazoFin
	 *@param decimal $cinturaFin
	 *@param decimal $abdomenFin
	 *@param decimal $caderaFin
	 *@param decimal $musloFin
	 *Inserta los datos finales de la exploracion de un cliente
	 *@return true
	 */
	function createFin($pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin){
		$this->pesoFin = $pesoFin;
		$this->bustoFin = $bustoFin;
		$this->diafragmaFin = $diafragmaFin;
		$this->brazoFin = $brazoFin;
		$this->cinturaFin = $cinturaFin;
		$this->abdomenFin = $abdomenFin;
		$this->caderaFin = $caderaFin;
		$this->musloFin = $musloFin;
		
		return true;
	}
}
?>