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
		
		$stmt = $this->driver->prepare("INSERT INTO 
										Cliente (Nombre, ApellidoPaterno, ApellidoMaterno, Calle, NumExterior, NumInterior, Colonia, CodigoPostal, Email, Telefono, Celular) 
										VALUES(?, 
												?, 
												?, 
												?, 
												?, 
												?, 
												?, 
												?, 
												?, 
												?, 
												?)");
		if(!$stmt->bind_param('sssssssssss',$this->nombre,$this->apellidoPat,$this->apellidoMat,$this->calle,$this->numExterior,$this->numInterior,$this->colonia,$this->codigoPostal,$this->email,$this->telefono,$this->celular)){
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

	/**
	 *@param int $idCliente
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
	 *Modifica un cliente
	 *@return true
	 */
	function update($idCliente, $nombre, $apellidoPat, $apellidoMat, $calle, $numExterior, $numInterior, $colonia, $codigoPostal, 
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
		
		$stmt = $this->driver->prepare("UPDATE Cliente SET
										Nombre = ?, ApellidoPaterno = ?, ApellidoMaterno = ?, Calle = ?, NumExterior = ?, NumInterior = ?, Colonia = ?, CodigoPostal = ?, Email = ?, Telefono = ?, Celular = ?
										WHERE IDCliente = ?");
		if(!$stmt->bind_param('sssssssssssi',$this->nombre,$this->apellidoPat,$this->apellidoMat,$this->calle,$this->numExterior,$this->numInterior,$this->colonia,$this->codigoPostal,$this->email,$this->telefono,$this->celular, $idCliente)){
			die('Error al hacer Update en la base de datos');
		}
		if (!$stmt->execute()) {
			die('Error al hacer Update en la base de datos');
		}

		if($this->driver->error){
			return false;
		}
		return true;
	}
	
	/**
	* Consulta a los Clientes registrados y que esten activos
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Cliente WHERE ?')){
			
			if(!$stmt->bind_param('s',$constraint))
				die('Error Al Consultar');

			if(!$stmt->execute())
				die('Error Al Consultar');

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);

				return $rows;
			}else
				die('No hay Resultados!!!');

		}else
			die('Error Al Consultar');
			
		return false;
	}
	
	/**
	*Da de baja a un determinado cliente
	*@return true or false
	**/
	function delete($idCliente){
	
		if($stmt = $this->driver->prepare('SELECT Activo FROM Cliente WHERE IDCliente=? AND Activo = "S"')){
		
			if(!$stmt->bind_param('i',$idCliente))
				die('Error Al Eliminar');
			
			if(!$stmt->execute())
				die('Error Al Eliminar');
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				//if($stmt = $this->driver->prepare('CALL desactivarCliente(?)')){
				if($stmt = $this->driver->prepare('UPDATE Cliente SET Activo="N" WHERE IDCliente=? AND Activo = "S"')){
			
					if(!$stmt->bind_param('i',$idCliente))
						die('Error Al Eliminar');
					
					if(!$stmt->execute())
						die('Error Al Eliminar');
					else
						return true;
				}
			}
		}

		return false;
	}

	/**
	*Da Activa a un determinado cliente que estuviera eliminado
	*@return true or false
	**/
	function active($idCliente){
		if($stmt = $this->driver->prepare('SELECT Activo FROM Cliente WHERE IDCliente=? AND Activo = "N"')){
		
			if(!$stmt->bind_param('i',$idCliente))
				die('Error Al Activar');
			
			if(!$stmt->execute())
				die('Error Al Activar');
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				//1if($stmt = $this->driver->prepare('CALL activarCliente(?)')){
				1if($stmt = $this->driver->prepare('UPDATE Cliente SET Activo="S" WHERE IDCliente=? AND Activo = "N"')){
			
					if(!$stmt->bind_param('i',$idCliente))
						die('Error Al Activar');
					
					if(!$stmt->execute())
						die('Error Al Activar');
					else
						return true;
				}
			}
		}

		return false;
	}
}
?>