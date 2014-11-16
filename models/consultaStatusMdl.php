<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo CosultaStatus
	*/
class ConsultaStatusMdl extends BaseMdl{
	private $status;
	private $descripcion;
	
	/**
	 *@param string $status
	 *@param string $descripcion
	 *Crea un nuevo status para las consultas
	 *@return true
	 */
	function create($status, $descripcion){
		$this->status		= $this->driver->real_escape_string($status);
		$this->descripcion	= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO ConsultaStatus (Status,Descripcion) 
										VALUES(?,?)");
		if(!$stmt->bind_param('ss',$this->status,$this->descripcion)){
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
	*Actualiza la información del estado de una consulta
	*@return true or false
	**/
	function update($idConsultaStatus, $status, $descripcion){
		if($stmt = $this->driver->prepare('SELECT IDConsultaStatus FROM ConsultaStatus WHERE IDConsultaStatus=?')){
		
			if(!$stmt->bind_param('i',$idConsultaStatus))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDConsultaStatus']!=''){
				$this->status		= $this->driver->real_escape_string($status);
				$this->descripcion	= $this->driver->real_escape_string($descripcion);
				
				$stmt = $this->driver->prepare("UPDATE ConsultaStatus SET Status=?,Descripcion=? WHERE IDConsultaStatus=?");
				if(!$stmt->bind_param('ssi',$this->status,$this->descripcion,$idConsultaStatus)){
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
	* Consulta a los status registrados
	*@param int $offset
	*@param int $idConsultaStatus
	* @return array or false
	**/
	function lists($offset = -1,$idConsultaStatus = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM ConsultaStatus LIMIT ?,?');
		}else{
			if($idConsultaStatus>-1){
				$stmt = $this->driver->prepare('SELECT * FROM ConsultaStatus WHERE IDConsultaStatus=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM ConsultaStatus');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idConsultaStatus>-1){
				if(!$stmt->bind_param('i',$idConsultaStatus))
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