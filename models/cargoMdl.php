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
	*Actualiza la información de un cargo
	*@return true or false
	**/
	function update($idCargo,$cargo, $descripcion){
		if($stmt = $this->driver->prepare('SELECT IDCargo FROM Cargo WHERE IDCargo=?')){
		
			if(!$stmt->bind_param('i',$idCargo))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDCargo']!=''){
				$this->cargo 		= $this->driver->real_escape_string($cargo);
				$this->descripcion	= $this->driver->real_escape_string($descripcion);
				
				$stmt = $this->driver->prepare("UPDATE Cargo SET Cargo=?,Descripcion=? WHERE IDCargo=?");

				if(!$stmt->bind_param('ssi',$this->cargo,$this->descripcion,$idCargo)){
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
	* Consulta los cargos registrados en el sistema
	*@param int $offset
	*@param int $idCargo
	* @return array or false
	**/
	function lists($offset = -1,$idCargo = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Cargo LIMIT ?,?');
		}else{
			if($idCargo>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Cargo WHERE IDCargo=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Cargo');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idCargo>-1){
				if(!$stmt->bind_param('i',$idCargo))
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