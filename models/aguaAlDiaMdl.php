<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo AguaAlDia que son parte de los datos del cliente
	*/
class AguaAlDiaMdl extends BaseMdl{
	private $poca;
	private $regularAg;
	private $mucha;
	/**
	 *@param string $poca
	 *@param string $regularAg
	 *@param string $mucha
	 *Crea un nuevo registro del consumo de agua diaria
	 *@return true
	 */
	function create($lastId, $poca,$regularAg,$mucha){
		$this->poca = $this->driver->real_escape_string($poca);
		$this->regularAg = $this->driver->real_escape_string($regularAg);
		$this->mucha = $this->driver->real_escape_string($mucha);
		
		$stmt = $this->driver->prepare("INSERT INTO AguaAlDia (IDHistorialMedico,Poca,Regular,Mucha) VALUES (?,?,?,?)");
		if(!$stmt->bind_param('isss',$lastId, $this->poca,$this->regularAg,$this->mucha))
			die('Error al insertar en la base de datos');
		if (!$stmt->execute()) 
			die('Error al insertar en la base de datos');
		if($this->driver->error)
			return false;

		return true;
	}
}
?>