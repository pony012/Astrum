<?php
	/**
	* Modelo Base
	* Clase base para los modelos que serán usados en la aplicación
	* @version 0.1
	*/
	class BaseMdl
	{
		public $driver;
		
		/**
		 *	Crea el driver necesario para la conexión a la base de datos
		 *	@param string	$server	Dirección donde está alojada la base de datos
		 *	@param string	$user	Usuario de la base da datos
		 *	@param string	$pass	Contraseña del usuario con el que se accederá la base de datos
		 *	@param string	$db		Nombre de la base de datos
		 *	@return true si se pudo crear el driver, false en caso contrario
		 */
		final function setDriver($server, $user, $pass, $db)
		{
			//TODO
			//Cargar las configuraciones de la bdd y crear el driver
			$mysqli = new mysqli($server,$user,$pass,$db);
			if($mysqli->connect_error)
				return false;
			$this->driver = $mysqli;
			return true;
		}	

		function __construct(){
			require_once 'config.cf';
			$this->setDriver(__SERVER_NAME__,__USER_NAME__,__PASS__,__DB_NAME__);
		}
	}
?>