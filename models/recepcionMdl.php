<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Recepciones
	*/
class RecepcionMdl extends BaseMdl{
	private $idProveedor;
	private $folio;
	private $fechaRecepcion;
	private $total;
	
	private $idRecepcion;
	private $idProductoServicio;
	private $cantidad;
	private $precioUnitario;
	private $iva;
	private $descuento;
	
	/**
	 *@param integer $idProveedor
	 *@param integer $folio
	 *@param date $fechaRemision
	 *@param decimal $total
	 *Crea una nueva recepcion
	 *@return true
	 */
	function create($idProveedor, $folio, $fechaRecepcion,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos){
		$this->idProveedor 		= $idProveedor;
		$this->folio			= $folio;
		$this->fechaRecepcion	= $this->driver->real_escape_string($fechaRecepcion);
		$total = 0;

		$this->driver->autocommit(false);
		$this->query->begin_transaction();

		$stmt = $this->driver->prepare("INSERT INTO 
										MovimientoAlmacen (IDMovimientoAlmacenTipo, MovimientoAlmacenFecha, IDEmpleado)
										VALUES(4,?,?)");
		if(!$stmt->bind_param('si', date('Y-m-d'),$_SESSION['IDEmpleado'])){
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
										Recepcion (IDMovimientoAlmacen, IDProveedor, Folio, FechaRecepcion)
										VALUES(?,?,?,?)");
		if(!$stmt->bind_param('iiis', $lastId, $this->idProveedor,$this->folio,$this->fechaRecepcion)){
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
		$idRecepcion = $lastId;

		for($i = 0;$i < count($idProductos);$i++){
			if(!$this->createDetails($lastId,$idProductos[$i],$cantidades[$i],$precioUnitario[$i],$ivas[$i],$descuentos[$i])){
				$this->query->rollback();
				return false;
			}
			$total += $cantidades[$i]*$precioUnitario[$i];
		}
		$this->total = $total;

		$stmt = $this->driver->prepare("UPDATE 
										Recepcion SET Total = ?
										WHERE IDRecepcion = ?");
		if(!$stmt->bind_param('di',$this->total, $idRecepcion)){
			$this->query->rollback();
		}
		if (!$stmt->execute()) {
			$this->query->rollback();
			return false;
		}

		if($this->driver->error){
			$this->query->rollback();
			return false;
		}

		$this->query->commit();
		$this->driver->autocommit(true);
		return true;
	}
	
	/**
	 *@param integer $idRecepcion
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *@param decimal $precioUnitario
	 *@param decimal $iva
	 *@param decimal $descuento
	 *Crea un nuevo detalle de una recepcion
	 *@return true
	 */
	function createDetails($idRecepcion,$idProductoServicio,$cantidad,$precioUnitario,$iva,$descuento){
		$this->idRecepcion 			= $idRecepcion;
		$this->idProductoServicio 	= $idProductoServicio;
		$this->cantidad				= $cantidad;
		$this->precioUnitario		= $precioUnitario;
		$this->iva					= $iva;
		$this->descuento			= $descuento;
		
		$stmt = $this->driver->prepare("INSERT INTO 
										RecepcionDetalle (IDRecepcion, IDProducto, Cantidad, PrecioUnitario, IVA, Descuento)
										VALUES(?,?,?,?,?,?)");
		if(!$stmt->bind_param('iidddd',$this->idRecepcion, $this->idProductoServicio, $this->cantidad, $this->precioUnitario, $this->iva, $this->descuento)){
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
	* Consulta las recepciones registradas y que esten activos
	*@param int $offset
	*@param int $idRecepcion
	* @return array or false
	**/
	function lists($offset = -1,$idRecepcion = -1){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Recepcion LIMIT ?,?');
		}else{
			if($idRecepcion>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Recepcion WHERE IDRecepcion=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Recepcion');
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idRecepcion>-1){
				if(!$stmt->bind_param('i',$idRecepcion))
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
	* @param Integer $idRecepcion
	* Consulta los detalles de las recepciones registradas
	* @return array or false
	**/
	function listsDetails($idRecepcion){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_RecepcionDetalle WHERE IDRecepcion = ?')){

			if(!$stmt->bind_param('i',$idRecepcion))
				return false;

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
}
?>