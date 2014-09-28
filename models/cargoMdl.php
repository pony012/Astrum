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
		
		$result = $this->driver->query("INSERT INTO Cargo (Cargo,Descripcion) 
								VALUES('$this->cargo','$this->descripcion')");
		
		if($this->driver->error){
			return false;
		}
		return true;
	}
}
?>