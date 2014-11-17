<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Exploración Inicial
	*/
class ExploracionInicialMdl extends BaseMdl{
	private $pesoIni;
	private $bustoIni;
	private $diafragmaIni;
	private $brazoIni;
	private $cinturaIni;
	private $abdomenIni;
	private $caderaIni;
	private $musloIni;
	
	/**
	 *@param decimal $pesoIni
	 *@param decimal $bustoIni
	 *@param decimal $diafragmaIni
	 *@param decimal $brazoIni
	 *@param decimal $cinturaIni
	 *@param decimal $abdomenIni
	 *@param decimal $caderaIni
	 *@param decimal $musloIni
	 *Crea una nueva exploracion con los datos iniciales de un cliente
	 *@return true or false
	 */
	function create($idHistorialMedico, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni){
		$this->pesoIni 		= $pesoIni;
		$this->bustoIni 	= $bustoIni;
		$this->diafragmaIni = $diafragmaIni;
		$this->brazoIni 	= $brazoIni;
		$this->cinturaIni 	= $cinturaIni;
		$this->abdomenIni 	= $abdomenIni;
		$this->caderaIni 	= $caderaIni;
		$this->musloIni 	= $musloIni;
		var_dump($this->pesoIni);
		var_dump($this->bustoIni);
		var_dump($this->diafragmaIni);
		var_dump($this->brazoIni);
		var_dump($this->cinturaIni);
		var_dump($this->abdomenIni);
		var_dump($this->caderaIni);
		var_dump($this->musloIni);
		die();
		$stmt = $this->driver->prepare("INSERT INTO ExploracionInicial (IDHistorialMedico,PesoInicial,BustoInicial,DiafragmaInicial,BrazoInicial,CinturaInicial,
										AbdomenInicial,CaderaInicial,MusloInicial) VALUES (?,?,?,?,?,?,?,?,?)");

		if(!$stmt->bind_param('idddddddd',$idHistorialMedico, $this->pesoIni,$this->bustoIni,$this->diafragmaIni,$this->brazoIni,$this->cinturaIni,$this->abdomenIni,
			$this->caderaIni,$this->musloIni)){
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
	*Actualiza la información de la Exploración Inicial
	*@param decimal $pesoIni
	 *@param decimal $bustoIni
	 *@param decimal $diafragmaIni
	 *@param decimal $brazoIni
	 *@param decimal $cinturaIni
	 *@param decimal $abdomenIni
	 *@param decimal $caderaIni
	 *@param decimal $musloIni
	*@return true or false
	**/
	function update($idExploracionInicial,$idHistorialMedico, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni){
		if($stmt = $this->driver->prepare('SELECT IDExploracionInicial FROM ExploracionInicial WHERE IDExploracionInicial=?')){
		
			if(!$stmt->bind_param('i',$idExploracionInicial))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDExploracionInicial']!=''){
				$this->pesoIni 		= $pesoIni;
				$this->bustoIni 	= $bustoIni;
				$this->diafragmaIni = $diafragmaIni;
				$this->brazoIni 	= $brazoIni;
				$this->cinturaIni 	= $cinturaIni;
				$this->abdomenIni 	= $abdomenIni;
				$this->caderaIni 	= $caderaIni;
				$this->musloIni 	= $musloIni;
				
				$stmt = $this->driver->prepare("UPDATE IDHistorialMedico=?,PesoInicial=?,BustoInicial=?,DiafragmaInicial=?,BrazoInicial=?,CinturaInicial=?,
										AbdomenInicial=?,CaderaInicial=?,MusloInicial=? WHERE IDExploracionInicial=?");

				if(!$stmt->bind_param('idddddddd',$idHistorialMedico, $this->pesoIni,$this->bustoIni,$this->diafragmaIni,$this->brazoIni,$this->cinturaIni,$this->abdomenIni,
													$this->caderaIni,$this->musloIni,$idExploracionInicial)){
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
	* Consulta las Exploraciones Iniciales registrados en el sistema
	*@param int $offset
	*@param int $idExploracionInicial
	* @return array or false
	**/
	function lists($offset = -1,$idExploracionInicial = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM ExploracionInicial WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idExploracionInicial>-1){
				$stmt = $this->driver->prepare('SELECT * FROM ExploracionInicial WHERE IDExploracionInicial=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM ExploracionInicial WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idExploracionInicial>-1){
				if(!$stmt->bind_param('i',$idExploracionInicial))
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