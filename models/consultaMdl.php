<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Consulta
	*/
class ConsultaMdl extends BaseMdl{
	private $idcliente;
	private $idTerapeuta;
	private $idHistorialMedico;
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
	function create($idcliente, $idTerapeuta, $idHistorialMedico, $fechaCita, $idConsultaStatus, $observaciones){
		$this->idcliente 		= $idcliente;
		$this->idTerapeuta		= $idTerapeuta;
		$this->idHistorialMedico= $idHistorialMedico;
		$this->fechaCita		= $fechaCita;
		$this->idConsultaStatus	= $idConsultaStatus;
		$this->observaciones	= $this->driver->real_escape_string($observaciones);
		
		$stmt = $this->driver->prepare("INSERT INTO Consulta (IDCliente, IDTerapeuta, IDHistorialMedico, FechaCita, IDConsultaStatus, Observaciones)
										VALUES(?,?,?,?,?,?)");
		if(!$stmt->bind_param('iiisis',$this->idcliente,$this->idTerapeuta,$this->idHistorialMedico,$this->fechaCita,$this->idConsultaStatus,$this->observaciones)){
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
	* Busca a las Consultas registradas
	*@param int $offset
	*@param int $idConsulta
	* @return array or false
	**/
	
	function lists($offset = -1,$idConsulta = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Consulta LIMIT ?,?');
		}else{
			if($idConsulta>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Consulta WHERE IDConsulta=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Consulta');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idConsulta>-1){
				if(!$stmt->bind_param('i',$idConsulta))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}
}
?>