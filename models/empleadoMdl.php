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
	 *@return true or false
	 */
	function create($nombre, $apellidoPat, $apellidoMat, $usuario, $contrasena, $idCargo, $calle, $numExterior, $numInterior, $colonia, $codigoPostal, 
		$email, $foto = NULL, $telefono = NULL, $celular = NULL){
		$this->nombre		= $this->driver->real_escape_string($nombre);
		$this->apellidoPat	= $this->driver->real_escape_string($apellidoPat);
		$this->apellidoMat	= $this->driver->real_escape_string($apellidoMat);
		$this->usuario		= $this->driver->real_escape_string($usuario);
		$this->contrasena	= $this->driver->real_escape_string($contrasena);
		$this->idCargo		= $idCargo;
		$this->calle		= $this->driver->real_escape_string($calle);
		$this->numExterior	= $this->driver->real_escape_string($numExterior);
		$this->numInterior	= $this->driver->real_escape_string($numInterior);
		$this->colonia		= $this->driver->real_escape_string($colonia);
		$this->codigoPostal	= $this->driver->real_escape_string($codigoPostal);
		$this->foto			= $this->driver->real_escape_string($foto);
		$this->email		= $this->driver->real_escape_string($email);
		$this->telefono		= $this->driver->real_escape_string($telefono);
		$this->celular		= $this->driver->real_escape_string($celular);
		
		$stmt = $this->driver->prepare('INSERT INTO Empleado (Nombre, ApellidoPaterno, ApellidoMaterno, Usuario, Contrasena, IDCargo, Calle, NumExterior, NumInterior, Colonia, CodigoPostal, Foto, Email, Telefono, Celular)
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
		if(!$stmt->bind_param('sssssisssssssss',$this->nombre, $this->apellidoPat, $this->apellidoMat, $this->usuario, 
												$this->contrasena, $this->idCargo, $this->calle, $this->numExterior,
												$this->numInterior, $this->colonia, $this->codigoPostal, $this->foto,
												$this->email, $this->telefono, $this->celular)){
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
	 *@param int $idEmpleado
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
	 *Modifica un empleado
	 *@return true or false
	 */
	function update($idEmpleado, $nombre, $apellidoPat, $apellidoMat, $usuario, $contrasena, $idCargo, $calle, $numExterior, $numInterior, $colonia, $codigoPostal, 
		$email, $foto = NULL, $telefono = NULL, $celular = NULL){
		$this->nombre		= $this->driver->real_escape_string($nombre);
		$this->apellidoPat	= $this->driver->real_escape_string($apellidoPat);
		$this->apellidoMat	= $this->driver->real_escape_string($apellidoMat);
		$this->usuario		= $this->driver->real_escape_string($usuario);
		$this->contrasena	= $this->driver->real_escape_string($contrasena);
		$this->idCargo		= $idCargo;
		$this->calle		= $this->driver->real_escape_string($calle);
		$this->numExterior	= $this->driver->real_escape_string($numExterior);
		$this->numInterior	= $this->driver->real_escape_string($numInterior);
		$this->colonia		= $this->driver->real_escape_string($colonia);
		$this->codigoPostal	= $this->driver->real_escape_string($codigoPostal);
		$this->foto			= $this->driver->real_escape_string($foto);
		$this->email		= $this->driver->real_escape_string($email);
		$this->telefono		= $this->driver->real_escape_string($telefono);
		$this->celular		= $this->driver->real_escape_string($celular);
		
		$stmt = $this->driver->prepare('UPDATE Empleado SET 
										Nombre = ?, ApellidoPaterno = ?, ApellidoMaterno = ?, Usuario = ?, Contrasena = ?, IDCargo = ?, Calle = ?,
										NumExterior = ?, NumInterior = ?, Colonia = ?, CodigoPostal = ?, Foto = ?, Email = ?, Telefono = ?, Celular = ?
										WHERE IDEmpleado = ?');
		if(!$stmt->bind_param('sssssisssssssssi',$this->nombre, $this->apellidoPat, $this->apellidoMat, $this->usuario, 
												$this->contrasena, $this->idCargo, $this->calle, $this->numExterior,
												$this->numInterior, $this->colonia, $this->codigoPostal, $this->foto,
												$this->email, $this->telefono, $this->celular, $idEmpleado)){
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
	 *@param int $idEmpleado
	 *@param string $contrasena
	 *Modifica la contraseña de un empleado
	 *@return true or false
	 */
	function updatePassword($idEmpleado, $contrasena){
		$this->contrasena	= $this->driver->real_escape_string($contrasena);
		
		$stmt = $this->driver->prepare('UPDATE Empleado SET Contrasena = ? WHERE IDEmpleado = ?');
		if(!$stmt->bind_param('si',	$this->contrasena, $idEmpleado)){
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
	* Consulta a los empleados registrados y que esten activos
	*@param int $offset
	*@param int $idEmpleado
	* @return array or false
	**/
	function lists($offset = -1,$idEmpleado = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Empleado WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idEmpleado>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Empleado WHERE IDEmpleado=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Empleado WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idEmpleado>-1){
				if(!$stmt->bind_param('i',$idEmpleado))
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
	* Consulta a los empleados registrados y que estan inactivos
	*@param int $offset
	*@param int $idEmpleado
	* @return array or false
	**/
	function listsDeleters($offset = -1,$idEmpleado = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Empleado_Deleter LIMIT ?,?');
		}else{
			if($idEmpleado>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Empleado_Deleter WHERE IDEmpleado=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Empleado_Deleter');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idEmpleado>-1){
				if(!$stmt->bind_param('i',$idEmpleado))
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
	*Da de baja a un determinado empleado
	*@return true or false
	**/
	function delete($idEmpleado){
	
		if($stmt = $this->driver->prepare('SELECT Activo FROM Empleado WHERE IDEmpleado=? AND Activo = "S"')){
		
			if(!$stmt->bind_param('i',$idEmpleado))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){			
			
				//if($stmt = $this->driver->prepare('CALL desactivarEmpleado(?)')){
				if($stmt = $this->driver->prepare('UPDATE Empleado SET Activo="N" WHERE IDEmpleado=? AND Activo = "S"')){
					if(!$stmt->bind_param('i',$idEmpleado))
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
	*Da Activa a un determinado empleado que estuviera eliminado
	*@return true or false
	**/
	function active($idEmpleado){
		if($stmt = $this->driver->prepare('SELECT Activo FROM Empleado WHERE IDEmpleado=? AND Activo = "N"')){
		
			if(!$stmt->bind_param('i',$idEmpleado))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['Activo']!=''){
			
				//if($stmt = $this->driver->prepare('CALL activarEmpleado(?)')){
				if($stmt = $this->driver->prepare('UPDATE Empleado SET Activo="S" WHERE IDEmpleado=? AND Activo = "N"')){
					if(!$stmt->bind_param('i',$idEmpleado))
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
