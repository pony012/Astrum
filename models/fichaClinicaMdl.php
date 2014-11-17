<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de FichaClinica del cliente
	*/
class FichaClinicaMdl extends BaseMdl{
	private $motivoConsulta;
	private $tiempoProblema;
	private $relacionaCon;
	private $tratamientoAnterior;
	private $metProbados;
	private $resAnteriores;
	
	/**
	 *@param int $idHistorialMedico
	 *@param string $motivoConsulta
	 *@param string $tiempoProblema
	 *@param string $relacionaCon
	 *@param string $tratamientoAnterior
	 *@param string $metProbados
	 *@param string $resAnteriores
	 *Crea un nuevo registro de Ficha Clinica
	 *@return true
	 */
	function create($idHistorialMedico, $motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores){
		$this->motivoConsulta		= $this->driver->real_escape_string($motivoConsulta);
		$this->tiempoProblema		= $this->driver->real_escape_string($tiempoProblema);
		$this->relacionaCon 		= $this->driver->real_escape_string($relacionaCon);
		$this->tratamientoAnterior 	= $this->driver->real_escape_string($tratamientoAnterior);
		$this->metProbados 			= $this->driver->real_escape_string($metProbados);
		$this->resAnteriores 		= $this->driver->real_escape_string($resAnteriores);
		
		$stmt = $this->driver->prepare("INSERT INTO FichaClinica (IDHistorialMedico,MotivoConsulta, TiempoProblema, RelacionaCon, TratamientoAnterior, 
																	MetodosProbados, ResultadosAnteriores) 
										VALUES(?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('issssss',$idHistorialMedico, $this->motivoConsulta, $this->tiempoProblema, $this->relacionaCon, $this->tratamientoAnterior, 
										$this->metProbados, $this->resAnteriores)){
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
	*Actualiza la información de la Ficha Clínica
	*@param int $idFichaClinica
	*@param int $idHistorialMedico
	*@param string $motivoConsulta
	*@param string $tiempoProblema
	*@param string $relacionaCon
	*@param string $tratamientoAnterior
	*@param string $metProbados
	*@param string $resAnteriores
	*@return true or false
	**/
	function update($idFichaClinica,$idHistorialMedico, $motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores){
		if($stmt = $this->driver->prepare('SELECT IDFichaClinica FROM FichaClinica WHERE IDFichaClinica=?')){
		
			if(!$stmt->bind_param('i',$idFichaClinica))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDFichaClinica']!=''){
				$this->motivoConsulta		= $this->driver->real_escape_string($motivoConsulta);
				$this->tiempoProblema		= $this->driver->real_escape_string($tiempoProblema);
				$this->relacionaCon 		= $this->driver->real_escape_string($relacionaCon);
				$this->tratamientoAnterior 	= $this->driver->real_escape_string($tratamientoAnterior);
				$this->metProbados 			= $this->driver->real_escape_string($metProbados);
				$this->resAnteriores 		= $this->driver->real_escape_string($resAnteriores);
				
				$stmt = $this->driver->prepare("UPDATE FichaClinica SET IDHistorialMedico=?,MotivoConsulta=?, TiempoProblema=?, RelacionaCon=?, TratamientoAnterior=?, 
																	MetodosProbados=?, ResultadosAnteriores=? WHERE IDFichaClinica=?");

				if(!$stmt->bind_param('issssssi',$idHistorialMedico, $this->motivoConsulta, $this->tiempoProblema, $this->relacionaCon, $this->tratamientoAnterior, 
										$this->metProbados, $this->resAnteriores,$idFichaClinica)){
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
	* Consulta las Fichas Clínicas registrados en el sistema
	*@param int $offset
	*@param int $idFichaClinica
	* @return array or false
	**/
	function lists($offset = -1,$idFichaClinica = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM FichaClinica WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idFichaClinica>-1){
				$stmt = $this->driver->prepare('SELECT * FROM FichaClinica WHERE IDFichaClinica=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM FichaClinica WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idFichaClinica>-1){
				if(!$stmt->bind_param('i',$idFichaClinica))
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
