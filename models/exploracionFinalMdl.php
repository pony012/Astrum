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
		$this->pesoFin = $this->driver->real_escape_string($pesoFin);
		$this->bustoFin = $this->driver->real_escape_string($bustoFin);
		$this->diafragmaFin = $this->driver->real_escape_string($diafragmaFin);
		$this->brazoFin = $this->driver->real_escape_string($brazoFin);
		$this->cinturaFin = $this->driver->real_escape_string($cinturaFin);
		$this->abdomenFin = $this->driver->real_escape_string($abdomenFin);
		$this->caderaFin = $this->driver->real_escape_string($caderaFin);
		$this->musloFin = $this->driver->real_escape_string($musloFin);

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
}
?>