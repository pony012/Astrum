<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Alimentación, que son de datos del cliente
	*/
class AlimentacionMdl extends BaseMdl{
	private $buena;
	private $regularAl;
	private $mala;
	/**
	 *@param string $buena
	 *@param string $regularAl
	 *@param string $mala
	 *Crea un nuevo registro de alimentacion
	 *@return true
	 */
	function create($lastId, $buena,$regularAl,$mala){
		$this->buena = $this->driver->real_escape_string($buena);
		$this->regularAl = $this->driver->real_escape_string($regularAl);
		$this->mala = $this->driver->real_escape_string($mala);
		
		$stmt = $this->driver->prepare("INSERT INTO Alimentacion (IDHistorialMedico,Buena,Regular,Mala) VALUES (?,?,?,?)");
		if(!$stmt->bind_param('isss',$lastId, $this->buena,$this->regularAl,$this->mala))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;

		return true;
	}
}
?>