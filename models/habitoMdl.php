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
		$this->fumar 		= $fumar;
		$this->ejercicio 	= $ejercicio;
		$this->usarFaja 	= $usarFaja;
		$this->suenio 		= $suenio;
		$this->tomaSol 		= $tomaSol;
		$this->bloqueador 	= $bloqueador;
		$this->hidroquinona = $hidroquinona;
		
		return true;
	}
}
?>