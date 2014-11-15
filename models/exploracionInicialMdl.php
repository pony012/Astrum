<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo
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
	 *@return true
	 */
	function create($lastId, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni){
		$this->pesoIni = $this->driver->real_escape_string($pesoIni);
		$this->bustoIni = $this->driver->real_escape_string($bustoIni);
		$this->diafragmaIni = $this->driver->real_escape_string($diafragmaIni);
		$this->brazoIni = $this->driver->real_escape_string($brazoIni);
		$this->cinturaIni = $this->driver->real_escape_string($cinturaIni);
		$this->abdomenIni = $this->driver->real_escape_string($abdomenIni);
		$this->caderaIni = $this->driver->real_escape_string($caderaIni);
		$this->musloIni = $this->driver->real_escape_string($musloIni);

		$stmt = $this->driver->prepare("INSERT INTO ExploracionInicial (IDHistorialMedico,PesoInicial,BustoInicial,DiafragmaInicial,BrazoInicial,CinturaInicial,
										AbdomenInicial,CaderaInicial,MusloInicial) VALUES (?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('idddddddd',$lastId, $this->pesoIni,$this->bustoIni,$this->diafragmaIni,$this->brazoIni,$this->cinturaIni,$this->abdomenIni,
			$this->caderaIni,$this->musloIni))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;
		
		return true;
	}
}
?>