<?php


/**
* 
*/
class MateriaController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();
		
	}


	public function index(){

		//verificamos si el usuario se encuentra logueado, si no lo redireccionamos al login
		if(Session::get("autenticado")){
			
			Session::accesoEstricto(["1"]);

			$model = new Materia();

			$this->_view->titulo = "Listado de Materias";

			$this->_view->render("index", 'materia',["model"=>$model]);
		}else{
			$this->redirect("site/index");
		}
	}		



	public function nuevo(){

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);

			$model = new Materia();
			$this->_view->titulo = "Nueva Materia";


			if($model->requestPost()){

				if($model->validateUnique("nombre_materia", $model->nombre_materia)){
					$this->_view->error = "<b>¡Atención!</b> La materia <b>$model->nombre_materia</b>, ya se encuentra registrada en el sistema ";
					$this->_view->render("nuevo", "materia",["model"=>$model]);

					exit;	
				}else{
					$model->save();
				}

				$this->redirect("materia/index&ok=1");
				  
			}else{

				$this->_view->render("nuevo", "materia",[
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

			$model = new Materia();

			if(!$this->filtrarInt($id)){

				$this->redirect("materia/index");
			}


			if(!$model->findModel($this->filtrarInt($id)) ){
				$this->redirect("materia/index");
			}


			$this->_view->titulo = "Editar Materia";
			

			if($model->requestPost() && $model->update($id)){


				$this->redirect("materia/index&ok=22");
						
			}else{

				$this->_view->render("editar", "materia",[
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

			$model = new Materia();
			
			if(!$this->filtrarInt($id)){

				$this->redirect("materia/index");
			}


			if(!$model->findModel($this->filtrarInt($id) )){

				$this->redirect("materia/index");
			}

			
			$model->normalQuery("delete from materia where cod_materia =  $id");

			$this->redirect("materia/index&ok=2");
		}else{
			$this->redirect("site/index");
		} 
	}

	


}

?>