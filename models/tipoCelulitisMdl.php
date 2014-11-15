<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Tipos de Celulitis, que son datos del cliente
	*/
class TipoCelulitisMdl extends BaseMdl{
	private $fibrosa;
	private $edematosa;
	private $flacida;
	private $dura;
	private $mixta;
	private $dolorosa;
	/**
	 *@param string $fibrosa
	 *@param string $edematosa
	 *@param string $flacida
	 *@param string $dura
	 *@param string $mixta
	 *@param string $dolorosa
	 *Crea un nuevo
	 *@return true
	 */
	function create($lastId, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
		$this->fibrosa 	 = $this->driver->real_escape_string($fibrosa);
		$this->edematosa = $this->driver->real_escape_string($edematosa);
		$this->flacida   = $this->driver->real_escape_string($flacida);
		$this->dura		 = $this->driver->real_escape_string($dura);
		$this->mixta 	 = $this->driver->real_escape_string($mixta);
		$this->dolorosa  = $this->driver->real_escape_string($dolorosa);
		
		$stmt = $this->driver->prepare("INSERT INTO TipoCelulitis (IDHistorialMedico,Fibrosa, Edematosa, Flacida, Dura, Mixta, Dolorosa) 
										VALUES(?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('issssss',	$lastId, $this->fibrosa, $this->edematosa, $this->flacida, $this->dura, $this->mixta, $this->dolorosa)){
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
?>