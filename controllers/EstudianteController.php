<?php 

/**
* 
*/
class EstudianteController extends Controller
{
	
	public function __construct(){

		parent::__construct();
	}

	public function index(){

		if(Session::get("autenticado")){
			
			Session::accesoEstricto(["1"]);

			$model = new Estudiante();

			$this->_view->titulo = "Listado de Triunfadores(as)";

			$this->_view->render("index", 'estudiante',["model"=>$model]);
		}else{
			$this->redirect("site/index");
		}
	}



	public function actualizar(){

		
		if(Session::get("autenticado")){
			
			Session::acceso("3");

			$model = new Estudiante();


			$id_usuario = Session::get("cod_usuario");
			$resp = $model->searchByQuery("select * from estudiante where usuario_cod_usuario = $id_usuario");
			$id = $resp["cod_estudiante"];
			$this->_view->titulo = "Datos Personales";
		

			if($model->requestPost() && $model->update($id)){

				/*
				$model->normalQuery("update estudiante set inscripcion_formalizada = 'TRUE' where cedula_estudiante = '$model->cedula_estudiante'");
				*/
				
				$this->redirect("site/index&ok=9");
						
			}else{

				$this->_view->render("actualizar", "estudiante",[
					"model"=>$model->findModel($this->filtrarInt($id))
				]);
			}  
		}else{
			$this->redirect("login/index");
		}
	}




	public function view($id){

		if(Session::get("autenticado")){		
			Session::accesoEstricto(["2","1"]);

			$model = new Estudiante();

			if(!$this->filtrarInt($id)){

				$this->redirect("grupo/index");
			}


			if(!$model->findModel($this->filtrarInt($id)) ){

				$this->redirect("grupo/index");
			}


			//en caso de pasar las validaciones, establecemos los parametros a pasar a la vista
			$this->_view->titulo = "Información detallada del Triunfador(a)";

			$this->_view->render("view", "estudiante",[
				"model"=>$model->findModel($this->filtrarInt($id))
			]);
		}else{
			$this->redirect("login/index");
		}
	}



	public function materia($id = false){

		//verificamos si el usuario se encuentra logueado, si no lo redireccionamos al login
		if(Session::get("autenticado")){
			
			Session::accesoEstricto(["2","3"]);

			$model = new Estudiante();

			$this->_view->titulo = "Listado de Materias Inscritas";

			if($id){
				$this->_view->render("materia", 'estudiante',[
					"model"=>$model,
					"id" =>$id
				]);
			}else{
				$this->_view->render("materia", 'estudiante',[
					"model"=>$model
				]);
			}
			

		}else{
			$this->redirect("site/index");
		}
	}	

	public function materia_admin($id = false){

		//verificamos si el usuario se encuentra logueado, si no lo redireccionamos al login
		if(Session::get("autenticado")){
			
			Session::accesoEstricto(["1"]);

			$model = new Estudiante();

			$this->_view->titulo = "Listado de Materias";

			$this->_view->render("materia_admin", 'estudiante',[
					"model"=>$model,
					"id" =>$id
				]);

		}else{
			$this->redirect("site/index");
		}
	}	


	public function seleccion_materia(){

		if(Session::get("autenticado")){
			
			Session::accesoEstricto(["1","2","4"]);

			$model = new Estudiante();

			$this->_view->titulo = "Consulta de Notas";



			if($model->requestPost()){

				$cod_trayecto = $model->cod_trayecto;
				$cod_carrera = $model->cod_carrera;
				$cod_grupo = $model->cod_grupo;
				

				if($model->user()->rol_cod_rol == 4 or $model->user()->rol_cod_rol == 1){
					$ano = $model->ano;
					$cod_aldea = $model->cod_aldea;

					$this->redirect("estudiante/asignar_nota&cod_t=$cod_trayecto&cod_c=$cod_carrera&cod_g=$cod_grupo&ano=$ano&cod_a=$cod_aldea");
				}else{
					$this->redirect("estudiante/asignar_nota&cod_t=$cod_trayecto&cod_c=$cod_carrera&cod_g=$cod_grupo");
				}
				
						
			}else{

				$this->_view->render("seleccion_materia", "estudiante",[
					"model"=>$model
				]);
			}

		}else{
			$this->redirect("site/index");
		}
	}	


