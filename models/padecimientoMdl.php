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
	 *@param int $idHistorialMedico
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
	function create($idHistorialMedico, $diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
					$retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo){
		$this->diabetes 		 = $this->driver->real_escape_string($diabetes);
		$this->obesisdad  		 = $this->driver->real_escape_string($obesisdad);
		$this->depresion 		 = $this->driver->real_escape_string($depresion);
		$this->estres  			 = $this->driver->real_escape_string($estres);
		$this->sobrepeso 		 = $this->driver->real_escape_string($sobrepeso);
		$this->estrenimiento	 = $this->driver->real_escape_string($estrenimiento);
		$this->colitis 			 = $this->driver->real_escape_string($colitis);
		$this->retencionLiquidos = $this->driver->real_escape_string($retencionLiquidos);
		$this->transtornoMes 	 = $this->driver->real_escape_string($transtornoMes);
		$this->cuidadoCorporal   = $this->driver->real_escape_string($cuidadoCorporal);
		$this->embarazo   		 = $embarazo;
		
		$stmt = $this->driver->prepare("INSERT INTO Padecimiento (IDHistorialMedico,Diabetes, Obesisdad, Depresion, Estres, Sobrepeso, Estreñimiento,
																Colitis, RetencionLiquidos, TranstornosMenstruales, CuidadoCorporal, Embarazo) 
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('issssssssssi',$idHistorialMedico, $this->diabetes,$this->obesisdad,$this->depresion,$this->estres,$this->sobrepeso,$this->estrenimiento,
											$this->colitis,$this->retencionLiquidos,$this->transtornoMes,$this->cuidadoCorporal,$this->embarazo)){
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
	*Actualiza la información de Padecimiento
	*@param int $idPadecimiento
	*@param int $idHistorialMedico
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
	*@return true or false
	**/
	function update($idPadecimiento,$idHistorialMedico, $diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
					$retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo){
		if($stmt = $this->driver->prepare('SELECT IDPadecimiento FROM Padecimiento WHERE IDPadecimiento=?')){
		
			if(!$stmt->bind_param('i',$idPadecimiento))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDPadecimiento']!=''){
				$this->diabetes 		 = $this->driver->real_escape_string($diabetes);
				$this->obesisdad  		 = $this->driver->real_escape_string($obesisdad);
				$this->depresion 		 = $this->driver->real_escape_string($depresion);
				$this->estres  			 = $this->driver->real_escape_string($estres);
				$this->sobrepeso 		 = $this->driver->real_escape_string($sobrepeso);
				$this->estrenimiento	 = $this->driver->real_escape_string($estrenimiento);
				$this->colitis 			 = $this->driver->real_escape_string($colitis);
				$this->retencionLiquidos = $this->driver->real_escape_string($retencionLiquidos);
				$this->transtornoMes 	 = $this->driver->real_escape_string($transtornoMes);
				$this->cuidadoCorporal   = $this->driver->real_escape_string($cuidadoCorporal);
				$this->embarazo   		 = $embarazo;
				
				$stmt = $this->driver->prepare("UPDATE Padecimiento SET IDHistorialMedico=?,Diabetes=?, Obesisdad=?, Depresion=?, Estres=?, Sobrepeso=?, Estreñimiento=?,
																Colitis=?, RetencionLiquidos=?, TranstornosMenstruales=?, CuidadoCorporal=?, Embarazo=? WHERE IDPadecimiento=?");

				if(!$stmt->bind_param('issssssssssii',$idHistorialMedico, $this->diabetes,$this->obesisdad,$this->depresion,$this->estres,$this->sobrepeso,$this->estrenimiento,
											$this->colitis,$this->retencionLiquidos,$this->transtornoMes,$this->cuidadoCorporal,$this->embarazo,$idPadecimiento)){
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
	* Consulta los Padecimientos registrados en el sistema
	*@param int $offset
	*@param int $idPadecimiento
	* @return array or false
	**/
	function lists($offset = -1,$idPadecimiento = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Padecimiento WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idPadecimiento>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Padecimiento WHERE IDPadecimiento=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Padecimiento WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idPadecimiento>-1){
				if(!$stmt->bind_param('i',$idPadecimiento))
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