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

		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteSalida (IDAjusteSalidaTipo,IDProveedor, Folio, Observaciones)
										VALUES(?,?,?,?)");
		if(!$stmt->bind_param('iiis',$this->idAjusteSalidaTipo,$this->idProveedor,$this->folio,$this->observaciones)){
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
			if(!$this->createDetails($lastId,$idProductos[$i],$cantidades[$i]))
				return false;
		}
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
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()){
			die('Error al insertar en la base de datos');
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}
	
	/**
	* Consulta los Ajustes de Salida registrados
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_AjusteSalida WHERE ?')){
			
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
	* @param Integer $idAjusteSalida
	* Consulta los detalles de los Ajustes de Salida registrados
	* @return array or false
	**/
	function listsDetails($idAjusteSalida){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_AjusteSalidaDetalle WHERE IDAjusteSalida = ?')){

			if(!$stmt->bind_param('i',$idAjusteSalida))
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