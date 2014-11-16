<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de Ajuste de Salida
	*/
class AjusteSalidaMdl extends BaseMdl{
	private $idAjusteSalidaTipo;
	private $idProveedor;
	private $folio;
	private $observaciones;
	
	private $idAjusteSalida;
	private $idProductoServicio;
	private $cantidad;
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idAjusteSalidaTipo
	 *@param integer $idProveedor
	 *@param integer $folio
	 *@param string $observaciones
	 *@param integer $idAjusteSalida
	 *@param array $idProductos
	 *@param array $cantidades
	 *Crea un nuevo ajuste de salida
	 *@return true
	 */
	function create($idAjusteSalidaTipo, $idProveedor = NULL, $folio, $observaciones,$idProductos,$cantidades){
		$this->idAjusteSalidaTipo 	= $idAjusteSalidaTipo;
		$this->idProveedor			= $idProveedor;
		$this->folio				= $folio;
		$this->observaciones		= $this->driver->real_escape_string($observaciones);

		$this->driver->autocommit(false);
		$this->query->begin_transaction();

		$stmt = $this->driver->prepare("INSERT INTO 
										MovimientoAlmacen (IDMovimientoAlmacenTipo, IDEmpleado)
										VALUES(2,?)");
		if(!$stmt->bind_param('i',$_SESSION['IDEmpleado'])){
			$this->query->rollback();
			return false;
		}
		if (!$stmt->execute()) {
			$this->query->rollback();
			return false;
		}

		$lastId = $this->driver->insert_id;

		if($this->driver->error){
			$this->query->rollback();
			return false;
		}

		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteSalida (IDMovimientoAlmacen, IDAjusteSalidaTipo,IDProveedor, Folio, Observaciones)
										VALUES(?,?,?,?,?)");
		if(!$stmt->bind_param('iiiis',$lastId, $this->idAjusteSalidaTipo,$this->idProveedor,$this->folio,$this->observaciones)){
			$this->query->rollback();
			return false;
		}
		if (!$stmt->execute()) {
			$this->query->rollback();
			return false;
		}

		if($this->driver->error){
			$this->query->rollback();
			return false;
		}

		$lastId = $this->driver->insert_id;

		for($i = 0;$i < count($idProductos);$i++){
			if(!$this->createDetails($lastId,$idProductos[$i],$cantidades[$i])){
				$this->query->rollback();
				return false;
			}
		}

		$this->query->commit();
		$this->driver->autocommit(true);

		return true;
	}
	
	/**
	 *@param integer $idAjusteSalida
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *Crea un nuevo detalle de un ajuste de salida
	 *@return true
	 */
	function createDetails($idAjusteSalida, $idProductoServicio, $cantidad){
		$this->idAjusteSalida = $idAjusteSalida;
		$this->idProductoServicio = $idProductoServicio;
		$this->cantidad	= $cantidad;
		
		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteSalidaDetalle (IDAjusteSalida,IDProductoServicio,Cantidad)
										VALUES(?,?,?)");
		if(!$stmt->bind_param('iid',$this->idAjusteSalida, $this->idProductoServicio, $this->cantidad)){
			return false;
		}
		if (!$stmt->execute()){
			return false;
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}
	
	/**
	* Consulta los Ajustes de Salida registradas y que esten activas
	*@param int $offset
	*@param int $idAjusteSalida
	* @return array or false
	**/
	function lists($offset = -1,$idAjusteSalida = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_AjusteSalida LIMIT ?,?');
		}else{
			if($idAjusteSalida>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_AjusteSalida WHERE IDAjusteSalida=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_AjusteSalida');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idAjusteSalida>-1){
				if(!$stmt->bind_param('i',$idAjusteSalida))
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
	* @param Integer $idAjusteSalida
	* Consulta los detalles de los Ajustes de Salida registrados
	* @return array or false
	**/
	function listsDetails($idAjusteSalida){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_AjusteSalidaDetalle WHERE IDAjusteSalida = ?')){

			if(!$stmt->bind_param('i',$idAjusteSalida))
				return false;

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
