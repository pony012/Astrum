<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Remisas
	*/
class RemisionMdl extends BaseMdl{
	private $idCliente;
	private $folio;
	private $fechaRemision;
	private $total;
	
	private $idRemision;
	private $idProductoServicio;
	private $cantidad;
	private $precioUnitario;
	private $iva;
	private $descuento;
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idCliente
	 *@param integer $folio
	 *@param date $fechaRemision
	 *@param array $idProductos
	 *@param array $cantidades
	 *@param array $precioUnitario
	 *@param array $ivas
	 *@param array $descuentos
	 *Crea una nueva remision
	 *@return true
	 */
	function create($idCliente, $folio, $fechaRemision,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos){
		$this->idCliente 		= $idCliente;
		$this->folio			= $folio;
		$this->fechaRemision	= $this->driver->real_escape_string($fechaRemision);
		$total = 0;

		$stmt = $this->driver->prepare("INSERT INTO 
										Remision (IDCliente, Folio, FechaRemision)
										VALUES(?,?,?)");
		if(!$stmt->bind_param('iis',$this->idCliente,$this->folio,$this->fechaRemision)){
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()) {
			die('Error al insertar en la base de datos');
		}

		if($this->driver->error){
			return false;
		}

		$lastId = $this->driver->insert_id;

		for($i = 0;$i < count($idProductos);$i++){
			if(!$this->createDetails($lastId,$idProductos[$i],$cantidades[$i],$precioUnitario[$i],$ivas[$i],$descuentos[$i]))
				return false;
			$total += $cantidades[$i]*$precioUnitario[$i];
		}
		$this->total = $total;
		return true;
	}
	
	/**
	 *@param integer $idRemision
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *@param decimal $precioUnitario
	 *@param decimal $iva
	 *@param decimal $descuento
	 *Crea un nuevo detalle de una remision
	 *@return true
	 */
	function createDetails($idRemision,$idProductoServicio,$cantidad,$precioUnitario,$iva,$descuento){
		$this->idRemision 		  = $idRemision;
		$this->idProductoServicio = $idProductoServicio;
		$this->cantidad			  = $cantidad;
		$this->precioUnitario	  = $precioUnitario;
		$this->iva				  = $iva;
		$this->descuento		  = $descuento;
		
		$stmt = $this->driver->prepare("INSERT INTO 
										RemisionDetalle (IDRemision, IDProducto, Cantidad, PrecioUnitario, IVA, Descuento)
										VALUES(?,?,?,?,?,?)");
		if(!$stmt->bind_param('iidddd',$this->idRemision, $this->idProductoServicio, $this->cantidad, $this->precioUnitario, $this->iva, $this->descuento)){
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
	* Consulta las remisiones registradas
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Remision WHERE ?')){
		
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
	* @param Integer $idRemision
	* Consulta los detalles de las remisiones registradas
	* @return array or false
	**/
	function listsDetails($idRemision){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_RemisionDetalle WHERE IDRemision = ?')){

			if(!$stmt->bind_param('i',$idRemision))
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
}
?>