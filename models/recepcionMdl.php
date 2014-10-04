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
		$this->idProveedor = $idProveedor;
		$this->folio	= $folio;
		$this->fechaRecepcion	= $fechaRecepcion;
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
		$this->idRecepcion = $idRecepcion;
		$this->idProductoServicio = $idProductoServicio;
		$this->cantidad	= $cantidad;
		$this->precioUnitario	= $precioUnitario;
		$this->iva	= $iva;
		$this->descuento	= $descuento;
		
		return true;
	}
	
	/**
	* Consulta las recepciones registradas
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Recepcion WHERE ?')){
		
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
	* @param Integer $idRecepcion
	* Consulta los detalles de las recepciones registradas
	* @return array or false
	**/
	function listsDetails($idRecepcion){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_RecepcionDetalle WHERE IDRecepcion = ?')){

			if(!$stmt->bind_param('i',$idRecepcion))
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