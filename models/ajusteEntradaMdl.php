<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de Ajuste de Entrada
	*/
class AjusteEntradaMdl extends BaseMdl{
	private $idAjusteEntradaTipo;
	private $idCliente;
	private $folio;
	private $observaciones;
	
	private $idAjusteEntrada;
	private $idProductoServicio;
	private $cantidad;
	
	/**
	 *@param integer $idMovimientoAlmacen
	 *@param integer $idAjusteEntradaTipo
	 *@param integer $idCliente
	 *@param integer $folio
	 *@param string $observaciones
	 *@param integer $idAjusteEntrada
	 *@param array $idProductos
	 *@param array $cantidades
	 *Crea un nuevo ajuste de entrada
	 *@return true
	 */
	function create( $idAjusteEntradaTipo, $idCliente = NULL, $folio, $observaciones,$idProductos,$cantidades){
		$this->idAjusteEntradaTipo 	= $idAjusteEntradaTipo;
		$this->idCliente			= $idCliente;
		$this->folio				= $folio;
		$this->observaciones		= $this->driver->real_escape_string($observaciones);

		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteEntrada (IDAjusteEntradaTipo,IDCliente, Folio, Observaciones)
										VALUES(?,?,?,?)");
		if(!$stmt->bind_param('iiis',$this->idAjusteEntradaTipo,$this->idCliente,$this->folio,$this->observaciones)){
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
	 *@param integer $idAjusteEntrada
	 *@param integer $idProductoServicio
	 *@param decimal $cantidad
	 *Crea un nuevo detalle de un ajuste de entrada
	 *@return true
	 */
	function createDetails($idAjusteEntrada, $idProductoServicio, $cantidad){
		$this->idAjusteEntrada 		= $idAjusteEntrada;
		$this->idProductoServicio 	= $idProductoServicio;
		$this->cantidad				= $cantidad;
		
		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteEntradaDetalle (IDAjusteEntrada,IDProductoServicio,Cantidad)
										VALUES(?,?,?)");
		if(!$stmt->bind_param('iid',$this->idAjusteEntrada, $this->idProductoServicio, $this->cantidad)){
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
	* Consulta los ajustes de entrada registrados
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_AjusteEntrada WHERE ?')){
			
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
	* @param Integer $idAjusteEntrada
	* Consulta los detalles de los ajustes de entrada registrados
	* @return array or false
	**/
	function listsDetails($idAjusteEntrada){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_AjusteEntradaDetalle WHERE IDAjusteEntrada = ?')){

			if(!$stmt->bind_param('i',$idAjusteEntrada))
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