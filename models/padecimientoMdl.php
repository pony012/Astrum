<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Padecimiento, que son datos del cliente
	*/
class PadecimientoMdl extends BaseMdl{
	private $diabetes;
	private $obesisdad;
	private $depresion;
	private $estres;
	private $sobrepeso;
	private $estrenimiento;
	private $colitis;
	private $retencionLiquidos;
	private $transtornoMes;
	private $cuidadoCorporal;
	private $embarazo;
	/**
	 *@param string $diabetes
	 *@param string $obesisdad
	 *@param string $depresion
	 *@param string $estres
	 *@param string $sobrepeso
	 *@param string $estrenimiento
	 *@param string $colitis
	 *@param string $retencionLiquidos
	 *@param string $transtornoMes
	 *@param string $cuidadoCorporal
	 *@param string $embarazo
	 *Crea un nuevo registro de Padecimiento
	 *@return true
	 */
	function create($lastId, $diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
					$retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo){
		$this->diabetes 		 = $this->driver->real_escape_string($diabetes);
		$this->obesisdad  		 = $this->driver->real_escape_string($obesisdad);
		$this->depresion 		 = $this->driver->real_escape_string($depresion);
		$this->estres  			 = $this->driver->real_escape_string($estres);
		$this->sobrepeso 		 = $this->driver->real_escape_string($sobrepeso);
		$this->estrenimiento	 = $this->driver->real_escape_string($estrenimiento);
		$this->colitis 			 = $this->driver->real_escape_string($colitis);
		$this->retencionLiquidos = $this->driver->real_escape_string($retencionLiquidos);
		$this->transtornoMes 	 = $this->driver->real_escape_string($transtornoMes);
		$this->cuidadoCorporal   = $this->driver->real_escape_string($cuidadoCorporal);
		$this->embarazo   		 = $embarazo;
		
		$stmt = $this->driver->prepare("INSERT INTO Padecimiento (IDHistorialMedico,Diabetes, Obesisdad, Depresion, Estres, Sobrepeso, Estreñimiento,
																Colitis, RetencionLiquidos, TranstornosMenstruales, CuidadoCorporal, Embarazo) 
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('issssssssssi',$lastId, $this->diabetes,$this->obesisdad,$this->depresion,$this->estres,$this->sobrepeso,$this->estrenimiento,
											$this->colitis,$this->retencionLiquidos,$this->transtornoMes,$this->cuidadoCorporal,$this->embarazo)){
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()) {
			die('Error al insertar en la base de datos');
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}
}
?>