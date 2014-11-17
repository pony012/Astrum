<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo AguaAlDia que son parte de los datos del historial Medico
	*/
class AguaAlDiaMdl extends BaseMdl{
	private $poca;
	private $regular;
	private $mucha;
	/**
	 *@param int $idHistorialMedico
	 *@param string $poca
	 *@param string $regular
	 *@param string $mucha
	 *Crea un nuevo registro del consumo de agua diaria
	 *@return true
	 */
	$idHistorialMedico,$poca,$regular,$mucha
	function create($idHistorialMedico, $poca,$regular,$mucha){
		$this->poca 	 	= $this->driver->real_escape_string($poca);
		$this->regular		= $this->driver->real_escape_string($regular);
		$this->mucha 		= $this->driver->real_escape_string($mucha);
		
		$stmt = $this->driver->prepare("INSERT INTO AguaAlDia (IDHistorialMedico,Poca,Regular,Mucha) VALUES (?,?,?,?)");
		if(!$stmt->bind_param('isss',$idHistorialMedico, $this->poca,$this->regular,$this->mucha))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;

		return true;
	}

	/**
	*Actualiza la información de Agua al dia
	*@param int $idAguaAlDia
	*@param int $idHistorialMedico
	*@param string $poca
	*@param string $regular
	*@param string $mucha
	*@return true or false
	**/
	function update($idAguaAlDia,$idHistorialMedico,$poca,$regular,$mucha){
		if($stmt = $this->driver->prepare('SELECT IDAguaAlDia FROM AguaAlDia WHERE IDAguaAlDia=?')){
		
			if(!$stmt->bind_param('i',$idAguaAlDia))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDAguaAlDia']!=''){
				$this->poca 	 = $this->driver->real_escape_string($poca);
				$this->regular 	 = $this->driver->real_escape_string($regular);
				$this->mucha 	 = $this->driver->real_escape_string($mucha);
				
				$stmt = $this->driver->prepare("UPDATE AguaAlDia SET IDHistorialMedico=?,Poca=?,Regular=?,Mucha=? WHERE IDAguaAlDia=?");

				if(!$stmt->bind_param('isssi',$idHistorialMedico, $this->poca,$this->regular,$this->mucha,$idAguaAlDia)){
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
	* Consulta los registros de Consumo de Agua al Día registrados en el sistema
	*@param int $offset
	*@param int $idAguaAlDia
	* @return array or false
	**/
	function lists($offset = -1,$idAguaAlDia = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM AguaAlDia WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idAguaAlDia>-1){
				$stmt = $this->driver->prepare('SELECT * FROM AguaAlDia WHERE IDAguaAlDia=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM AguaAlDia WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idAguaAlDia>-1){
				if(!$stmt->bind_param('i',$idAguaAlDia))
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
