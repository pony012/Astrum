<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de los Tipos de Ajuste de Salida
	*/
class AjusteSalidaTipoMdl extends BaseMdl{
	private $tipo;
	private $exclusivoSistema;
	private $descripcion;
	
	/**
	 *@param string $tipo
	 *@param string $exclusivoSistema
	 *@param string $descripcion
	 *Crea un nuevo tipo de movimiento de almacen
	 *@return true
	 */
	function create($tipo, $exclusivoSistema, $descripcion){
		$this->tipo 			= $this->driver->real_escape_string($tipo);
		$this->exclusivoSistema	= $this->driver->real_escape_string($exclusivoSistema);
		$this->descripcion		= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteSalidaTipo (Tipo,ExclusivoSistema,Descripcion)
										VALUES(?,?,?)");
		if(!$stmt->bind_param('sss',$this->tipo,$this->exclusivoSistema,$this->descripcion)){
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
	*Actualiza la información de lo tipos de Ajustes de Salida
	*@param integer $idAjusteSalidaTipo
	*@param string $tipo
	*@param string $exclusivoSistema
	*@param string $descripcion
	*@return true or false
	**/
	function update($idAjusteSalidaTipo,$tipo, $exclusivoSistema,$descripcion){
		if($stmt = $this->driver->prepare('SELECT IDAjusteSalidaTipo FROM AjusteSalidaTipo WHERE IDAjusteSalidaTipo=?')){
		
			if(!$stmt->bind_param('i',$idAjusteSalidaTipo))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDAjusteSalidaTipo']!=''){
				$this->tipo		= $this->driver->real_escape_string($tipo);
				$this->exclusivoSistema		= $this->driver->real_escape_string($exclusivoSistema);
				$this->descripcion	= $this->driver->real_escape_string($descripcion);
				
				$stmt = $this->driver->prepare("UPDATE AjusteSalidaTipo SET Tipo=?,ExclusivoSistema=?,Descripcion=? WHERE IDAjusteSalidaTipo=?");
				if(!$stmt->bind_param('sssi',$this->tipo,$this->exclusivoSistema,$this->descripcion,$idAjusteSalidaTipo)){
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
		}
		else		
			return false;
	}

	/**
	* Consulta a los Ajustes de Salida registrados
	*@param int $offset
	*@param int $idAjusteSalidaTipo
	*@param string $constrain
	* @return array or false
	**/
	function lists($offset = -1,$idAjusteSalidaTipo = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM AjusteSalidaTipo WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idAjusteSalidaTipo>-1){
				$stmt = $this->driver->prepare('SELECT * FROM AjusteSalidaTipo WHERE IDAjusteSalidaTipo=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM AjusteSalidaTipo WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idAjusteSalidaTipo>-1){
				if(!$stmt->bind_param('i',$idAjusteSalidaTipo))
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
}
?>
