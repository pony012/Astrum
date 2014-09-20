<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de los Tipos de Producto-Servicio ofrecidos al cliente
	*/
class ProdutoServicioTipoMdl extends BaseMdl{
	private $productoServicioTipo;
	private $descripcion;
	
	/**
	 *@param string $productoServicioTipo
	 *@param string $descripcion
	 *Crea un nuevo tipo de producto-servicio
	 *@return true
	 */
	function create($productoServicioTipo, $descripcion){
		$this->productoServicioTipo = $productoServicioTipo;
		$this->descripcion	= $descripcion;
		
		return true;
	}
}
?>