<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Cargo, el cargo que se le asigna a un empleado
	*/
class CargoMdl  extends BaseMdl{
	private $cargo;
	private $descripcion;
	
	/**
	 *@param string $cargo
	 *@param string $descripcion
	 *Crea un nuevo tipo de cargo para los empleados
	 *@return true
	 */
	function create($cargo, $descripcion){
		$this->cargo 		= $this->driver->real_escape_string($cargo);
		$this->descripcion	= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO Cargo (Cargo,Descripcion) 
										VALUES(?,?)");
		if(!$stmt->bind_param('ss',$this->cargo,$this->descripcion)){
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
	*Actualiza la información de un cargo
	*@return true or false
	**/
	function update($idCargo,$cargo, $descripcion){
		if($stmt = $this->driver->prepare('SELECT IDCargo FROM Cargo WHERE IDCargo=?')){
		
			if(!$stmt->bind_param('i',$idCargo))
				die('Error Al Actualizar');
			
			if(!$stmt->execute())
				die('Error Al Actualizar');
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDCargo']!=''){
				$this->cargo 		= $this->driver->real_escape_string($cargo);
				$this->descripcion	= $this->driver->real_escape_string($descripcion);
				
				$stmt = $this->driver->prepare("UPDATE Cargo SET Cargo=?,Descripcion=? WHERE IDCargo=?");

				if(!$stmt->bind_param('ssi',$this->cargo,$this->descripcion,$idCargo)){
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
			die('Error al Actualizar en la base de datos');
	}
}
?>