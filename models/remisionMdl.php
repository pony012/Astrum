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
		$this->fechaRemision	= $fechaRemision;
		$total = 0;
		for($i = 0;$i < count($idProductos);$i++){
			if(!$this->createDetails(1,$idProductos[$i],$cantidades[$i],$precioUnitario[$i],$ivas[$i],$descuentos[$i]))
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
		
		return true;
	}

	/**
	* Consulta las remisiones registradas
	* @return array or false
	**/
	function lists(){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Remision')){

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