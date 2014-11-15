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
		$this->productoServicioTipo = $this->driver->real_escape_string($productoServicioTipo);
		$this->descripcion			= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO ProductoServicioTipo (ProductoServicioTipo, Descripcion) 
										VALUES(?,?,?,?,?)");
		if(!$stmt->bind_param('ss',$this->productoServicioTipo,$this->descripcion)){
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
}
?>