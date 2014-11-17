<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Alimentación, que son de datos del historial Medico
	*/
class AlimentacionMdl extends BaseMdl{
	private $buena;
	private $regular;
	private $mala;

	/**
	 *@param int $idHistorialMedico
	 *@param string $buena
	 *@param string $regular
	 *@param string $mala
	 *Crea un nuevo registro de alimentacion
	 *@return true
	 */
	function create($idHistorialMedico, $buena,$regular,$mala){
		$this->buena = $this->driver->real_escape_string($buena);
		$this->regular = $this->driver->real_escape_string($regular);
		$this->mala = $this->driver->real_escape_string($mala);
		
		$stmt = $this->driver->prepare("INSERT INTO Alimentacion (IDHistorialMedico,Buena,Regular,Mala) VALUES (?,?,?,?)");
		if(!$stmt->bind_param('isss',$idHistorialMedico, $this->buena,$this->regular,$this->mala))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;

		return true;
	}

	/**
	*Actualiza la información de la Alimentación
	*@param int $idHistorialMedico
	*@param string $buena
	*@param string $regular
	*@param string $mala
	*@return true or false
	**/
	function update($idAlimentacion,$idHistorialMedico,$buena,$regular,$mala){
		if($stmt = $this->driver->prepare('SELECT IDAlimentacion FROM Alimentacion WHERE IDAlimentacion=?')){
		
			if(!$stmt->bind_param('i',$idAlimentacion))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDAlimentacion']!=''){
				$this->buena 	 = $this->driver->real_escape_string($buena);
				$this->regular 	 = $this->driver->real_escape_string($regular);
				$this->mala 	 = $this->driver->real_escape_string($mala);
				
				$stmt = $this->driver->prepare("UPDATE Alimentacion SET IDHistorialMedico=?,Poca=?,Regular=?,Mucha=? WHERE IDAlimentacion=?");

				if(!$stmt->bind_param('isssi',$idHistorialMedico, $this->buena,$this->regular,$this->mala,$idAlimentacion)){
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
	* Consulta las alimentaciones registrados en el sistema
	*@param int $offset
	*@param int $idAlimentacion
	* @return array or false
	**/
	function lists($offset = -1,$idAlimentacion = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Alimentacion WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idAlimentacion>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Alimentacion WHERE IDAlimentacion=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Alimentacion WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idAlimentacion>-1){
				if(!$stmt->bind_param('i',$idAlimentacion))
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