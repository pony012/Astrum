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
	}
?>