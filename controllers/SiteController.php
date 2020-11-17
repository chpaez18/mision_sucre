<?php


/**
* 
*/
class SiteController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}


	public function index(){
		
		$model = new Site();
		if(Session::get("autenticado")){
					Session::accesoEstricto(["1","2","3","4"]);
					$this->_view->titulo = "Inicio";
					$this->_view->render("index",["model"=>$model]);

		}else{

				$this->redirect("site/login");
		}


	}	



	//funcion para realizar el login
	public function login()
	{
		$model = new Site();
		$this->_view->titulo = "Iniciar Sesión";

		if($model->requestPost())
		{

		if($model->txtcopia != $model->captcha){
			$this->_view->error = "<b>¡Atención!</b>El código captcha ingresado, es incorrecto";
				$this->_view->render("login", "site");
				exit;	
		}
		
		$this->_view->datos = $_POST;

		$nombre_usuario = strtolower($this->getData($model->nom_usuario));
		$pass_hash = Hash::getHash("sha1",$model->pass_usuario,HASH_KEY);


		//en primera instancia hacemos un query para validar si el nombre de usuario existe
		$user = $model->searchByQuery("select * from usuario where nom_usuario = '$nombre_usuario' ");

		if(!$user){
			$this->_view->error = "<b>¡Atención!</b> Nombre de usuario y/o contraseña incorrecto(s).";
			$this->_view->render("login","site");
		}

		if($user){
			//en caso de existir, guardamos el id del usuario
			$id = $user["cod_usuario"];

			//procedemos a verificar si su cuenta esta activa o bloqueada
			if($user["estado"] == "B"){
				$this->_view->error = "<b>¡Atención!</b> Este usuario se encuentra bloqueado por multiples intentos fallidos de inicio de sesión, por favor dirijase al módulo de restablecimiento de contraseña.";
				$this->_view->render("login", "site");
				exit;	
			}
		}

		//seguido hacemos un segundo query donde verificamos ademas del nombre de usuario, la contraseña
		$user1 = $model->searchByQuery("select * from usuario where nom_usuario = '$nombre_usuario' and pass_usuario ='".$pass_hash."'");
		

				

		if(!$user1){
			
			//en caso de no existir el user, guardamos la cantidad de intentos que tiene	
			$intentos = $user["intentos_login"];

			//y le sumamos 1
			$cant = $intentos+1;

			//actualizamos el registro
			$model->normalQuery("update usuario set intentos_login = $cant where cod_usuario = $id ");

			$this->_view->error = "<b>¡Atención!</b> Nombre de usuario y/o contraseña incorrecto(s). <br> Recuerde que luego de 3 intentos fallidos, su cuenta será bloqueada preventivamente.";

			if($intentos == 3){
				//validamos si se llegan a los 3 intentos, bloqueamos la cuenta
				$model->normalQuery("update usuario set estado = 'B', intentos_login = 0 where cod_usuario = $id");

				$this->_view->error = "<b>¡Atención!</b> Se ha introducido 3 veces una contraseña incorrecta para el usuario <b>$nombre_usuario</b>, y su cuenta ha sido bloqueada como medida de seguridad.";
			}
			$this->_view->render("login", "site");
			exit;
		}

		//guardamos el ssid del usuario, con el fin de validar si ya se tiene una sesion iniciada
		$ssid = $user["ssid"];

		if($ssid){
			//en caso de que ya el usuario tenga un ssid, quiere decir que ya tiene una sesion activa
			$this->_view->error = "<b>¡Atención!</b> Este usuario ya tiene una sesión iniciada.";
			$this->_view->render("login", "site");
			exit;				
		}
		


		

		//apartir de aca podemos ir llenando variables de sesion segun vayamos necesitando

		Session::set("autenticado", true);

		Session::set("level", $user["rol_cod_rol"]);

		Session::set("usuario", $user["nom_usuario"]);

		Session::set("cod_usuario", $user["cod_usuario"]);

		Session::set("first_login", $user["first_login"]);

		Session::set("tiempo", time());

		$id_user = $user["cod_usuario"];
		$id_crypt = $model->encrypt($user["cod_usuario"]);

		$model->normalQuery("update usuario set ssid = '$id_crypt', intentos_login = 0 where cod_usuario = $id_user");
		
		if(Session::get("level") == 3){
			$this->redirect("site/index");
		}else{

			if($user["first_login"]){
				echo "<script>
					alert('Debe actualizar su contraseña e información de usuario.');
				</script>";

				$this->redirect("site/actualizar_contra/$id_user");

			}else{
				$this->redirect("site/index");
			}
		}


		}else{

			//verificamos si el usuario ya tiene una sesion iniciada e intenta entrar de nuevo al login, lo redireccionamos al index, si no, lo redireccionamos normalmente a la pagina de inicio de sesion

			if(Session::get("autenticado")){
				$this->_view->error = "Ya tiene iniciada una sesión";

				$this->redirect("site/index");
			}else{
				$this->_view->render("login", 'site',["model"=>$model]);
			}

		}

	}


	//funcion para realizar un registro como usuario
	public function registro()
	{
		$model = new Site();
		//seguridad extra, en caso de que alguien inserte una cédula via url
		if($_GET["ci"]){
			
			$ci = $_GET["ci"];

			$registro = $model->searchByQueryOne("select * from estudiante where cedula_estudiante = '$ci'");
			if($registro){
				$id_user = $registro->usuario_cod_usuario;
			}else{
				$this->redirect("site/login&ok=4");
			}
			
			
			if($id_user){
				$this->redirect("site/login&ok=8");
			}
			
		}else{
			$this->redirect("site/login");
		}
		

		$model = new Site();

		//verificamos si el usuario esta autenticado
		//para poder entrar al registro de usuario debe cerrar sesion primero
		if(Session::get("autenticado")){
			$this->redirect("site/index");
		}

		//validamos que si el usuario se encuentra con su inscripcion formalizada, redirigimos al login, ya que no deberia poder volver a crear un usuario
		if($registro->inscripcion_formalizada){
			$this->redirect("site/login&ok=24");
		}

		$this->_view->titulo = "Registro";

		if($model->requestPost()){
			
			$cedula_estudiante = $model->cedula;
			$user = $model->searchByQuery("select * from usuario where nom_usuario = '$model->nom_usuario'");

			//verificamos si ese usuario existe
			if($user){
				
				$this->_view->error = "<b>¡Atención!</b> El nombre de usuario: <b>".$model->nom_usuario."</b> ya se encuentra registrado.";

				$this->_view->render("registro","site", [
					"model"=>$model
				]);

				exit;
			}

			$nombre_usuario = strtolower($model->nom_usuario);
			$clave = Hash::getHash("sha1", $model->pass_usuario, HASH_KEY);

			$model->normalQuery("insert into usuario (nom_usuario, pass_usuario, preg_secreta, resp_secreta, rol_cod_rol) values ('$nombre_usuario', '$clave', $model->preg_secreta, '$model->resp_secreta', 3)");

			//obtenemos el id del ultimo usuario registrado
			$usuario = $model->searchByQueryOne("select * from usuario ORDER BY cod_usuario desc limit 1");
			$id_usuario = $usuario->cod_usuario;

			//actualizamos el id del usuario del estudiante
			$model->normalQuery("update estudiante set usuario_cod_usuario = $id_usuario where cedula_estudiante = '$cedula_estudiante'");


			$this->redirect("site/login&ok=6");

		}

			$this->_view->render("registro","site",[
				"model"=>$model
			]);

	}


	//funcion para verificar si un estudiante se encuentra registrado en el sistema
	public function verificarEstudiante(){

		if(Session::get("autenticado")){
			$this->redirect("site/index");
		}
			
		
		$model = new Site();
		$this->_view->titulo = "Verificación";
		

		if($model->requestPost()){


			//validaciones

			if(!$model->cedula){
				$this->_view->error = "Por favor, debe introducir un número de cédula.";
				$this->_view->render("verificarEstudiante","site");
				exit;
			}	

			//fin validaciones
			$nac = $model->nac;
			$result = 	$model->searchByQuery("select * from estudiante where nac = '$nac' and cedula_estudiante = '$model->cedula' ");	


			if($result){

				//guardamos en $control el resultado que devuelva la funcion, para evaluar si el numero de cedula tiene un usuario registrado o no
				$control = 	$this->userControl($model->cedula);

				if($control){

					//en caso de ser true, quiere decir que ya tiene un usuario registrado, por lo que lo redirigimos al login
					$this->redirect("site/login&ok=8");

				}else{
					
					$this->redirect("site/registro&ok=5&ci=".$model->cedula);
				}
			}else{

				$this->redirect("site/verificarEstudiante&ok=4");
			}
		}else{


			$this->_view->render("verificarEstudiante", "registro");
		}  
	}


	//funcion que verifica si un estudiante cuenta con un usuario registrado
	public function userControl($cedula_estudiante){
		$model = new Site();

		$estudiante = $model->searchByQuery("select * from estudiante where cedula_estudiante = '$cedula_estudiante' ");
		
		$id_user = $estudiante["usuario_cod_usuario"];

		//en caso de que id_user no devuelva un dato hacemos una condicion para igualarlo a algo y realizar la siguiente consulta
		if($id_user){
			$id_user_formated = $id_user;
		}else{
			$id_user_formated = 0;
		}

		$usuarios = $model->searchByQuery("select * from usuario where cod_usuario = $id_user_formated ");

		
		if ($usuarios) {
			return true;
		}else{
			return false;
		}
	}

	public function recuperar_contra()
	{
		$model = new Site();
		//$model_registro = new Registro();

		$this->_view->titulo = "Recuperación de Contraseña";

		if($model->requestPost())
		{


			$response = $model->searchByQueryOne("select * from usuario where nom_usuario = '$model->nom_usuario'");

			if ($response) {
				
				$pregunta_secreta = $response->preg_secreta;

					$this->redirect("site/pregunta_contra", ["id"=>$pregunta_secreta, "user"=>$response->cod_usuario]);

			}else{

				$this->_view->error = "Lo sentimos, el nombre de usuario proporcionado no se encuentra registrado.";
				$this->_view->render("recuperar_contra","site",["model"=>$model]);
				exit;
			}


		}else{

			$this->_view->render("recuperar_contra", "site");

		}

	}	


	public function pregunta_contra()
	{
		
		$model = new Site();

		$this->_view->titulo = "Pregunta de Seguridad";

		if($model->requestPost())
		{
			$id_user = $this->getAlphaNum("id_user");
			$respuesta = $this->getAlphaNum("respuesta");

			$response = $model->searchByQueryOne("select * from usuario where cod_usuario = $id_user and resp_secreta ='".$respuesta."'");

			if ($response) {

				$this->redirect("site/actualizar_contra", ["id"=>$response->cod_usuario]);
				
			}else{

				$this->_view->error = "<b>¡Atención!</b> Respuesta de seguridad incorrecta.";
				$this->_view->render("pregunta_contra","site",["model"=>$model]);

			}

		}else{

			$this->_view->render("pregunta_contra", "site");

		}

	}	


	public function actualizar_contra($id_user = false)
	{
		
		$model = new Site();

		$this->_view->titulo = "Actualizar Contraseña";

		if($model->requestPost())
		{

			$pass_hash = Hash::getHash("sha1",$model->pass_usuario,HASH_KEY);
			$model->pass_usuario = $pass_hash;
			if($id_user){
				$model->update($id_user);

				
				$this->redirect("site/index&ok=25");
				
			}else{
				$model->normalQuery("update usuario set estado = 'A' where cod_usuario = $model->id_user ");
				$model->update($model->id_user);
				
				$this->redirect("site/login&ok=25");
			}
			

			


		}else{
			$this->_view->render("actualizar_contra", "site",["model"=>$model]);

		}
	}	


	public function actualizar_contra_1($id_user = false)
	{
		
		if(Session::get("autenticado")){
		$model = new Site();

		$this->_view->titulo = "Actualizar Contraseña";

		if($model->requestPost())
		{

			$pass_hash = Hash::getHash("sha1",$model->pass_usuario,HASH_KEY);
			$model->pass_usuario = $pass_hash;
			if($id_user){
				$model->update($id_user);

				$model->normalQuery("update usuario set first_login = 'FALSE' where cod_usuario = $id_user ");
				$this->redirect("site/index&ok=25");
				
			}else{
				$model->normalQuery("update usuario set estado = 'A' where cod_usuario = $model->id_user ");
				$model->update($model->id_user);
				$model->normalQuery("update usuario set first_login = 'FALSE' where cod_usuario = $model->id_user ");
				$this->redirect("site/login&ok=25");
			}
			

			


		}else{
			$this->_view->render("actualizar_contra_1", "site",["model"=>$model]);

		}

		}else{
			$this->redirect("site/login");
		} 
	}

	public function habilitar_carga_notas(){
		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			$model = new Site();
			$id_user = $model->user()->cod_usuario;
			$model->normalQuery("update usuario set hab_carga_notas = '0'");
			$this->_view->mensaje = "<b>¡Atención!</b> ¡Se ha habilitado la carga de notas para los coordinadores!.";
			$this->_view->titulo = "Inicio";
			$this->_view->render("index", "site");

			return false;
		}else{

			$this->redirect("site/index");
		}

	}	

	public function desabilitar_carga_notas(){
		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			$model = new Site();
			$id_user = $model->user()->cod_usuario;
			$model->normalQuery("update usuario set hab_carga_notas = '1'");

			$this->_view->mensaje = "<b>¡Atención!</b> ¡Se ha deshabilitado la carga de notas!.";
			$this->_view->titulo = "Inicio";
			$this->_view->render("index", "site");
				
			return true;
		}else{

			$this->redirect("site/index");
		}
	}	





	public function cerrar()
	{
		$model = new Site();
		$id_user = Session::get("cod_usuario");
		
		//actualizamos el usuario activo, con el fin de borrar su ssid para que pueda iniciar sesion de nuevo
		$model->normalQuery("update usuario set ssid = null where cod_usuario = $id_user ");
		Session::destroy();
		
		$this->redirect("site/login");

	}


}

?>