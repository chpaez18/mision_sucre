<?php


/**
* 
*/
class ProfesorController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();
		
	}


	public function index(){

		//verificamos si el usuario se encuentra logueado, si no lo redireccionamos al login
		if(Session::get("autenticado")){
			
			//para ver la gestion de profesores se debe ser rol: coordinador cufm es decir level 1
			Session::acceso("2");

			$model = new Profesor();
			//enviamos parametros a la vista
			$this->_view->titulo = "Listado de Profesores";

			$this->_view->render("index", "profesor",[
				"model"=>$model			
			]);

		}else{
			$this->redirect("site/login");
		}
	}		



	public function nuevo(){

		if(Session::get("autenticado")){
			Session::acceso("2");

			$model = new Profesor();
			$this->_view->titulo = "Nuevo Profesor";


			if($model->requestPost()){

				if($model->validateUnique("ced_profesor", $model->ced_profesor)){
					$this->_view->error = "<b>¡Atención!</b> La cédula <b>$model->ced_profesor</b>, ya se encuentra registrada en el sistema ";
					$this->_view->render("nuevo", "profesor",["model"=>$model]);

					exit;	
				}else{
					$model->save();
				}

				$this->redirect("profesor/index&ok=1");
			}else{

				$this->_view->render("nuevo", "profesor", [
					"model"=>$model
				]);
			}  
		}else{
			$this->redirect("site/login");
		}		
	}

	public function editar($id){

		if(Session::get("autenticado")){
			//el coordinador es el que puede editar la informacion del profesor
			Session::acceso("2");

			$model = new Profesor();

			if(!$this->filtrarInt($id)){

				$this->redirect("profesor/index");
			}


			if(!$model->findModel($this->filtrarInt($id)) ){

				$this->redirect("profesor/index");
			}

			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Editar Profesor";
			

			if($model->requestPost() && $model->update($id)){

				$this->redirect("profesor/index&ok=22");
						
			}else{

				$this->_view->render("editar", "profesor",[
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{
			$this->redirect("site/login");
		}	  
	}


	public function eliminar($id){
		
		if(Session::get("autenticado")){		
			Session::acceso("2");

			$model = new Profesor();
			
			if(!$this->filtrarInt($id)){

				$this->redirect("profesor/index");
			}


			if(!$model->findModel($this->filtrarInt($id) )){
				$this->redirect("profesor/index");
			}

			
			$model->normalQuery("delete from profesor where cod_profesor =  $id");

			//eliminar relaciones
			$model->normalQuery("delete from materia_profesor where cod_profesor =  $id");

			$this->redirect("profesor/index&ok=2");
		}else{
			$this->redirect("site/login");
		}
	}



	

	public function asig_materia($id)
	{

		if(Session::get("autenticado")){
			Session::acceso("2");

			$model = new Profesor();


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Asignar Materias";
			


			if($model->requestPost()){

				$materias = $_POST["cod_materia"];

				//validaciones

				if(!$materias){
					$this->redirect("profesor/index&ok=13");
					exit;
				}


				//fin validaciones



				//verificamos si el registro contiene ya materias asignadas
				$exists = $model->searchByQuery("select * from materia_profesor where cod_profesor = $model->cod_profesor");

				//en caso de tener, eliminamos los existentes y mandamos a insertar los nuevos
				if($exists){
					$model->normalQuery("delete from materia_profesor where cod_profesor =  $model->cod_profesor");
				}


				foreach ($materias as $row) {

					$model->searchByQuery("select * from proc_insert_materia_profesor ($row, $model->cod_profesor);");
				}
				


				$this->redirect("profesor/index&ok=14");
						
			}else{
				
				$this->_view->render("asig_materia", "profesor", [
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{
			$this->redirect("site/login");
		}
	}


	public function view($id){

		if(Session::get("autenticado")){		
			Session::acceso("2");

			$model = new Profesor();

			if(!$this->filtrarInt($id)){

				$this->redirect("profesor/index");
			}


			if(!$model->findModel($this->filtrarInt($id)) ){
				$this->redirect("profesor/index");
			}


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Información Detallada del Profesor";


			$this->_view->render("view", "profesor", [
				"model"=>$model->findModel($this->filtrarInt($id))
			]);
		}else{
			$this->redirect("site/login");
		}
	}

	public function reporte_general(){

		if(Session::get("autenticado")){

			Session::acceso("2");

			$model = new Profesor();
			
			Router::renderPDF("profesor/reporte_general",$model, "reporte_profesores");
		}else{
			$this->redirect("site/login");
		}
	}

}

?>