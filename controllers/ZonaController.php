<?php

/**
* 
*/
class ZonaController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();
		
	}


	public function index(){

		//verificamos si el usuario se encuentra logueado, si no lo redireccionamos al login
		if(Session::get("autenticado")){
			
			//para ver la gestion de zonas se debe ser rol: coordinador cufm es decir level 1
			Session::accesoEstricto(["1"]);

			$model = new Zona();

			$this->_view->titulo = "Listado de Ejes";

			$this->_view->render("index", 'zona',["model"=>$model]);
		}else{
			$this->redirect("site/index");
		}
	}		


	public function nuevo(){

		if(Session::get("autenticado")){
			//Session::acceso("usuario");	//asi establecemos el nivel de acceso para poder usar este metodo, estos niveles pueden ser definidos en el archivo Session.php, en el metodo getLevel()

			/*

			Session::accesoEstricto(["usuario", "especial"]); 

			//con el metodo accesoEstricto() establecemos los roles especificos que podran acceder al metodo, en este ejemplo estamos poniendo que solo el rol "usuario" y "especial" podran entrar, si un rol "admin" entra se le negara el acceso ya que no figura aca

			*/ 
			Session::accesoEstricto(["1"]);

			$model = new Zona();
			$this->_view->titulo = "Nuevo Eje";


			if($model->requestPost()){
				if($model->validateUnique("descripcion", $model->descripcion)){
					$this->_view->error = "<b>¡Atención!</b> El eje <b>$model->descripcion</b>, ya se encuentra registrado en el sistema ";
					$this->_view->render("nuevo", "zona",["model"=>$model]);

				exit;	
			}else{
				$model->save();
			}

				$this->redirect("zona/index&ok=1");
				  
			}else{

				$this->_view->render("nuevo", "zona",[
					"model"=>$model
				]);
			}  
		}else{
			$this->redirect("site/index");
		}		
	}

	public function editar($id){

		if(Session::get("autenticado")){
			//para ver la edicion de zonas se debe ser rol: coordinador cufm es decir level 1

			Session::accesoEstricto(["1"]);

			$model = new Zona();

			//evaluamos que si lo que contiene $id no es un entero, redirigimos a la pagina zona/index

			if(!$this->filtrarInt($id)){

				$this->redirect("zona/index");
			}



			//verificamos si el registro que se solicito no existe, tambien nos redirige a la pagina zonas/index

			if(!$model->findModel($this->filtrarInt($id)) ){ //si el metodo findModel() no devuelve un registro, quiere decir que ese registro no existe por ende redireccionaremos a la pagina zona/index

				$this->redirect("zona/index");
			}


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Editar Eje";
			

			if($model->requestPost()){

			if($model->validateUnique("descripcion", $model->descripcion)){
					$this->_view->error = "<b>¡Atención!</b> El eje <b> $model->descripcion</b>, ya se encuentra registrado en el sistema ";
					$this->_view->render("editar", "zona",["model"=>$model->findModel($this->filtrarInt($id))]);

				exit;	
			}else{
				$model->update($id);
			}

				$this->redirect("zona/index&ok=22");
						
			}else{

				$this->_view->render("editar", "zona",[
					"model"=>$model->findModel($this->filtrarInt($id))
				]);

			}  
		}else{
			$this->redirect("site/index");
		}
	}


/*

	public function eliminar($id){
		
		//Session::acceso("admin");	//asi establecemos el nivel de acceso para poder usar este metodo, estos niveles pueden ser definidos en el archivo Session.php, en el metodo getLevel()


		//evaluamos que si lo que contiene $id no es un entero, redirigimos a la pagina zonas/index
		Session::acceso("1");

		$model = new Zonas();
		
		if(!$this->filtrarInt($id)){

			$this->redirect("zonas/index");
		}


		//verificamos si el registro que se solicito no existe, tambien nos redirige a la pagina post/index

		if(!$model->findModel($this->filtrarInt($id) )){ //si el metodo findModel() no devuelve un registro, quiere decir que ese registro no existe por ende redireccionaremos a la pagina zonas/index

			$this->redirect("zonas/index");
		}

		//en caso de pasar las validaciones, eliminamos el registro
		
		$model->eliminarZona($this->filtrarInt($id));


		$this->redirect("zonas/index&ok=2");
			


	}

*/



}

?>