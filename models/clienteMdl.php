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
		$this->nombre		= $this->driver->real_escape_string($nombre);
		$this->apellidoPat	= $this->driver->real_escape_string($apellidoPat);
		$this->apellidoMat	= $this->driver->real_escape_string($apellidoMat);
		$this->calle		= $this->driver->real_escape_string($calle);
		$this->numExterior	= $this->driver->real_escape_string($numExterior);
		$this->numInterior	= $this->driver->real_escape_string($numInterior);
		$this->colonia		= $this->driver->real_escape_string($colonia);
		$this->codigoPostal	= $this->driver->real_escape_string($codigoPostal);
		$this->email		= $this->driver->real_escape_string($email);
		$this->telefono		= $this->driver->real_escape_string($telefono);
		$this->celular		= $this->driver->real_escape_string($celular);
		
		$this->driver->query("	INSERT INTO 
								Cliente (Nombre, ApellidoPaterno, ApellidoMaterno, Calle, NumExterior, NumInterior, Colonia, CodigoPostal, Email, Telefono, Celular) 
								VALUES('$this->nombre', 
										'$this->apellidoPat', 
										'$this->apellidoMat', 
										'$this->calle', 
										'$this->numExterior', 
										'$this->numInterior', 
										'$this->colonia', 
										'$this->codigoPostal', 
										'$this->email', 
										'$this->telefono', 
										'$this->celular')");
		if ($this->driver->connect_error) {
			die('Error al insertar en la base de datos');
		}
		return true;
	}
}
?>