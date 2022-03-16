<?php


/**
* 
*/
class GrupoController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();
		
	}


	public function index(){

		if(Session::get("autenticado")){
			
			Session::acceso("2");


			$model = new Grupo();


			$this->_view->titulo = "Listado de Grupos";

			$this->_view->render("index", 'grupo',["model"=>$model]);
		}else{
			$this->redirect("site/index");
		}
	}	

	


	public function nuevo(){

		if(Session::get("autenticado")){
			Session::acceso("2");


			$model = new Grupo();
			$this->_view->titulo = "Nuevo Grupo";


			if($model->requestPost()){

				$validate= $model->searchArrayByQuery("select * from grupo where nombre = '$model->nombre' and id_carrera = $model->id_carrera");
				if($validate !=0){
					$id_carrera = $validate[0]["id_carrera"];
					
					if($id_carrera == $model->id_carrera){
						$this->_view->error = "<b>¡Atención!</b> El grupo <b>$model->nombre</b>, ya se encuentra registrado(a) en la carrera seleccionada, por favor verifique la información.";
						$this->_view->render("nuevo", "grupo",["model"=>$model]);

						exit;	
					}else{
						$model->save();
					}
				}

				$this->redirect("grupo/index&ok=1");
				  
			}else{

				$this->_view->render("nuevo", "grupo",[
					"model"=>$model
				]);
			} 
		}else{
			$this->redirect("site/index");
		}
	}	


