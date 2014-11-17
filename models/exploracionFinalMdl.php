<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo
	*/
class ExploracionFinalMdl extends BaseMdl{
	private $pesoFin;
	private $bustoFin;
	private $diafragmaFin;
	private $brazoFin;
	private $cinturaFin;
	private $abdomenFin;
	private $caderaFin;
	private $musloFin;
	
	/**
	 *@param decimal $pesoFin
	 *@param decimal $bustoFin
	 *@param decimal $diafragmaFin
	 *@param decimal $brazoFin
	 *@param decimal $cinturaFin
	 *@param decimal $abdomenFin
	 *@param decimal $caderaFin
	 *@param decimal $musloFin
	 *Inserta los datos finales de la exploracion de un cliente
	 *@return true
	**/
	function create($lastId, $pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin){
		$this->pesoFin 		= $this->driver->real_escape_string($pesoFin);
		$this->bustoFin 	= $this->driver->real_escape_string($bustoFin);
		$this->diafragmaFin = $this->driver->real_escape_string($diafragmaFin);
		$this->brazoFin 	= $this->driver->real_escape_string($brazoFin);
		$this->cinturaFin 	= $this->driver->real_escape_string($cinturaFin);
		$this->abdomenFin 	= $this->driver->real_escape_string($abdomenFin);
		$this->caderaFin 	= $this->driver->real_escape_string($caderaFin);
		$this->musloFin 	= $this->driver->real_escape_string($musloFin);

		$stmt = $this->driver->prepare("INSERT INTO ExploracionFinal (IDHistorialMedico,PesoFinal,BustoFinal,DiafragmaFinal,BrazoFinal,CinturaFinal,
										AbdomenFinal,CaderaFinal,MusloFinal) VALUES (?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('idddddddd',$lastId, $this->pesoFin,$this->bustoFin,$this->diafragmaFin,$this->brazoFin,$this->cinturaFin,$this->abdomenFin,
			$this->caderaFin,$this->musloFin))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;
		
		return true;
	}

	/**
	*Actualiza la información de la Exploración Final
	*@param decimal $pesoFin
	 *@param decimal $bustoFin
	 *@param decimal $diafragmaFin
	 *@param decimal $brazoFin
	 *@param decimal $cinturaFin
	 *@param decimal $abdomenFin
	 *@param decimal $caderaFin
	 *@param decimal $musloFin
	*@return true or false
	**/
	function update($idExploracionFinal,$idHistorialMedico, $pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin){
		if($stmt = $this->driver->prepare('SELECT IDExploracionFinal FROM ExploracionFinal WHERE IDExploracionFinal=?')){
		
			if(!$stmt->bind_param('i',$idExploracionFinal))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDExploracionFinal']!=''){
				$this->pesoFin 		= $this->driver->real_escape_string($pesoFin);
				$this->bustoFin 	= $this->driver->real_escape_string($bustoFin);
				$this->diafragmaFin = $this->driver->real_escape_string($diafragmaFin);
				$this->brazoFin 	= $this->driver->real_escape_string($brazoFin);
				$this->cinturaFin 	= $this->driver->real_escape_string($cinturaFin);
				$this->abdomenFin 	= $this->driver->real_escape_string($abdomenFin);
				$this->caderaFin 	= $this->driver->real_escape_string($caderaFin);
				$this->musloFin 	= $this->driver->real_escape_string($musloFin);
				
				$stmt = $this->driver->prepare("UPDATE IDHistorialMedico=?,PesoFinal=?,BustoFinal=?,DiafragmaFinal=?,BrazoFinal=?,CinturaFinal=?,
										AbdomenFinal=?,CaderaFinal=?,MusloFinal=? WHERE IDExploracionFinal=?");

				if(!$stmt->bind_param('idddddddd',$idHistorialMedico, $this->pesoFin,$this->bustoFin,$this->diafragmaFin,$this->brazoFin,$this->cinturaFin,$this->abdomenFin,
													$this->caderaFin,$this->musloFin,$idExploracionFinal)){
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
	* Consulta las Exploraciones Finales registrados en el sistema
	*@param int $offset
	*@param int $idExploracionFinal
	* @return array or false
	**/
	function lists($offset = -1,$idExploracionFinal = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM ExploracionFinal WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idExploracionFinal>-1){
				$stmt = $this->driver->prepare('SELECT * FROM ExploracionFinal WHERE IDExploracionFinal=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM ExploracionFinal WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idExploracionFinal>-1){
				if(!$stmt->bind_param('i',$idExploracionFinal))
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