	public function asignar_nota(){

		if(Session::get("autenticado")){
			
			Session::accesoEstricto(["1", "2", "4"]);

			$model = new Estudiante();

			$this->_view->titulo = "Carga de Notas";



			if($model->requestPost()){

				//$cod_m = $_POST["cod_m"];
				$cod_t = $_POST["cod_t"];
				$cod_c = $_POST["cod_c"];
				$cod_g = $_POST["cod_g"];


				$cod_materia = $_POST["materia"];
				$estudiante = $_POST["estudiante"];
				$calificacion = $_POST["calificacion"];
				

				$m = 0;
				$y = 0;
				$l = 0;
				$val = [];

				//validacion para que no se ingresen notas mayores a 21 e inferiores a 0
				foreach ($calificacion as $row) {
					if($row > 20.0 or $row <= 0.0){
						$this->_view->error = "<b>!Atención¡</b> Debe establecer una nota comprendida entre 01 y 20";
						$this->_view->render("asignar_nota", "estudiante",["&cod_t"=>$cod_t,"&cod_c"=>$cod_c,"&cod_g"=>$cod_g, "model"=>$model]);
						exit;
					}else{
						$calificaciones[$m] = $row;
						$m = $m+1;
					}
				}


				//recorremos el arreglo de los estudiantes, con el fin de poder guardar en un arreglo el id de los mismos
				foreach ($estudiante as $key) {
					$estudiantes[$y] = $key;
					$y = $y+1;
				}

				foreach ($cod_materia as $key1) {
					$materias[$l] = $key1;
					$l = $l+1;
				}
				
				$cant_estudiantes = count($estudiantes);

				$x = 0;

				//hacemos un ciclo para armar un arreglo asociativo que contendra 2 elementos, el cod_estudiante y su respectiva calificacion
				while ($x < $cant_estudiantes) {
					$val[$x] = ["cod_estudiante" => $estudiantes[$x], "calificacion" => $calificaciones[$x]];
					$x++;
				}

				$cant_elementos = count($val);
				$l = 0;

				$cantidad_materias = count($cod_materia);
				$b = 0;

					while ($b <= $cantidad_materias) {
						$materia = $materias[$b];
						$cal = $calificaciones[$b];
						$estudent = $estudiantes[$b];

						$model->normalQuery("update materia_estudiante set calificacion = $cal where cod_estudiante = $estudent and cod_materia = $materia "
						);
						$b++;
					}


				$this->redirect("estudiante/asignar_nota&cod_t=$cod_t&cod_c=$cod_c&cod_g=$cod_g&ok=27");
			}else{

				$this->_view->render("asignar_nota", "estudiante",[
					"model"=>$model
				]);
			}

		}else{
			$this->redirect("site/index");
		}
	}


	public function formalizar_inscripcion($cod_estudiante){

		if(Session::get("autenticado")){

			Session::accesoEstricto(["1"]);

			$model = new Estudiante();
			
			$model->normalQuery("update estudiante set inscripcion_formalizada = 'TRUE' where cod_estudiante = $cod_estudiante");

			$this->redirect("estudiante/index&ok=31");
			
		}else{
			$this->redirect("site/login");
		}

	}

	public function reporte($cod_t, $cod_c, $cod_g){

		if(Session::get("autenticado")){

			Session::accesoEstricto(["1","2","4"]);

			$model = new Estudiante();
			
			$model->cod_t = $cod_t;
			$model->cod_c = $cod_c;
			$model->cod_g = $cod_g;

			
			Router::renderPDF("estudiante/reporte",$model, "reporte_notas");
		}else{
			$this->redirect("site/login");
		}
	}

	public function getCarrerasDropdown(){
		$model = new Estudiante();

		$id = $_POST["id"];
		$registros = $model->searchArrayByQuery("select c.cod_carrera, c.nombre_carrera from carrera c, trayecto_carrera tc where tc.cod_carrera = c.cod_carrera and tc.cod_trayecto = $id");
		$x = 0;
		$html = "<option value='0'>Seleccione una carrera</option>";
		$cant = count($registros);

		while ($x < $cant) {
			$html .= "<option value='".$registros[$x]["cod_carrera"]."'>".$registros[$x]["nombre_carrera"]."</option>";
			$x++;
		}
		
		if($registros){
			echo $html;
		}else{
			return false;
		}
	}	

	public function getGruposDropdown(){
		$model = new Estudiante();

		$id = $_POST["id"];
		$registros = $model->searchArrayByQuery("select cod_grupo, nombre from grupo where id_carrera = $id");
		$x = 0;
		$html = "<option value='0'>Seleccione un grupo</option>";
		$cant = count($registros);

		while ($x < $cant) {
			$html .= "<option value='".$registros[$x]["cod_grupo"]."'>".$registros[$x]["nombre"]."</option>";
			$x++;
		}
		
		if($registros){
			echo $html;
		}else{
			return false;
		}
	}
}

?>