<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de los Tipos de Ajuste de Salida
	*/
class AjusteSalidaTipoMdl extends BaseMdl{
	private $tipo;
	private $exclusivoSistema;
	private $descripcion;
	
	/**
	 *@param string $tipo
	 *@param string $exclusivoSistema
	 *@param string $descripcion
	 *Crea un nuevo tipo de movimiento de almacen
	 *@return true
	 */
	function create($tipo, $exclusivoSistema, $descripcion){
		$this->tipo 			= $this->driver->real_escape_string($tipo);
		$this->exclusivoSistema	= $this->driver->real_escape_string($exclusivoSistema);
		$this->descripcion		= $this->driver->real_escape_string($descripcion);
		
		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteSalidaTipo (Tipo,ExclusivoSistema,Descripcion)
										VALUES(?,?,?)");
		if(!$stmt->bind_param('sss',$this->tipo,$this->exclusivoSistema,$this->descripcion)){
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