<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Proveedor
	*/
class ProveedorMdl extends BaseMdl{
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
	 *@param string $rfc
	 *@param string $calle
	 *@param string $numExterior
	 *@param string $numInterior
	 *@param string $colonia
	 *@param string $codigoPostal
	 *@param string $email
	 *@param string $telefono
	 *@param string $celular
	 *Crea un nuevo proveedor
	 *@return true
	 */
	function create($nombre, $apellidoPat, $apellidoMat, $rfc = NULL, $calle, $numExterior, $numInterior, $colonia, $codigoPostal, 
		$email = NULL, $telefono = NULL, $celular = NULL){
		$this->nombre		= $this->driver->real_escape_string($nombre);
		$this->apellidoPat	= $this->driver->real_escape_string($apellidoPat);
		$this->apellidoMat	= $this->driver->real_escape_string($apellidoMat);
		$this->rfc			= $this->driver->real_escape_string($rfc);
		$this->calle		= $this->driver->real_escape_string($calle);
		$this->numExterior	= $this->driver->real_escape_string($numExterior);
		$this->numInterior	= $this->driver->real_escape_string($numInterior);
		$this->colonia		= $this->driver->real_escape_string($colonia);
		$this->codigoPostal	= $this->driver->real_escape_string($codigoPostal);
		$this->email		= $this->driver->real_escape_string($email);
		$this->telefono		= $this->driver->real_escape_string($telefono);
		$this->celular		= $this->driver->real_escape_string($celular);
		
		$stmt = $this->driver->prepare(("INSERT INTO Proveedor (Nombre, ApellidoPaterno, ApellidoMaterno, RFC, Calle, NumExterior, NumInterior, Colonia, CodigoPostal, Email, Telefono, Celular) 
										 VALUES(?,?,?,?,?,?,?,?,?,?,?,?)"));
		if(!$stmt->bind_param('ssssssssssss',$this->nombre,$this->apellidoPat,$this->apellidoMat,$this->rfc,$this->calle,$this->numExterior,$this->numInterior,$this->colonia,$this->codigoPostal,$this->email,$this->telefono, $this->celular)){
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
	 *@param int $idProveedor
	 *@param string $nombre
	 *@param string $apellidoPat
	 *@param string $apellidoMat
	 *@param string $rfc
	 *@param string $calle
	 *@param string $numExterior
	 *@param string $numInterior
	 *@param string $colonia
	 *@param string $codigoPostal
	 *@param string $email
	 *@param string $telefono
	 *@param string $celular
	 *Modifica un proveedor
	 *@return true
	 */
	function update($idProveedor, $nombre, $apellidoPat, $apellidoMat, $rfc = NULL, $calle, $numExterior, $numInterior, $colonia, $codigoPostal, 
		$email = NULL, $telefono = NULL, $celular = NULL){
		$this->nombre		= $this->driver->real_escape_string($nombre);
		$this->apellidoPat	= $this->driver->real_escape_string($apellidoPat);
		$this->apellidoMat	= $this->driver->real_escape_string($apellidoMat);
		$this->rfc			= $this->driver->real_escape_string($rfc);
		$this->calle		= $this->driver->real_escape_string($calle);
		$this->numExterior	= $this->driver->real_escape_string($numExterior);
		$this->numInterior	= $this->driver->real_escape_string($numInterior);
		$this->colonia		= $this->driver->real_escape_string($colonia);
		$this->codigoPostal	= $this->driver->real_escape_string($codigoPostal);
		$this->email		= $this->driver->real_escape_string($email);
		$this->telefono		= $this->driver->real_escape_string($telefono);
		$this->celular		= $this->driver->real_escape_string($celular);
		
		$stmt = $this->driver->prepare(("UPDATE Proveedor SET 
										 Nombre = ?, ApellidoPaterno = ?, ApellidoMaterno = ?, RFC = ?, Calle = ?, NumExterior = ?, NumInterior = ?, Colonia = ?, CodigoPostal = ?, Email = ?, Telefono = ?, Celular = ?
										 WHERE IDProveedor = ?"));
		if(!$stmt->bind_param('ssssssssssssi',$this->nombre,$this->apellidoPat,$this->apellidoMat,$this->rfc,$this->calle,$this->numExterior,$this->numInterior,$this->colonia,$this->codigoPostal,$this->email,$this->telefono, $this->celular, $idProveedor)){
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
	* Consulta a los proveedores registrados y que esten activos
	*@param int $offset
	*@param int $idProveedor
	* @return array or false
	**/
	function lists($offset = -1,$idProveedor = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Proveedor LIMIT ?,?');
		}else{
			if($idProveedor>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Proveedor WHERE IDProveedor=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Proveedor');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idProveedor>-1){
				if(!$stmt->bind_param('i',$idProveedor))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}

	/**
	* Consulta a los proveedores registrados y que estan inactivos
	*@param int $offset
	*@param int $idProveedor
	* @return array or false
	**/
	function listsDeleters($offset = -1,$idProveedor = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Proveedor_Deleter LIMIT ?,?');
		}else{
			if($idProveedor>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Proveedor_Deleter WHERE IDProveedor=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Proveedor_Deleter');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idProveedor>-1){
				if(!$stmt->bind_param('i',$idProveedor))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}

	/**
	* Consulta al Proveedor con el Id dado
	* @return Object or false
	**/
	function get($idProveedor){
		if($stmt = $this->driver->prepare('SELECT * FROM V_Proveedor WHERE IDProveedor = ?')){
			
			if(!$stmt->bind_param('i',$idProveedor))
				return false;

			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){
				return $mySqliResult->fetch_assoc();
			}else
				return false;

		}else
			return false;
			
		return false;
	}
	
	/**
	*Da de baja a un determinado proveedor
	*@return true or false
	**/
	function delete($idProveedor){
	
		if($stmt = $this->driver->prepare('SELECT Activo FROM Proveedor WHERE IDProveedor=? AND Activo = "S"')){
		
			if(!$stmt->bind_param('i',$idProveedor))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){
			
				//if($stmt = $this->driver->prepare('CALL desactivarProveedor(?)')){
				if($stmt = $this->driver->prepare('UPDATE Proveedor SET Activo="N" WHERE IDProveedor=? AND Activo = "S"')){
			
					if(!$stmt->bind_param('i',$idProveedor))
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
	*Da Activa a un determinado proveedor que estuviera eliminado
	*@return true or false
	**/
	function active($idProveedor){
		if($stmt = $this->driver->prepare('SELECT Activo FROM Proveedor WHERE IDProveedor=? AND Activo = "N"')){
		
			if(!$stmt->bind_param('i',$idProveedor))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				//if($stmt = $this->driver->prepare('CALL activarProveedor(?)')){
				if($stmt = $this->driver->prepare('UPDATE Proveedor SET Activo="S" WHERE IDProveedor=? AND Activo = "N"')){
			
					if(!$stmt->bind_param('i',$idProveedor))
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