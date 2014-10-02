<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo HistorialMedico del cliente
	*/
class HistorialMedicoMdl extends BaseMdl{
	private $idCliente;
	private $fechaRegistro;
	private $idServicio;
	private $observaciones;
	
	/**
	 *@param integer $idCliente
	 *@param date $fechaRegistro
	 *@param integer $idServicio
	 *@param string $observaciones
	 *Crea un nuevo historial medico de un cliente
	 *@return true
	 */
	function create($idCliente, $fechaRegistro, $idServicio, $observaciones){
		$this->idCliente 		= $idCliente;
		$this->fechaRegistro	= $fechaRegistro;
		$this->idServicio		= $idServicio;
		$this->observaciones	= $this->driver->real_escape_string($observaciones);
		
		$stmt = $this->driver->prepare("INSERT INTO HistorialMedico (IdCliente, FechaRegistro, IdServicio, Observaciones) 
										VALUES(?,?,?,?)");
		if(!$stmt->bind_param('isis',$this->idCliente,$this->fechaRegistro,$this->idServicio,$this->observaciones)){
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()) {
			die('Error al insertar en la base de datos');
		}

		if($this->driver->error){
			return false;
		}

		isis

		return true;
	}
}
?>