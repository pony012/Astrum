<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de FichaClinica del cliente
	*/
class FichaClinicaMdl extends BaseMdl{
	private $motivoConsulta;
	private $tiempoProblema;
	private $relacionaCon;
	private $tratamientoAnterior;
	private $metProbados;
	private $resAnteriores;
	
	/**
	 *@param string $motivoConsulta
	 *@param string $tiempoProblema
	 *@param string $relacionaCon
	 *@param string $tratamientoAnterior
	 *@param string $metProbados
	 *@param string $resAnteriores
	 *Crea un nuevo
	 *@return true
	 */
	function create($motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores){
		$this->motivoConsulta		= $this->driver->real_escape_string($motivoConsulta);
		$this->tiempoProblema		= $this->driver->real_escape_string($tiempoProblema);
		$this->relacionaCon 		= $this->driver->real_escape_string($relacionaCon);
		$this->tratamientoAnterior 	= $this->driver->real_escape_string($tratamientoAnterior);
		$this->metProbados 			= $this->driver->real_escape_string($metProbados);
		$this->resAnteriores 		= $this->driver->real_escape_string($resAnteriores);
		
		$stmt = $this->driver->prepare("INSERT INTO FichaClinica (MotivoConsulta, TiempoProblema, RelacionaCon, TratamientoAnterior, 
																	MetodosProbados, ResultadosAnteriores) 
										VALUES(?,?,?,?,?,?)");
		if(!$stmt->bind_param('ssssss',	$this->motivoConsulta, $this->tiempoProblema, $this->relacionaCon, $this->tratamientoAnterior, 
										$this->metProbados, $this->resAnteriores)){
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