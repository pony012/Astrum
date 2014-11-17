<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Habito, que son datos del cliente
	*/
class HabitoMdl extends BaseMdl{
	private $fumar;
	private $ejercicio;
	private $usarFaja;
	private $suenio;
	private $tomaSol;
	private $bloqueador;
	private $hidroquinona;
	
	/**
	*@param string $fumar
	*@param string $ejercicio
	*@param string $usarFaja
	*@param string $suenio
	*@param string $tomaSol
	*@param string $bloqueador
	*@param string $hidroquinona
	*Crea un nuevo registro de habito
	 *@return true
	 */
	function create($idHistorialMedico, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona){
		$this->fumar 		= $this->driver->real_escape_string($fumar);
		$this->ejercicio 	= $this->driver->real_escape_string($ejercicio);
		$this->usarFaja 	= $this->driver->real_escape_string($usarFaja);
		$this->suenio 		= $this->driver->real_escape_string($suenio);
		$this->tomaSol 		= $this->driver->real_escape_string($tomaSol);
		$this->bloqueador 	= $this->driver->real_escape_string($bloqueador);
		$this->hidroquinona = $this->driver->real_escape_string($hidroquinona);
		
		$stmt = $this->driver->prepare("INSERT INTO Habito (IDHistorialMedico, Fumar, Ejercicio, UsarFaja, Suenio, TomaSol, Bloqueador, Hidroquinona) 
										VALUES (?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('isssssss',$idHistorialMedico, $this->fumar, $this->ejercicio, $this->usarFaja, $this->suenio, $this->tomaSol, $this->bloqueador, $this->hidroquinona)){
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
	*Actualiza la información de Habito
	*@param int $idHabito
	*@param int $idHistorialMedico
	*@param string $fumar
	 *@param string $ejercicio
	 *@param string $usarFaja
	 *@param string $suenio
	 *@param string $tomaSol
	 *@param string $bloqueador
	 *@param string $hidroquinona
	*@return true or false
	**/
	function update($idHabito,$idHistorialMedico, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona){
		if($stmt = $this->driver->prepare('SELECT IDHabito FROM Habito WHERE IDHabito=?')){
		
			if(!$stmt->bind_param('i',$idHabito))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHabito']!=''){
				$this->motivoConsulta		= $this->driver->real_escape_string($motivoConsulta);
				$this->tiempoProblema		= $this->driver->real_escape_string($tiempoProblema);
				$this->relacionaCon 		= $this->driver->real_escape_string($relacionaCon);
				$this->tratamientoAnterior 	= $this->driver->real_escape_string($tratamientoAnterior);
				$this->metProbados 			= $this->driver->real_escape_string($metProbados);
				$this->resAnteriores 		= $this->driver->real_escape_string($resAnteriores);
				
				$stmt = $this->driver->prepare("UPDATE Habito SET IDHistorialMedico=?, Fumar=?, Ejercicio=?, UsarFaja=?, Suenio=?, TomaSol=?, Bloqueador=?, 
												Hidroquinona=? WHERE IDHabito=?");

				if(!$stmt->bind_param('isssssssi',$idHistorialMedico, $this->fumar, $this->ejercicio, $this->usarFaja, $this->suenio, $this->tomaSol, $this->bloqueador, $this->hidroquinona,$idHabito)){
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
	* Consulta los Habitos registrados en el sistema
	*@param int $offset
	*@param int $idHabito
	* @return array or false
	**/
	function lists($offset = -1,$idHabito = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Habito WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHabito>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Habito WHERE IDHabito=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Habito WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHabito>-1){
				if(!$stmt->bind_param('i',$idHabito))
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