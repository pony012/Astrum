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
		
		$stmt = $this->driver->prepare("INSERT INTO Consulta (IdCliente, IdTerapeuta, IdHistorialMedico, FechaCita, IdConsultaStatus, Observaciones)
										VALUES(?,?,?,?,?,?)");
		if(!$stmt->bind_param('iiisis',$this->idcliente,$this->idTerapeuta,$this->idHistorialMedico,$this->fechaCita,$this->idConsultaStatus,$this->observaciones)){
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
}
?>