<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Exfolacion
	*/
class ExfolacionMdl extends BaseMdl{
	private $peellingQuim;
	private $laser;
	private $dermobrasion;
	private $retinA;
	private $renova;
	private $racutan;
	private $adapaleno;
	private $acidoGlicolico;
	private $alfaHidroiacidos;
	private $exfolianteGranuloso;
	private $acidoLactico;
	private $vitaminaA;
	private $blanqueadorAclarador;
	/**
	 *@param string $peellingQuim
	 *@param string $laser
	 *@param string $dermobrasion
	 *@param string $retinA
	 *@param string $racutan
	 *@param string $adapaleno
	 *@param string $acidoGlicolico
	 *@param string $exfolianteGranuloso
	 *@param string $acidoLactico
	 *@param string $vitaminaA
	 *@param string $blanqueadorAclarador
	 *Crea un nuevo registro de Exfolacion
	 *@return true
	 */
	function create($peellingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
					$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
					$acidoLactico,$vitaminaA,$blanqueadorAclarador){
		$this->peellingQuim			= $peellingQuim;
		$this->laser				= $laser;
		$this->dermobrasion			= $dermobrasion;
		$this->retinA				= $retinA;
		$this->renova				= $renova;
		$this->racutan				= $racutan;
		$this->adapaleno			= $adapaleno;
		$this->acidoGlicolico		= $acidoGlicolico;
		$this->alfaHidroiacidos		= $alfaHidroiacidos;
		$this->exfolianteGranuloso	= $exfolianteGranuloso;
		$this->acidoLactico			= $acidoLactico;
		$this->vitaminaA			= $vitaminaA;
		$this->blanqueadorAclarador	= $blanqueadorAclarador;
		
		return true;
	}
}
?>