/*
	public function nuevo_2(){

		if(Session::get("autenticado")){
			Session::accesoEstricto(["2"]);

			$model = new Grupo();
			$this->_view->titulo = "Nuevo Grupo";


			if($model->requestPost()){

				$carreras = $_POST["cod_carrera"];

				if(!$carreras){
					$this->redirect("grupo/index&ok=13");
					exit;
				}


				$model->normalQuery("insert into grupo (nombre, capacidad) values ('$model->nombre', $model->capacidad)");

				$last = $model->searchByQueryOne("select * from grupo ORDER BY cod_grupo desc limit 1");
				$cod_grupo = $last->cod_grupo;

				foreach ($carreras as $row) {
						
					$model->searchByQuery("select * from proc_insert_carrera_grupo ($row, $cod_grupo);");
				}

				$this->_view->mensaje = "Registro agregado con éxito";

				$this->_view->render("index","grupo", [
					"model"=>$model
				]);


			}else{

				$this->_view->render("nuevo_2", "grupo",[
					"model"=>$model
				]);
			} 
		}else{
			$this->redirect("site/index");
		}
	}
*/


	public function editar($id){
		if(Session::get("autenticado")){
			Session::acceso("2");


			$model = new Grupo();

			if(!$this->filtrarInt($id)){

				$this->redirect("grupo/index");
			}


			if(!$model->findModel($this->filtrarInt($id)) ){
				$this->redirect("grupo/index");
			}


			$this->_view->titulo = "Editar Grupo";
			

			if($model->requestPost() && $model->update($id)){
				
				$this->redirect("grupo/index&ok=22");			
			}else{

				$this->_view->render("editar", "grupo",[
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{
			$this->redirect("site/index");
		}  
	}

	public function eliminar($id){

		if(Session::get("autenticado")){		
			Session::acceso("2");


			$model = new Grupo();
			
			if(!$this->filtrarInt($id)){

				$this->redirect("grupo/index");
			}

			if(!$model->findModel($this->filtrarInt($id) )){

				$this->redirect("grupo/index");
			}
			
			$model->normalQuery("delete from grupo where cod_grupo =  $id");

			//eliminar relaciones

			$model->normalQuery("delete from grupo_estudiante where cod_grupo =  $id");

			$this->redirect("grupo/index&ok=2");
		}else{
			$this->redirect("site/index");
		}
	}	


	public function view($id){

		if(Session::get("autenticado")){		
			Session::acceso("2");


			$model = new Grupo();


			if(!$this->filtrarInt($id)){

				$this->redirect("grupo/index");
			}

			if(!$model->findModel($this->filtrarInt($id)) ){
				
				$this->redirect("grupo/index");
			}


			$this->_view->titulo = "Información detallada del Grupo";

			$this->_view->render("view", "grupo",[
				"model"=>$model->findModel($this->filtrarInt($id))
			]);
		}else{
			$this->redirect("site/index");
		}
	}


	public function asig_estudiante($id)
	{

		if(Session::get("autenticado")){
			Session::acceso("2");


			$model = new Grupo();

			$this->_view->titulo = "Asignar Triunfadores(as)";


			if($model->requestPost()){

				$estudiantes = $_POST["cod_estudiante"];

				$cant_estudiantes = count($estudiantes);
				$reg = $model->findModel($this->filtrarInt($id));

				if($cant_estudiantes > $reg->capacidad){
					$this->redirect("grupo/asig_estudiante/$id&ok=30");
				}
				//validaciones

				if(!$estudiantes){
					$this->redirect("grupo/index&ok=16");
					exit;
				}


				//fin validaciones


				$exists = $model->searchByQuery("select * from grupo_estudiante where cod_grupo = $model->cod_grupo");

				if($exists){
					$model->normalQuery("delete from grupo_estudiante where cod_grupo =  $model->cod_grupo");
				}

				foreach ($estudiantes as $row) {

					$model->searchByQuery("select * from proc_insert_grupo_estudiante ($model->cod_grupo,$row);");

					$reg = $model->searchArrayByQuery("(SELECT cm.cod_materia 
						FROM carrera_materia cm 
						JOIN carrera c ON cm.cod_carrera = c.cod_carrera
						JOIN grupo g ON g.id_carrera = c.cod_carrera
						WHERE g.cod_grupo = $model->cod_grupo)");
					$cant_reg = count($reg);


					$x = 0;
					while ($x <= $cant_reg) {
						$materia = $reg[$x]["cod_materia"];
						$model->normalQuery("select proc_insert_materia_estudiante($row,$materia, 0)"
						);
						$x++;
					}
				}
				


				$this->redirect("grupo/index&ok=17");
						
			}else{
				
				$this->_view->render("asig_estudiante", "grupo", [
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{
			$this->redirect("site/index");
		}
	}


	public function asig_materia($id)
	{

		if(Session::get("autenticado")){
			Session::acceso("2");

			$model = new Grupo();


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Asignar Materias";
			


			if($model->requestPost()){

				$cod_grupo = $id;
				$cod_materia = $model->cod_materia;
				$cod_trayecto = $model->cod_trayecto;
				$ano = $model->ano;
				$periodo = $ano. "MS" . $model->periodo;

				$resp = $model->searchByQueryOne("select id_carrera from grupo where cod_grupo = $cod_grupo");
				if(!$resp){
					$this->redirect("grupo/index&ok=33");
				}
				$cod_carrera = $resp->id_carrera;

				$model->normalQuery("select proc_insert_trayecto_carrera($cod_trayecto, $cod_carrera, '$periodo', $ano) ");

				$model->normalQuery("select proc_insert_carrera_materia($cod_materia, $cod_carrera) ");

				//validaciones

				if(!$materias){
					$this->redirect("grupo/index&ok=1");
					exit;
				}

				//fin validaciones

			}else{
				
				$this->_view->render("asig_materia", "grupo", [
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}
		}else{
			$this->redirect("site/login");
		}
	}


	public function eliminardelgrupo($cod_estudiante, $cod_grupo){
		
		if(Session::get("autenticado")){
			Session::acceso("2");


			$model = new Grupo();
			
			$model->normalQuery("delete from grupo_estudiante where cod_estudiante = $cod_estudiante and cod_grupo = $cod_grupo");

			$model->normalQuery("delete from materia_estudiante where cod_estudiante = $cod_estudiante");


			$this->redirect("grupo/view/$cod_grupo&ok=18");
		}else{
			$this->redirect("site/index");
		}
	}


	public function reporte(){

		if(Session::get("autenticado")){

			Session::acceso("2");


			$model = new Grupo();
			
			Router::renderPDF("grupo/reporte",$model, "reporte_grupos");
		}else{
			$this->redirect("site/login");
		}
	}

}

?>