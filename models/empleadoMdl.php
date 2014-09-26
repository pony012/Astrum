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
	private $contrasena;
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
	 *@param string $contrasena
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
	function create($nombre, $apellidoPat, $apellidoMat, $usuario, $contrasena, $idCargo, $calle, $numExterior, $numInterior, $colonia, $codigoPostal, 
		$foto = NULL, $email = NULL, $telefono = NULL, $celular = NULL){
		$this->nombre	= $this->driver->real_escape_string($nombre);
		$this->apellidoPat	= $this->driver->real_escape_string($apellidoPat);
		$this->apellidoMat	= $this->driver->real_escape_string($apellidoMat);
		$this->usuario	= $this->driver->real_escape_string($usuario);
		$this->contrasena	= $this->driver->real_escape_string($contrasena);
		$this->idCargo	= $this->driver->real_escape_string($idCargo);
		$this->calle	= $this->driver->real_escape_string($calle);
		$this->numExterior	= $this->driver->real_escape_string($numExterior);
		$this->numInterior	= $this->driver->real_escape_string($numInterior);
		$this->colonia	= $this->driver->real_escape_string($colonia);
		$this->codigoPostal	= $this->driver->real_escape_string($codigoPostal);
		$this->foto	= $this->driver->real_escape_string($foto);
		$this->email	= $this->driver->real_escape_string($email);
		$this->telefono	= $this->driver->real_escape_string($telefono);
		$this->celular	= $this->driver->real_escape_string($celular);
		$this->driver->query('INSERT INTO Empleado (Nombre, ApellidoPaterno, ApellidoMaterno, Usuario, Contrasena, IDCargo, Calle, NumExterior, NumInterior, Colonia, CodigoPostal, Foto, Email, Telefono, Celular)
				VALUES("'.$this->nombre.'",
						"'.$this->apellidoPat.'",
						"'.$this->apellidoMat.'",
						"'.$this->usuario.'",
						"'.$this->contrasena.'",
						'.$this->idCargo.',
						"'.$this->calle.'",
						"'.$this->numExterior.'",
						"'.$this->numInterior.'",
						"'.$this->colonia.'",
						"'.$this->codigoPostal.'",
						"'.$this->foto.'",
						"'.$this->email.'",
						"'.$this->telefono.'",
						"'.$this->celular.'")');
		echo $this->driver->error;
		if($this->driver->error)
			return false;
		return true;
	}
}
?>
