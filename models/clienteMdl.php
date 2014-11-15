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
	
	/**
	* Consulta a los clientes registrados y que esten activos
	*@param int $offset
	*@param int $idCliente
	* @return array or false
	**/
	function lists($offset = -1,$idCliente = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Cliente WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idCliente>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Cliente WHERE IDCliente=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Cliente WHERE '.$constrain);
			}
		}

		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idCliente>-1){
				if(!$stmt->bind_param('i',$idCliente))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}

	/**
	* Consulta a los clientes registrados y que esten eliminados
	*@param int $offset
	*@param int $idEmpleado
	* @return array or false
	**/
	function listsDeleters($offset = -1,$idCliente = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Cliente_Deleter LIMIT ?,?');
		}else{
			if($idCliente>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Cliente_Deleter WHERE IDCliente=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Cliente_Deleter');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idCliente>-1){
				if(!$stmt->bind_param('i',$idCliente))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}

	
	/**
	*Da de baja a un determinado cliente
	*@return true or false
	**/
	function delete($idCliente){
	
		if($stmt = $this->driver->prepare('SELECT Activo FROM Cliente WHERE IDCliente=? AND Activo = "S"')){
		
			if(!$stmt->bind_param('i',$idCliente))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				//if($stmt = $this->driver->prepare('CALL desactivarCliente(?)')){
				if($stmt = $this->driver->prepare('UPDATE Cliente SET Activo="N" WHERE IDCliente=? AND Activo = "S"')){
			
					if(!$stmt->bind_param('i',$idCliente))
						return false;
					
					if(!$stmt->execute())
						return false;
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
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				//1if($stmt = $this->driver->prepare('CALL activarCliente(?)')){
				if($stmt = $this->driver->prepare('UPDATE Cliente SET Activo="S" WHERE IDCliente=? AND Activo = "N"')){
			
					if(!$stmt->bind_param('i',$idCliente))
						return false;
					
					if(!$stmt->execute())
						return false;
					else
						return true;
				}
			}
		}

		return false;
	}
}
?>