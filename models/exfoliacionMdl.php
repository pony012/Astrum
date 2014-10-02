<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Exfolacion
	*/
class ExfoliacionMdl extends BaseMdl{
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
		$this->peellingQuim			= $this->driver->real_escape_string($peellingQuim);
		$this->laser				= $this->driver->real_escape_string($laser);
		$this->dermobrasion			= $this->driver->real_escape_string($dermobrasion);
		$this->retinA				= $this->driver->real_escape_string($retinA);
		$this->renova				= $this->driver->real_escape_string($renova);
		$this->racutan				= $this->driver->real_escape_string($racutan);
		$this->adapaleno			= $this->driver->real_escape_string($adapaleno);
		$this->acidoGlicolico		= $this->driver->real_escape_string($acidoGlicolico);
		$this->alfaHidroiacidos		= $this->driver->real_escape_string($alfaHidroiacidos);
		$this->exfolianteGranuloso	= $this->driver->real_escape_string($exfolianteGranuloso);
		$this->acidoLactico			= $this->driver->real_escape_string($acidoLactico);
		$this->vitaminaA			= $this->driver->real_escape_string($vitaminaA);
		$this->blanqueadorAclarador	= $this->driver->real_escape_string($blanqueadorAclarador);

		$stmt = $this->driver->prepare("INSERT INTO Exfolacion (PeellingQuim, Laser, Dermoabrasion, RetinA, Renova, Racutan, 
																Adapaleno, AcidoGlicolico, AlfaHidroxiacidos, ExfolianteGranuloso,
																AcidoLactico, VitaminaA, BlanqueadorOAclarador) 
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('sssssssssssss',	$this->peellingQuim, $this->laser, $this->dermobrasion, $this->retinA, $this->renova, 
												$this->racutan, $this->adapaleno, $this->acidoGlicolico, $this->alfaHidroiacidos, 
												$this->exfolianteGranuloso, $this->acidoLactico, $this->vitaminaA, $this->blanqueadorAclarador)){
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()) {
			die('Error al insertar en la base de datos');
		}

		if($this->driver->error){
			return false;
		}
		
		if($this->driver->error){
			return false;
		}

		return true;
	}
}
?>