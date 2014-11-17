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
	 *@param int $idHistorialMedico
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
	function create($idHistorialMedico, $peellingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
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

		$stmt = $this->driver->prepare("INSERT INTO Exfolacion (IDHistorialMedico,PeellingQuimico, Laser, Dermoabrasion, RetinA, Renova, Racutan, 
																Adapaleno, AcidoGlicolico, AlfaHidroxiacidos, ExfolianteGranuloso,
																AcidoLactico, VitaminaA, BlanqueadorOAclarador) 
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('isssssssssssss',	$idHistorialMedico, $this->peellingQuim, $this->laser, $this->dermobrasion, $this->retinA, $this->renova, 
												$this->racutan, $this->adapaleno, $this->acidoGlicolico, $this->alfaHidroiacidos, 
												$this->exfolianteGranuloso, $this->acidoLactico, $this->vitaminaA, $this->blanqueadorAclarador)){
			return false;
		}
		if (!$stmt->execute()) {
			return false;
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}

	/**
	*Actualiza la información de la Alimentación
	*@param int $idHistorialMedico
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
	*@return true or false
	**/
	function update($idExfoliacion,$idHistorialMedico, $peellingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
					$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
					$acidoLactico,$vitaminaA,$blanqueadorAclarador){
		if($stmt = $this->driver->prepare('SELECT IDExfoliacion FROM Exfoliacion WHERE IDExfoliacion=?')){
		
			if(!$stmt->bind_param('i',$idExfoliacion))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDExfoliacion']!=''){
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
				
				$stmt = $this->driver->prepare("UPDATE Exfoliacion SET IDHistorialMedico=?,PeellingQuimico=?, Laser=?, Dermoabrasion=?, RetinA=?, Renova=?, Racutan=?, 
																Adapaleno=?, AcidoGlicolico=?, AlfaHidroxiacidos=?, ExfolianteGranuloso=?,
																AcidoLactico=?, VitaminaA=?, BlanqueadorOAclarador=? WHERE IDExfoliacion=?");

				if(!$stmt->bind_param('isssssssssssssi',$idHistorialMedico, $this->peellingQuim, $this->laser, $this->dermobrasion, $this->retinA, $this->renova, 
												$this->racutan, $this->adapaleno, $this->acidoGlicolico, $this->alfaHidroiacidos, 
												$this->exfolianteGranuloso, $this->acidoLactico, $this->vitaminaA, $this->blanqueadorAclarador,$idExfoliacion)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta las alimentaciones registrados en el sistema
	*@param int $offset
	*@param int $idExfoliacion
	* @return array or false
	**/
	function lists($offset = -1,$idExfoliacion = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Exfoliacion WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idExfoliacion>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Exfoliacion WHERE IDExfoliacion=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Exfoliacion WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idExfoliacion>-1){
				if(!$stmt->bind_param('i',$idExfoliacion))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}
}
?>