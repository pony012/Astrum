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
										AjusteEntrada (IdAjusteEntradaTipo,IdCliente, Folio, Observaciones)
										VALUES(?,?,?,?)";
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
										AjusteEntradaDetalle (IdAjusteEntrada,IdProductoServicio,Cantidad)
										VALUES(?,?,?)";
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
}
?>