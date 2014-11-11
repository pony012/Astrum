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
		protected $twig;
		protected $loader;
		protected $session;
		
		/**
		*	Inicia una sesion y retorna true si se inició, false si ya existía una activa
		*	En caso de que el usuario esté en la base de datos, se guardará en la sesión el nombre del usuario
		*	y su tipo.
		*	Los tipos de usuario son:
		*	{1=>Admin, 2=>Terapeuta, 3=>Empleado}
		*	@param string $user
		*	@param string $pass
		*	@return bool
		*/
		public static function startSession($user, $pass){
			if (BaseCtrl::isLoged()){
				echo '<meta http-equiv="refresh" content="0; url=./">';
				return true;
			}
			if (empty($user) || empty($pass)){
				echo '<meta http-equiv="refresh" content="0; url=./">';
				return false;
			}
			require_once 'models/baseMdl.php';

			$userMdl = new BaseMdl();

			$_user	= $userMdl->driver->real_escape_string($user);
			$_pass	= $userMdl->driver->real_escape_string($pass);

			$stmt = $userMdl->driver->prepare("SELECT * FROM Empleado WHERE Usuario = ?");
			if(!$stmt->bind_param('s',$_user)){
				//No se pudo bindear el nombre, error en la base de datos
			}else if (!$stmt->execute()) {
				//No se pudo ejecutar, error en la base de datos
			}else{
				$result = $stmt->get_result();
				if($result->field_count > 0){
					$result = $result->fetch_array();
					if(strcmp($result['Contrasena'],$pass)==0){
						//md5(md5("1234")."astrum1234".md5("astr"))
						//b956f5207a5f0bfa514292171f1c285f
						$_SESSION['user'] = $user;
						//$_SESSION['pass'] = $pass;
						$_SESSION['type'] = $result['IDCargo'];
						echo '<meta http-equiv="refresh" content="0; url=./">';
						return true;
					}else{
						//Cargar vista de fallo de contraseña
						echo '<meta http-equiv="refresh" content="0; url=./">';
					}
				}else{
					//No se encontró usuario con ese nombre :(
					echo '<meta http-equiv="refresh" content="0; url=./">';
				}
			}
			echo '<meta http-equiv="refresh" content="0; url=./">';
			return false;
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
		*	Retorna el id del cargo que está logueado
		*/
		public static function getType(){
			return $_SESSION['type'];
		}
		/**
		*	Retorna true si el usuario tiene permisos de administrador
		*/
		public static function isAdmin(){
			if(BaseCtrl::isLoged()){
				return BaseCtrl::getType()==1;
			}
			return false;
		}
		/**
		*	Retorna true si el usuario tiene permisos de terapeuta
		*/
		public static function isTerapeuta(){
			if(BaseCtrl::isLoged()){
				return (BaseCtrl::isAdmin() || BaseCtrl::getType()==2);
			}
			return false;
		}
		/**
		*	Retorna true si el usuario tiene permisos de empleado
		*/
		public static function isEmpleado(){
			if(BaseCtrl::isLoged()){
				return (BaseCtrl::isTerapeuta() || BaseCtrl::getType()==3);
			}
			return false;
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
		*	Envia un correo al email especificado
		*	@param string $correo
		* 	@param string $asunto
		*	@param string $body
		* 	@param array $remplazos
		*	@return bool 
		*/
		public static function enviarCorreo($correo,$asunto,$body,$remplazos){
			require_once 'PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			
			$mail->Host = "mail.astrum.x10.mx";
			$mail->Port = 25;
			$mail->SMTPAuth = true;
			$mail->Username = "contacto@astrum.x10.mx";
			$mail->Password = "astrum1234";
			
			$mail->setFrom('contacto@astrum.x10.mx', 'SpaDamaris');	
			$mail->addAddress($correo);

			$mail->Subject = 'SpaDamaris: '.$asunto;
			$lineas = file($body);
			$mensaje = '';
			foreach ($lineas as $value) {
				$mensaje.=strtr($value,$remplazos);
			}
			$mail->msgHTML($mensaje);
			
			
			if (!$mail->send()) {
			    return false;
			} else {
			    return true;
			}
		}

		public static function loadIndex(){
			//require_once 'views/header.php';
			$session = array(
				'isLoged'=>BaseCtrl::isLoged(),
				'user'=>isset($_SESSION['user'])?$_SESSION['user']:NULL,
				'isAdmin' => BaseCtrl::isAdmin(),
				'isTerapeuta' => BaseCtrl::isTerapeuta(),
				'isEmpleado' => BaseCtrl::isEmpleado(),
				'cargo'=>BaseCtrl::isAdmin()?'Admin':(BaseCtrl::isTerapeuta()?'Terapeuta':'Empleado'),
				'controller'=>'index',
				'document_root' => __DOCUMENT_ROOT__
			);

			require_once 'Twig/Autoloader.php';
			Twig_Autoloader::register();

			$loader = new Twig_Loader_Filesystem('views/');
			$twig = new Twig_Environment($loader, array(
			    //'cache' => '/cache',
			));

			$template = $twig->loadTemplate('index.html');
			echo $template->render(array('session'=>$session));
		}

		public static function loadLogin(){
			if(BaseCtrl::isLoged())
				die('<meta http-equiv="refresh" content="0; url=./">');
			$session = array(
				'isLoged'=>BaseCtrl::isLoged(),
				'user'=>isset($_SESSION['user'])?$_SESSION['user']:NULL,
				'isAdmin' => BaseCtrl::isAdmin(),
				'isTerapeuta' => BaseCtrl::isTerapeuta(),
				'isEmpleado' => BaseCtrl::isEmpleado(),
				'cargo'=>BaseCtrl::isAdmin()?'Admin':(BaseCtrl::isTerapeuta()?'Terapeuta':'Empleado'),
				'controller'=>'loginB',
				'document_root' => __DOCUMENT_ROOT__
			);

			require_once 'Twig/Autoloader.php';
			Twig_Autoloader::register();

			$loader = new Twig_Loader_Filesystem('views/');
			$twig = new Twig_Environment($loader, array(
			    //'cache' => '/cache',
			));

			$template = $twig->loadTemplate('loginB.html');
			echo $template->render(array('session'=>$session));
		}

		/**
		* Construye un controlador Base
		* Manda a llamar el header y
		* el inicio de sesión o la bienvenida en caso de que esté logueado
		*/
		function __construct(){
			require_once 'config.cf';
			require_once 'systemStatus.php';
			//require_once 'views/header.php';
			$this->session = array(
				'isLoged'=>BaseCtrl::isLoged(),
				'user'=>isset($_SESSION['user'])?$_SESSION['user']:NULL,
				'isAdmin' => BaseCtrl::isAdmin(),
				'isTerapeuta' => BaseCtrl::isTerapeuta(),
				'isEmpleado' => BaseCtrl::isEmpleado(),
				'cargo'=>BaseCtrl::isAdmin()?'Admin':(BaseCtrl::isTerapeuta()?'Terapeuta':'Empleado'),
				'controller'=>'index',
				'action'=>'',
				'document_root' => __DOCUMENT_ROOT__
			);

			require_once 'Twig/Autoloader.php';
			Twig_Autoloader::register();

			$this->loader = new Twig_Loader_Filesystem('views/');
			$this->twig = new Twig_Environment($this->loader, array(
			    //'cache' => '/cache',
			));
		}
	}
?>
