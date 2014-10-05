<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo
	*/
class ExploracionMdl extends BaseMdl{
	private $pesoIni;
	private $bustoIni;
	private $diafragmaIni;
	private $brazoIni;
	private $cinturaIni;
	private $abdomenIni;
	private $caderaIni;
	private $musloIni;
	
	private $pesoFin;
	private $bustoFin;
	private $diafragmaFin;
	private $brazoFin;
	private $cinturaFin;
	private $abdomenFin;
	private $caderaFin;
	private $musloFin;
	
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
	function createInit($lastId, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni){
		$this->pesoIni = $this->driver->real_escape_string($pesoIni);
		$this->bustoIni = $this->driver->real_escape_string($bustoIni);
		$this->diafragmaIni = $this->driver->real_escape_string($diafragmaIni);
		$this->brazoIni = $this->driver->real_escape_string($brazoIni);
		$this->cinturaIni = $this->driver->real_escape_string($cinturaIni);
		$this->abdomenIni = $this->driver->real_escape_string($abdomenIni);
		$this->caderaIni = $this->driver->real_escape_string($caderaIni);
		$this->musloIni = $this->driver->real_escape_string($musloIni);

		$stmt = $this->driver->prepare("INSERT INTO Exploracion (IDHistorialMedico,PesoInicial,BustoInicial,DiafragmaInicial,BrazoInicial,CinturaInicial,
										AbdomenInicial,CaderaInicial,MusloInicial) VALUES (?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('idddddddd',$lastId, $this->pesoIni,$this->bustoIni,$this->diafragmaIni,$this->brazoIni,$this->cinturaIni,$this->abdomenIni,
			$this->caderaIni,$this->musloIni))
			die('Error al insertar en la base de datos');
		if (!$stmt->execute()) 
			die('Error al insertar en la base de datos');
		if($this->driver->error)
			return false;
		
		return true;
	}
	
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
	 */
	/*dividir la tabla exploracion para inicial y final*/
	function createFin($pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin){
		$this->pesoFin = $pesoFin;
		$this->bustoFin = $bustoFin;
		$this->diafragmaFin = $diafragmaFin;
		$this->brazoFin = $brazoFin;
		$this->cinturaFin = $cinturaFin;
		$this->abdomenFin = $abdomenFin;
		$this->caderaFin = $caderaFin;
		$this->musloFin = $musloFin;
		
		return true;
	}
}
?>