<?php 
/**
* 
*/
class CarreraController extends Controller
{
	
	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();
	}


	public function index(){

		//verificamos si el usuario se encuentra logueado, si no lo redireccionamos al login
		if(Session::get("autenticado")){
			
			Session::accesoEstricto(["1"]);

			$model = new Carrera();


			$this->_view->titulo = "Listado de Carreras";

			$this->_view->render("index", 'carrera',[
				"model"=>$model
			]);
		}else{

			$this->redirect("site/index");
		}
	}


	public function nuevo(){
		
		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);

			$model = new Carrera();

			$this->_view->titulo = "Nueva Carrera";


			if($model->requestPost()){

				if($model->validateUnique("nombre_carrera", $model->nombre_carrera)){
					$this->_view->error = "<b>¡Atención!</b> La carrera <b>$model->nombre_carrera</b>, ya se encuentra registrada en el sistema ";
					$this->_view->render("nuevo", "carrera",["model"=>$model]);

				exit;	
				}else{
					$model->save();
				}

				$this->redirect("carrera/index&ok=1");
				  
				
			}else{

				$this->_view->render("nuevo", "carrera", [
					"model"=>$model
				]);
			}  
		}else{

			$this->redirect("site/index");
		}		
	}


	public function editar($id){

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);

			$model = new Carrera();

			if(!$this->filtrarInt($id)){

				$this->redirect("carrera/index");
			}


			if(!$model->findModel($this->filtrarInt($id)) ){

				$this->redirect("carrera/index");
			}


			$this->_view->titulo = "Editar Carrera";
			

			if($model->requestPost() && $model->update($id) ){

				$this->redirect("carrera/index&ok=22");
						
			}else{

				$this->_view->render("editar", "carrera",[
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}  
		}else{

			$this->redirect("site/index");
		}
	}


	public function eliminar($id){
		
		if(Session::get("autenticado")){
			Session::acceso("1");

			$model = new Carrera();
			
			if(!$this->filtrarInt($id)){

				$this->redirect("carrera/index");
			}


			if(!$model->findModel($this->filtrarInt($id) )){

				$this->redirect("carrera/index");
			}

			
			$model->normalQuery("delete from carrera where cod_carrera =  $this->filtrarInt($id)");
			
			//borrado de relaciones
			
			$model->normalQuery("delete from carrera_materia where cod_carrera =  $this->filtrarInt($id)");

			$this->redirect("carrera/index&ok=2");
		}else{

			$this->redirect("site/index");
		}
	}



	public function asig_materia($id)
	{

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);

			$model = new Carrera();


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Asignar Materias";
			


			if($model->requestPost()){

				$materias = $_POST["cod_materia"];


				//validaciones

				if(!$materias){
					$this->redirect("carrera/index&ok=13");
					exit;
				}


				//fin validaciones

				//verificamos si el registro contiene ya materias asignadas
				$exists = $model->searchByQuery("select * from carrera_materia where cod_carrera = $model->cod_carrera");

				//en caso de tener, eliminamos los existentes y mandamos a insertar los nuevos
				if($exists){
					$model->normalQuery("delete from carrera_materia where cod_carrera =  $model->cod_carrera");
				}

				foreach ($materias as $row) {

					$model->normalQuery("select * from proc_insert_carrera_materia ($row, $model->cod_carrera);");
					
				}
				


				$this->redirect("carrera/index&ok=14");
						
			}else{
				
				$this->_view->render("asig_materia", "carrera", [
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{

			$this->redirect("site/index");
		}
	}


/*
	public function asig_grupo($id)
	{

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);

			$model = new Carrera();

			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Asignar Grupo";
			


			if($model->requestPost()){

				$grupos = $_POST["cod_grupo"];


				//validaciones

				if(!$grupos){
					$this->redirect("carrera/index&ok=13");
					exit;
				}


				//fin validaciones



				//verificamos si el registro contiene ya grupos asignados
				$exists = $model->searchByQuery("select * from carrera_grupo where cod_carrera = $model->cod_carrera");

				//en caso de tener, eliminamos los existentes y mandamos a insertar los nuevos
				if($exists){
					$model->normalQuery("delete from carrera_grupo where cod_carrera =  $model->cod_carrera");
				}

				foreach ($grupos as $row) {
						
					$model->searchByQuery("select * from proc_insert_carrera_grupo ($model->cod_carrera,$row);");
				}
				


				$this->redirect("carrera/index&ok=15");
						
			}else{
				
				$this->_view->render("asig_grupo", "carrera", [
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{

			$this->redirect("site/index");
		}
	}
*/

	public function view($id){

		if(Session::get("autenticado")){		
			Session::accesoEstricto(["1"]);

			$model = new Carrera();

			if(!$this->filtrarInt($id)){

				$this->redirect("carrera/index");
			}


			if(!$model->findModel($this->filtrarInt($id)) ){
				$this->redirect("carrera/index");
			}


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Información Detallada de la Carrera";


				$this->_view->render("view", "carrera", [
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
		}else{

			$this->redirect("site/index");
		}
	}




	public function eliminarmateria($cod_materia, $cod_carrera){
		
		if(Session::get("autenticado")){
			Session::acceso("1");

			$model = new Carrera();
			
			$model->normalQuery("delete from carrera_materia where cod_materia = $cod_materia and cod_carrera = $cod_carrera");

			$this->redirect("carrera/view/$cod_carrera&ok=20");
		}else{

			$this->redirect("site/index");
		}
	}	

/*
	public function eliminargrupo($cod_grupo, $cod_carrera){

		if(Session::get("autenticado")){
			Session::acceso("1");

			$model = new Carrera();
			
			$model->normalQuery("delete from carrera_grupo where cod_grupo = $cod_grupo and cod_carrera = $cod_carrera");

			$this->redirect("carrera/view/$cod_carrera&ok=21");
		}else{

			$this->redirect("site/index");
		}
	}
*/

}

?>