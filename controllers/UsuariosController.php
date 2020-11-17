<?php 

/**
* 
*/
class UsuariosController extends Controller
{
	
	public function __construct(){

		parent::__construct();
	}


	public function index(){

		//verificamos si el usuario se encuentra logueado, si no lo redireccionamos al login
		if(Session::get("autenticado")){
			
			
			Session::accesoEstricto(["1"]);

			$model = new Usuarios();

			

			//Parametros a pasar a la vista

			$this->_view->titulo = "Listado de Usuarios";
			$this->_view->nombre =  $model->name; 
			$this->_view->campo_clave =  $model->field_key; 

			//Fin parametros

			$this->_view->render("index", 'site',["model"=>$model]);
		}else{
			$this->redirect("login/index");
		}
	}


	public function actualizar($id){

		if(Session::get("autenticado")){
			//para actualizar la contraseña se debe ser rol 2 y 3
			//si se desea que el admin(por default deberia ser 1) no tenga acceso al metodo, enviar el segundo parametro como true
			Session::accesoEstricto(["2","3"],true);

			$model = new Usuarios();
			


			if(!$this->filtrarInt($id)){

				$this->redirect("site/index");
			}


			if(!$model->findModel($this->filtrarInt($id) )){ 

				$this->redirect("site/index");
			}


			$this->_view->titulo = "Actualizar Contraseña";
			
			if($this->getInt('guardar') == 1){


				//validaciones

				if(!$this->getSql("pass_usuario")){
					$this->_view->error = "Por favor, debe introducir una contraseña";
					$this->_view->render("actualizar","usuarios");
					exit;
				}			

				//verificamos que la contraseña introducida en la verificacion sean iguales
				if($this->getSql("pass_usuario") != $this->getSql("confirmar")){
					$this->_view->error = "Las contraseñas introducidas no coinciden";
					$this->_view->render("actualizar","usuarios");
					exit;
				}				

				//fin validaciones

			$model->editarClave($this->filtrarInt($id), $this->getSql("pass_usuario"));

			$this->redirect("index/index&ok=7");

			}else{

				$this->_view->render("actualizar", "usuarios");
			}
			
		}else{
			$this->redirect("login/index");
		}  
	}


	public function actualizar_info($id_user)
	{
		
		if(Session::get("autenticado")){
		$model = new Usuarios();

		$this->_view->titulo = "Actualizar Información de Usuario";

		if($model->requestPost())
		{

			$pregunta_secreta = $model->preg_secreta;
			$respuesta = $model->resp_secreta;

			$model->normalQuery("update usuario set preg_secreta = '$pregunta_secreta', resp_secreta = '$respuesta' where cod_usuario = $id_user ");

			$model->normalQuery("update usuario set first_login = 'FALSE' where cod_usuario = $id_user ");

			$this->redirect("site/index&ok=34");

		}else{
			$this->_view->render("actualizar_info", "usuarios",["model"=>$model]);

		}
		}else{
			$this->redirect("site/login");
		}  

	}

}

?>