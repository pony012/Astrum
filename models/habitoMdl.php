<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Habito, que son datos del cliente
	*/
class HabitoMdl extends BaseMdl{
	private $fumar;
	private $ejercicio;
	private $usarFaja;
	private $suenio;
	private $tomaSol;
	private $bloqueador;
	private $hidroquinona;
	
	/**
	 *@param string $fumar
	 *@param string $ejercicio
	 *@param string $usarFaja
	 *@param string $suenio
	 *@param string $tomaSol
	 *@param string $bloqueador
	 *@param string $hidroquinona
	 *Crea un nuevo registro de habito
	 *@return true
	 */
	function create($fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona){
		$this->fumar 		= $this->driver->real_escape_string($fumar);
		$this->ejercicio 	= $this->driver->real_escape_string($ejercicio);
		$this->usarFaja 	= $this->driver->real_escape_string($usarFaja);
		$this->suenio 		= $this->driver->real_escape_string($suenio);
		$this->tomaSol 		= $this->driver->real_escape_string($tomaSol);
		$this->bloqueador 	= $this->driver->real_escape_string($bloqueador);
		$this->hidroquinona = $this->driver->real_escape_string($hidroquinona);
		
		$stmt = $this->driver->prepare("INSERT INTO Habito (Fumar, Ejercicio, UsarFaja, Suenio, TomaSol, Bloqueador, Hidroquinona) 
										VALUES (?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('sssssss',$this->fumar, $this->ejercicio, $this->usarFaja, $this->suenio, $this->tomaSol, $this->bloqueador, $this->hidroquinona)){
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