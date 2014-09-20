<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Empleado
	*/
class EmpleadoMdl extends BaseMdl{
	private $nombre;
	private $apellidoPat;
	private $apellidoMat;
	private $usuario;
	private $contraseña;
	private $idCargo;
	private $calle;
	private $numExterior;
	private $numInterior;
	private $colonia;
	private $codigoPostal;
	private $foto;
	private $email;
	private $telefono;
	private $celular;
	
	/**
	 *@param string $nombre
	 *@param string $apellidoPat
	 *@param string $apellidoMat
	 *@param string $usuario
	 *@param string $contraseña
	 *@param integer $idCargo
	 *@param string $calle
	 *@param string $numExterior
	 *@param string $numInterior
	 *@param string $colonia
	 *@param string $codigoPostal
	 *@param string $foto
	 *@param string $email
	 *@param string $telefono
	 *@param string $celular
	 *Crea un nuevo empleado
	 *@return true
	 */
	function create($nombre, $apellidoPat, $apellidoMat, $usuario, $contraseña, $idCargo, $calle, $numExterior, $numInterior, $colonia, $codigoPostal, 
		$foto = NULL, $email = NULL, $telefono = NULL, $celular = NULL){
		$this->nombre	= $nombre;
		$this->apellidoPat	= $apellidoPat;
		$this->apellidoMat	= $apellidoMat;
		$this->usuario	= $usuario;
		$this->contraseña	= $contraseña;
		$this->idCargo	= $idCargo;
		$this->calle	= $calle;
		$this->numExterior	= $numExterior;
		$this->numInterior	= $numInterior;
		$this->colonia	= $colonia;
		$this->codigoPostal	= $codigoPostal;
		$this->foto	= $foto;
		$this->email	= $email;
		$this->telefono	= $telefono;
		$this->celular	= $celular;
		
		return true;
	}
}
?>