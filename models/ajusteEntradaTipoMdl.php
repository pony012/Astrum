<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de los Tipos de Ajustes de Entrada
	*/
class AjusteEntradaTipoMdl extends BaseMdl{
	private $tipo;
	private $exclusivoSistema;
	private $descripcion;
	
	/**
	 *@param string $tipo
	 *@param string $exclusivoSistema
	 *@param string $descripcion
	 *Crea un nuevo tipo de ajuste de entrada
	 *@return true
	 */
	function create($tipo, $exclusivoSistema, $descripcion){
		$this->tipo 			= $this->driver->real_escape_string($tipo);
		$this->exclusivoSistema	= $this->driver->real_escape_string($exclusivoSistema);
		$this->descripcion		= $this->driver->real_escape_string($descripcion);

		$stmt = $this->driver->prepare("INSERT INTO 
										AjusteEntradaTipo (Tipo,ExclusivoSistema,Descripcion)
										VALUES(?,?,?)");
		if(!$stmt->bind_param('sss',$this->tipo,$this->exclusivoSistema,$this->descripcion)){
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