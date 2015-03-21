<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de Ajuste de Entrada
	*/
class AjusteEntradaMdl extends BaseMdl{
	private $idAjusteEntradaTipo;
	private $idCliente;
	private $folio;
	private $total;
	private $observaciones;
	
	private $idAjusteEntrada;
	private $idProductoServicio;
	private $cantidad;
	private $precioUnitario;
	private $idRemision;
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idAjusteEntradaTipo
	 *@param integer $idCliente
	 *@param integer $folio
	 *@param string $observaciones
	 *@param integer $idAjusteEntrada
	 *@param array $idProductos
	 *@param array $cantidades
	 *@param integer $idRemision
	 *Crea un nuevo ajuste de entrada
	 *@return true
	 */
	function create( $idAjusteEntradaTipo, $idCliente = NULL, $folio, $observaciones,$idProductos,$cantidades,$precioUnitario,$idRemision = NULL){
		$this->idRemision 			= $idRemision;
		$this->idAjusteEntradaTipo 	= $idAjusteEntradaTipo;
		$this->idCliente			= $idCliente;
		$this->folio				= $folio;
		$this->observaciones		= $this->driver->real_escape_string($observaciones);
		$total = 0;
		$this->driver->autocommit(false);
		$this->driver->begin_transaction();

		$stmt = $this->driver->prepare("INSERT INTO 
										MovimientoAlmacen (IDMovimientoAlmacenTipo, IDEmpleado)
										VALUES(1,?)");
		if(!$stmt->bind_param('i',$_SESSION['IDEmpleado'])){
			$this->driver->rollback();
			return false;
		}
		if (!$stmt->execute()) {
			$this->driver->rollback();
			return false;
		}

		$lastId = $this->driver->insert_id;

		if($this->driver->error){
			$this->driver->rollback();
			return false;
		}

		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteEntrada (IDMovimientoAlmacen, IDAjusteEntradaTipo, IDCliente, Folio, Observaciones)
										VALUES(?,?,?,?,?)");
		if(!$stmt->bind_param('iiiis',$lastId,$this->idAjusteEntradaTipo,$this->idCliente,$this->folio,$this->observaciones)){
			$this->driver->rollback();
			return false;
		}
		if (!$stmt->execute()) {
			$this->driver->rollback();
			return false;
		}

		if($this->driver->error){
			$this->driver->rollback();
			return false;
		}
		$lastId = $this->driver->insert_id;
		$idAjusteEntrada = $lastId;
		if($idRemision !== NULL && $idRemision != ''){
			$stmt = $this->driver->prepare("INSERT INTO 
											AjusteEntradaRemision (IDAjusteEntrada, IDRemision)
											VALUES(?,?)");
			if(!$stmt->bind_param('ii',$lastId,$this->idRemision)){
				$this->driver->rollback();
				return false;
			}
			if (!$stmt->execute()) {
				$this->driver->rollback();
				return false;
			}

			if($this->driver->error){
				$this->driver->rollback();
				return false;
			}
		}
		for($i = 0;$i < count($idProductos);$i++){
			if(!$this->createDetails($lastId,$idProductos[$i],$cantidades[$i],$precioUnitario[$i])){
				$this->driver->rollback();
				return false;
			}
			$total += $cantidades[$i] * $precioUnitario[$i];
		}

		$this->total = $total;

		$stmt = $this->driver->prepare("UPDATE 
										AjusteEntrada SET Total = ?
										WHERE IDAjusteEntrada = ?");
		if(!$stmt->bind_param('di',$this->total, $idAjusteEntrada)){
			$this->driver->rollback();
		}
		if (!$stmt->execute()) {
			$this->driver->rollback();
			return false;
		}

		if($this->driver->error){
			$this->driver->rollback();
			return false;
		}

		$this->driver->commit();
		$this->driver->autocommit(true);

		return $lastId;
	}
	
	/**
	 *@param integer $idAjusteEntrada
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *Crea un nuevo detalle de un ajuste de entrada
	 *@return true
	 */
	function createDetails($idAjusteEntrada, $idProductoServicio, $cantidad, $precioUnitario){
		$this->idAjusteEntrada 		= $idAjusteEntrada;
		$this->idProductoServicio 	= $idProductoServicio;
		$this->cantidad				= $cantidad;
		$this->$precioUnitario 		= $precioUnitario;
		
		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteEntradaDetalle (IDAjusteEntrada,IDProductoServicio,Cantidad,PrecioUnitario)
										VALUES(?,?,?,?)");
		if(!$stmt->bind_param('iidd',$this->idAjusteEntrada, $this->idProductoServicio, $this->cantidad,$this->$precioUnitario)){
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
	* Consulta los Ajustes de Entrada registradas y que esten activas
	*@param int $offset
	*@param int $idAjusteEntrada
	* @return array or false
	**/
	function lists($offset = -1,$idAjusteEntrada = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_AjusteEntrada WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idAjusteEntrada>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_AjusteEntrada WHERE IDAjusteEntrada=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_AjusteEntrada WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idAjusteEntrada>-1){
				if(!$stmt->bind_param('i',$idAjusteEntrada))
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
	* @param Integer $idAjusteEntrada
	* Consulta los detalles de los ajustes de entrada registrados
	* @return array or false
	**/
	function listsDetails($idAjusteEntrada){
		$rows = array();
		$result = array();

		$main = $this->lists(-1,$idAjusteEntrada);
		if($main){
			if(is_numeric($main)){
				return $main;
			}
			else{
				array_push($rows, $main);
			}
		}else{
			return false;
		}
		if($stmt = $this->driver->prepare('SELECT * FROM V_AjusteEntradaDetalle WHERE IDAjusteEntrada = ?')){

			if(!$stmt->bind_param('i',$idAjusteEntrada))
				return false;

			if(!$stmt->execute()){
				return false;
			}

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){
				$rows = array();
				while($result = $mySqliResult->fetch_assoc()){
					array_push($rows, $result);
				}
				if(empty($rows))
					return VACIO;
				$result = array('ajusteEntrada'=>$main,
								'productos'=>$rows
								);
				return $result;
			}else
				return VACIO;

		}else
			return false;

		return false;
	}
}
?>