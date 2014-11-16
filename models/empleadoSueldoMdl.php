<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de los sueldos de los empleados
	*/
class EmpleadoSueldoMdl extends BaseMdl{
	private $idEmpleado;
	private $sueldo;
	
	/**
	 *@param int $idEmpleado
	 *@param string $sueldo
	 *Crea un nuevo idEmpleado de movimiento de almacen
	 *@return true
	 */
	function create($idEmpleado, $sueldo){
		$this->idEmpleado 	= $idEmpleado;
		$this->sueldo		= $sueldo;
		
		$stmt = $this->driver->prepare("INSERT INTO 
										EmpleadoSueldo (IDEmpleado,Sueldo)
										VALUES(?,?)");
		if(!$stmt->bind_param('ii',$this->idEmpleado,$this->sueldo)){
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
	*Actualiza la información del sueldo de algún empleado
	*@param int $idEmpleadoSueldo
	*@param int $idEmpleado
	*@param string $sueldo
	*@return true or false
	**/
	function update($idEmpleadoSueldo,$idEmpleado, $sueldo){
		if($stmt = $this->driver->prepare('SELECT IDEmpleadoSueldo FROM EmpleadoSueldo WHERE IDEmpleadoSueldo=?')){
		
			if(!$stmt->bind_param('i',$idEmpleadoSueldo))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDEmpleadoSueldo']!=''){
				$this->idEmpleado	= $idEmpleado;
				$this->sueldo		= $sueldo;
				
				$stmt = $this->driver->prepare("UPDATE EmpleadoSueldo SET IDEmpleado=?,Sueldo=? WHERE IDEmpleadoSueldo=?");
				if(!$stmt->bind_param('iii',$this->idEmpleado,$this->sueldo,$idEmpleadoSueldo)){
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
	* Consulta a los sueldos de los empleados registrados
	*@param int $offset
	*@param int $idEmpleadoSueldo
	*@param string $constrain
	* @return array or false
	**/
	function lists($offset = -1,$idEmpleadoSueldo = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM EmpleadoSueldo WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idEmpleadoSueldo>-1){
				$stmt = $this->driver->prepare('SELECT * FROM EmpleadoSueldo WHERE IDEmpleadoSueldo=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM EmpleadoSueldo WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idEmpleadoSueldo>-1){
				if(!$stmt->bind_param('i',$idEmpleadoSueldo))
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
