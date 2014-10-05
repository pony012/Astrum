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
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()) {
			die('Error al insertar en la base de datos');
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
				die('Error Al Actualizar');
			
			if(!$stmt->execute())
				die('Error Al Actualizar');
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDConsultaStatus']!=''){
				$this->status		= $this->driver->real_escape_string($status);
				$this->descripcion	= $this->driver->real_escape_string($descripcion);
				
				$stmt = $this->driver->prepare("UPDATE ConsultaStatus SET Status=?,Descripcion=? WHERE IDConsultaStatus=?");
				if(!$stmt->bind_param('ssi',$this->status,$this->descripcion,$idConsultaStatus)){
					die('Error al Actualizar en la base de datos');
				}
				if (!$stmt->execute()) {
					die('Error al Actualizar en la base de datos');
				}

				if($this->driver->error){
					return false;
				}

				return true;
			}
		}
		else		
			die('Error Al Actualizar');
	}

}

?>