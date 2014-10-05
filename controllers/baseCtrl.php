<?php
	/**
	* Controlador Base
	* Clase base para los controladores que serán creados en la aplicación
	* @version 0.1
	*/
	class BaseCtrl
	{
		/** Donde se guardará el modelo */
		protected $model;
		
		/**
		*	Inicia una sesion y retorna true si se inició, false si ya existía una activa
		*	@param string $user
		*	@param string $pass
		*	@param string $type
		*	@return bool
		*/
		public static function startSession($user, $pass, $type){
			if (BaseCtrl::isLoged() || empty($user) || empty($pass) || empty($type))
				return FALSE;
			$_SESSION['user'] = $user;
			$_SESSION['pass'] = $pass;
			$_SESSION['type'] = $type;

			echo '<meta http-equiv="refresh" content="0; url=./">';
			
			return TRUE;
		}

		/**
		*	Destruye una sesion
		*/
		public static function killSession(){
			session_start();

			session_unset();
			session_destroy();
			
			setcookie(session_name(), '', time()-3600);

			die('<meta http-equiv="refresh" content="0; url=./">');
		}

		/**
		*	Verifica si hay una sesion activa
		*/
		public static function isLoged(){
			return isset($_SESSION['user']);
		}



		/** 
		 *	Valida que una cadena sea un número, retorna la cadena si lo es, en caso de no serlo returna una cadena vacía
		 *	@param string $data
		 *	@return string $data
		 */
		public static function validateNumber($data){
			if(is_numeric($data))
				return $data;
			return "";
		}

		/**
		 *	Valida que una cadena esté limpia, si es así la retorna, en caso de no estarlo, retornará una cadena vacía
		 *	@param string $data
		 *	@return string $data
		 */
		public static function validateText($data){
			//verificamos si es un arreglo
			if(is_string($data)){
				//saco el tamaño en caracteres del valor
				$tamaño=strlen($data);
				//verificamos que exista, que no este vacio, que si tamaño sea menor o igual a 200
				//que no contenga caracteres de escape, quitamos barras y escapamos comillas y quitamos tags
				if(!(
					isset($data) && 
					$data!="" && 
					$tamaño<=200 && 
					$tamaño==strlen($data=trim($data)) && 
					$tamaño==strlen($data=stripslashes($data)) && 
					$tamaño==strlen($data=addslashes($data)) &&
					$tamaño==strlen($data=strip_tags($data))
					)
				){
					//regresamos cadena vacía en caso de que la cadena no cumpla la validacion
					return "";
				}
			}
			//todo resultó perfecto
			return $data;
		}
		
		/**
		*	Valida que la cadena de texto sea un correo válido, retorna la cadena sin espacios al inicio o al final si lo es, en caso de no serlo returna una cadena vacía
		*	@param string $data
		*	@return string $data
		*/
		public static function validateEmail($data){
			$data = trim($data);
			$regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
			if(preg_match($regex, $data))
				return $data;
			return "";
		}

		/**
		*	Valida que la cadena de texto sea un teléfono, retorna la cadena sin espacios al inicio o al final si lo es, en caso de no serlo returna una cadena vacía
		*	@param string $data
		*	@return string $data	
		*/
		public static function validatePhone($data){
			$data = trim($data);
			$regex = "/^(\+\d{1,4}[- ])?(\d+([ -])*)+$/";
			if(preg_match($regex, $data))
				return $data;
			return "";
		}

		/**
		*	Valida que la cadena de texto sea un nombre válido, retorna la cadena sin espacios al inicio o al final si lo es, en caso de no serlo returna una cadena vacía
		*	@param string $data
		*	@return string $data	
		*/
		public static function validateName($data){
			$data = trim($data);
			if(strcmp(substr($data,-1)," ")!=0)
				$data.=' ';
			$regex = "/^([a-zA-ZáéíóúÁÉÍÓÚ]+ ?){1,5}$/";
			if(preg_match($regex, $data))
				return $data;
			return "";
		}
		/**
		*	Valida que la cadena de texto sea una fecha válida, retorna la cadena sin espacios al inicio o al final si lo es, en caso de no serlo returna una cadena vacía
		*	@param string $data
		*	@return string $data	
		*/
		public static function validateDate($data){
			$data = trim($data);
			$d = DateTime::createFromFormat('Y-m-d', $data);
    		return ($d && $d->format('Y-m-d') == $data)?$data:"";
		}
		
		/**
		* TODO
		* DOCS
		*/
		public static function validateNumericArray($data){
			/*$result = array();
			
			foreach($data as $key=>$value){
				echo $key.' '.$value.'<br/>';
				if( strlen(validateNumber($value)) == 0 ){
					array_push($result, $key);
				}
			}
			return $result;*/
			return array();
		}

		/**
		* Construye un controlador Base
		* Manda a llamar el header y
		* el inicio de sesión o la bienvenida en caso de que esté logueado
		*/
		function __construct(){
			//require_once 'views/header.php';
			if(BaseCtrl::isLoged()){
				require_once 'views/bienvenido.php';
			}else{
				require_once 'views/login.php';
			}
		}
	}
?>
