<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Cliente
	*/
class ClienteMdl extends BaseMdl{
	private $nombre;
	private $apellidoPat;
	private $apellidoMat;
	private $rfc;
	private $calle;
	private $numExterior;
	private $numInterior;
	private $colonia;
	private $codigoPostal;
	private $email;
	private $telefono;
	private $celular;
	
	/**
	 *@param string $nombre
	 *@param string $apellidoPat
	 *@param string $apellidoMat
	 *@param string $calle
	 *@param string $numExterior
	 *@param string $numInterior
	 *@param string $colonia
	 *@param string $codigoPostal
	 *@param string $email
	 *@param string $telefono
	 *@param string $celular
	 *Crea un nuevo cliente
	 *@return true
	 */
	function create($nombre, $apellidoPat, $apellidoMat, $calle, $numExterior, $numInterior, $colonia, $codigoPostal, 
		$email = NULL, $telefono = NULL, $celular = NULL){
		$this->nombre	= $nombre;
		$this->apellidoPat	= $apellidoPat;
		$this->apellidoMat	= $apellidoMat;
		$this->calle	= $calle;
		$this->numExterior	= $numExterior;
		$this->numInterior	= $numInterior;
		$this->colonia	= $colonia;
		$this->codigoPostal	= $codigoPostal;
		$this->email	= $email;
		$this->telefono	= $telefono;
		$this->celular	= $celular;
		
		return true;
	}
}
?>