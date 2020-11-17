<?php


/**
* 
*/
class AldeaController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();
		
	}


	public function getAldeas(){
		$model = new Aldea();
		$registros = $model->searchArrayByQuery("select * from aldea");
		echo json_encode($registros);
	}
	public function index(){

		//verificamos si el usuario se encuentra logueado, si no lo redireccionamos al login
		if(Session::get("autenticado")){
			
			//para ver la gestion de aldeas se debe ser rol: coordinador cufm es decir level 1
			Session::accesoEstricto(["2"]);

			$model = new Aldea();

			$this->_view->titulo = "Listado de Aldeas";

			$this->_view->render("index", 'aldea',["model"=>$model,]);
		}else{
			$this->redirect("site/index");
		}
	}		


	public function nuevo(){

		//Session::acceso("usuario");	//asi establecemos el nivel de acceso para poder usar este metodo, estos niveles pueden ser definidos en el archivo Session.php, en el metodo getLevel()

		/*

		Session::accesoEstricto(["usuario", "especial"]); 

		//con el metodo accesoEstricto() establecemos los roles especificos que podran acceder al metodo, en este ejemplo estamos poniendo que solo el rol "usuario" y "especial" podran entrar, si un rol "admin" entra se le negara el acceso ya que no figura aca

		*/ 
		if(Session::get("autenticado")){

			Session::accesoEstricto(["2"]);

			$model = new Aldea();
			//$model_auditoria = new Auditoria();


			$this->_view->titulo = "Nueva Aldea";

			if($model->requestPost()){

				if($model->validateUnique("nombre_aldea", $model->nombre_aldea)){
					$this->_view->error = "<b>¡Atención!</b> La aldea <b>$model->nombre_aldea</b>, ya se encuentra registrada en el sistema ";
					$this->_view->render("nuevo", "aldea",["model"=>$model]);

				exit;	
				}else{
					$model->save();
				}


				$this->redirect("aldea/index&ok=1");
			}else{

				$this->_view->render("nuevo", "aldea", [
					"model"=>$model
				]);
			}
		}else{
			$this->redirect("site/index");
		}

	}

	public function editar($id){

		//Session::acceso("admin");	//asi establecemos el nivel de acceso para poder usar este metodo, estos niveles pueden ser definidos en el archivo Session.php, en el metodo getLevel()


		//para ver la edicion de aldeas se debe ser rol: coordinador cufm es decir level 1
		if(Session::get("autenticado")){
			Session::accesoEstricto(["2"]);

			$model = new Aldea();
			//evaluamos que si lo que contiene $id no es un entero, redirigimos a la pagina aldeas/index


			if(!$this->filtrarInt($id)){

				$this->redirect("aldea/index");
			}


			//verificamos si el registro que se solicito no existe, tambien nos redirige a la pagina aldeas/index

			if(!$model->findModel($this->filtrarInt($id)) ){ //si el metodo findModel() no devuelve un registro, quiere decir que ese registro no existe por ende redireccionaremos a la pagina aldeas/index

				$this->redirect("aldea/index");
			}


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Editar Aldea";
			

			if($model->requestPost() && $model->update($id)){


				$this->redirect("aldea/index&ok=22");
						
			}else{

				$this->_view->render("editar", "aldea",[
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{
			$this->redirect("site/index");
		}
	}	


	public function asig_carrera($id)
	{

		if(Session::get("autenticado")){
			Session::accesoEstricto(["2"]);

			$model = new Aldea();
			

			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Asignar Carreras";
			


			if($model->requestPost()){

				$carreras = $_POST["cod_carrera"];

				//validaciones

				if(!$carreras){
					$this->redirect("aldea/index&ok=12");
					exit;
				}


				//fin validaciones


				//verificamos si el registro contiene ya carreras asignadas
				$exists = $model->searchByQuery("select * from aldea_carrera where cod_aldea = $model->cod_aldea");

				//en caso de tener, eliminamos los existentes y mandamos a insertar los nuevos
				if($exists){
					$model->normalQuery("delete from aldea_carrera where cod_aldea =  $model->cod_aldea");
				}

				foreach ($carreras as $row) {

					$model->searchByQuery("select * from proc_insert_aldea_carrera ($model->cod_aldea,$row);");
						
				}

				$this->redirect("aldea/index&ok=11");
						
			}else{
				
				$this->_view->render("asig_carrera", "aldea", [
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{
			$this->redirect("site/index");
		}
	}

	public function view($id){

		if(Session::get("autenticado")){		
			Session::accesoEstricto(["2"]);

			$model = new Aldea();
	 


			if(!$this->filtrarInt($id)){

				$this->redirect("aldea/index");
			}


			//verificamos si el registro que se solicito no existe, tambien nos redirige a la pagina aldeas/index

			if(!$model->findModel($this->filtrarInt($id)) ){
				
				$this->redirect("aldea/index");
			}


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Información detallada de la Aldea";

			$this->_view->render("view", "aldea",[
				"model"=>$model->findModel($this->filtrarInt($id))
			]);
		}else{
			$this->redirect("site/index");
		}
	}

	public function eliminar($id){
		
		if(Session::get("autenticado")){
			Session::acceso("1");

			$model = new Aldea();
			
			if(!$this->filtrarInt($id)){

				$this->redirect("aldea/index");
			}


			if(!$model->findModel($this->filtrarInt($id) )){

				$this->redirect("aldea/index");
			}

			
			$model->normalQuery("delete from aldea where cod_aldea =  $id");
			
			//borrado de relaciones
			$model->normalQuery("delete from aldea_carrera where cod_aldea =  $id");

			$this->redirect("aldea/index&ok=2");
		}else{
			$this->redirect("site/index");
		}
	}



	public function eliminarcarrera($cod_carrera, $cod_aldea){
		
		if(Session::get("autenticado")){
			Session::accesoEstricto(["2"]);

			$model = new Aldea();
			
			$model->normalQuery("delete from aldea_carrera where cod_aldea =  $cod_aldea and cod_carrera = $cod_carrera");

			$this->redirect("aldea/view/$cod_aldea&ok=19");
		}else{
			$this->redirect("site/index");
		}
	}


}

?>