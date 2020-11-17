<?php 

/**
* 
*/
class CoordinadorController extends Controller
{
	
	public function __construct(){

		parent::__construct();
	}


	public function index(){

		if(Session::get("autenticado")){
			
			Session::accesoEstricto(["1"]);

			$model = new Coordinador();

			$this->_view->titulo = "Listado de Coordinadores";


			$this->_view->render("index", 'coordinador',["model"=>$model]);
		}else{
			$this->redirect("site/index");
		}
	}


	public function nuevo(){

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);

			$model = new Coordinador();

			$this->_view->titulo = "Nuevo Coordinador";

			if($model->requestPost()){
				
				$nombre_coordinador = Utilities::cleanString($model->nombre_coordinador);

				$apellido_coordinador = Utilities::cleanString($model->apellido_coordinador);


				$model->nombre_coordinador = $nombre_coordinador;
				$model->apellido_coordinador = $apellido_coordinador;

				if($model->validateUnique("ced_coordinador", $model->ced_coordinador)){
					$this->_view->error = "<b>¡Atención!</b> La cédula <b>$model->ced_coordinador</b>, ya se encuentra registrada en el sistema ";
					$this->_view->render("nuevo", "coordinador",["model"=>$model]);

				exit;	
				}else{
					
				


				$nom_user = substr($model->nombre_coordinador,0,1)."".$model->apellido_coordinador;
				$nombre_usuario =  strtolower($nom_user);

				$reg = $model->searchArrayByQuery("select * from usuario where nom_usuario = '$nombre_usuario' ");
				if($reg){

					$id_aux = $reg[0]["cod_usuario"];
					$nombre_usuario = $nombre_usuario."".$id_aux;
					$clave = Hash::getHash("sha1", "123456", HASH_KEY);

					$model->normalQuery("insert into usuario (nom_usuario, pass_usuario, rol_cod_rol) values ('$nombre_usuario', '$clave', 2)");
					$usuario = $model->searchByQueryOne("select * from usuario ORDER BY cod_usuario desc limit 1");

					$id_usuario = $usuario->cod_usuario;

				}else{
					$clave = Hash::getHash("sha1", "123456", HASH_KEY);

					$model->normalQuery("insert into usuario (nom_usuario, pass_usuario, rol_cod_rol) values ('$nombre_usuario', '$clave', 2)");

					$usuario = $model->searchByQueryOne("select * from usuario ORDER BY cod_usuario desc limit 1");

					$id_usuario = $usuario->cod_usuario;
				}
				



/////////////////CREACION DE USUARIO EN BASE DE DATOS PARA AUDITORIA//////////////////////////////////

				//creamos un usuario en base de datos
				$model->normalQuery("CREATE USER $nombre_usuario WITH LOGIN PASSWORD '123456' ");
				//alteramos el usuario para asignarle permisos de superusuario
				$model->normalQuery("ALTER USER $nombre_usuario WITH superuser");
				//asignamos al usuario permisos para loguearse
				$model->normalQuery("ALTER USER $nombre_usuario WITH login");

/////////////////CREACION DE USUARIO EN BASE DE DATOS PARA AUDITORIA//////////////////////////////////


				$model->normalQuery("insert into coordinador (ced_coordinador, nombre_coordinador, apellido_coordinador, aldea_cod_aldea, usuario_cod_usuario) values ($model->ced_coordinador, '$model->nombre_coordinador', '$model->apellido_coordinador', $model->aldea_cod_aldea, $id_usuario)");

				$this->_view->mensaje = "Coordinador registrado con éxito!, el nombre de usuario definido es: <b>$usuario->nom_usuario</b> y la contraseña por defecto es: <b>'123456'</b>";

				$this->_view->render("index", "coordinador",[
					"model"=>$model
				]);
				}
				//$this->redirect("coordinador/index&ok=26");
			}else{

				$this->_view->render("nuevo", "coordinador", [
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

			$model = new Coordinador();
			
			if(!$this->filtrarInt($id)){

				$this->redirect("coordinador/index");
			}


			if(!$model->findModel($this->filtrarInt($id)) ){ 
				$this->redirect("coordinador/index");
			}


			$this->_view->titulo = "Editar Coordinador";
			

			if($model->requestPost() && $model->update($id)){

				$this->redirect("coordinador/index&ok=22");			
			}else{

				$this->_view->render("editar", "coordinador",[
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

			$model = new Coordinador();
			
			if(!$this->filtrarInt($id)){

				$this->redirect("coordinador/index");
			}


			if(!$model->findModel($this->filtrarInt($id) )){

				$this->redirect("coordinador/index");
			}

			//borrado de relaciones
			$usuario = $model->searchByQueryOne("select * from coordinador where cod_coordinador =  $id");

			$id_usuario = $usuario->usuario_cod_usuario;

			//hacemos una consulta para traer el nombre de usuario
			$reg = $model->searchByQueryOne("select * from usuario where cod_usuario =  $id_usuario");
			$nom_usuario = $reg->nom_usuario;

			$model->normalQuery("DROP USER $nom_usuario");

			$model->normalQuery("delete from coordinador where cod_coordinador =  $id");

			$model->normalQuery("delete from usuario where cod_usuario =  $id_usuario");

			

			$this->redirect("coordinador/index&ok=2");
		}else{
			$this->redirect("site/index");
		} 
	}


	public function registrarCedula(){

		if(Session::get("autenticado")){	
			Session::acceso("2");

			$model = new Coordinador();
			
			$this->_view->titulo = "Registrar Triunfador(a)";

			if($model->requestPost()){


				//validaciones

				if(!$model->cedula){
					$this->_view->error = "Por favor, debe introducir un número de cédula";
					$this->_view->render("registrarCedula","coordinador");
					exit;
				}					

				if(!$model->correo){
					$this->_view->error = "Por favor, debe introducir un correo electrónico";
					$this->_view->render("registrarCedula","coordinador");
					exit;
				}	

				//fin validaciones

						
				if(!$model->registrarCI($model->nac, $model->cedula,$model->correo) ){

					$this->redirect("coordinador/registrarCedula&ok=10");
				}else{

					$id = $model->user()->cod_usuario;
					$registros = $model->searchArrayByQuery("select * from coordinador where usuario_cod_usuario = $id");
					$cod_aldea = $registros[0]["aldea_cod_aldea"];
					$reg = $model->searchArrayByQuery("select * from aldea where cod_aldea = $cod_aldea");
					$nombre_aldea = $reg[0]["nombre_aldea"];

    				$nombre = $registros[0]["nombre_coordinador"] . " " . $registros[0]["apellido_coordinador"];

					$mensaje = "Estimado triunfador, <br> El Coordinador de la Aldea $nombre_aldea adscrita a la Misión Sucre ha registrado satisfactoriamente su número de cédula, para culminar con el proceso de inscripción. <br> Es necesario que ingrese al siguiente link: <b>http://".$_SERVER["SERVER_NAME"]."/".FOLDER."/index.php?url=site/verificarEstudiante </b> con el fin de que verifique su número de cédula, y proceda con el registro de su cuenta de usuario.
					<br>
					<br>
					Para formalizar el proceso de inscripción es necesario consignar ante la Coordinación de Misión Sucre del Colegio Universitario Francisco de Miranda, ubicado en Esquina Mijares Con Calle Norte 3, Carmelitas, Parroquia Altagracia, Municipio Libertador, Distrito Capital, Venezuela. <br>

					La siguiente información  con vista a los originales en un CD-ROM con la digitalización en original (formato JPG) de los documentos que a continuación se solicitan:

					<ol>
						<li>Cédula de Identidad </li>
						<li>Partida de Nacimiento</li>
						<li>Certificado de Participación del SNI- RUSNIES (CNU-OPSU)</li>
						<li>Título de Bachiller</li>
						<li>Notas Certificadas Básica y Diversificadas</li>
						<li>Inscripción Militar</li>
						<li>Carnet o Certificado de Discapacidad</li>
						<li>Certificado de Salud</li>
					</ol>
					<br>
					Agradeciendo su atención, un saludo.";

					$model->sendMail($model->correo, "Culminar proceso de inscripción Misión Sucre", $mensaje);

					$this->redirect("site/index&ok=3");

				}

				
						
			}else{

				$this->_view->render("registrarCedula", "coordinador");
			}
		}else{
			$this->redirect("site/index");
		}   
	}


	public function cargar_nota($cod_materia, $cod_estudiante){

		if(Session::get("autenticado")){
			Session::accesoEstricto(["2"]);

			$model = new Coordinador();

			if(!$this->filtrarInt($cod_materia)){

				$this->redirect("site/index");
			}			

			if(!$this->filtrarInt($cod_estudiante)){

				$this->redirect("site/index");
			}


			$estudiante = $model->searchByQueryOne("select * from estudiante where cod_estudiante = $cod_estudiante");

			$materia = $model->searchByQueryOne("select * from materia where cod_materia = $cod_materia");
			

			$this->_view->titulo = "Materia: ".$materia->nombre_materia." | Alumno: ".$estudiante->nombre_estudiante." ".$estudiante->apellido_estudiante;
			

			if($model->requestPost()){
				
				//verificamos si el alumno tiene ya cargada una calificacion en la materia x
				$materia_calificacion = $model->searchArrayByQuery("select * from materia_estudiante where cod_estudiante = $cod_estudiante and cod_materia = $cod_materia");

				if($materia_calificacion){

					if($model->calificacion > 20.0 or $model->calificacion <= 0.0){
						$this->_view->error = "<b>!Atención¡</b> Debe establecer una nota comprendida entre 01 y 20";
						$this->_view->render("cargar_nota", "coordinador",["/"=>$cod_materia,"/"=>$cod_estudiante]);
					}else{
						$model->normalQuery("update materia_estudiante set calificacion = $model->calificacion where cod_estudiante = $cod_estudiante and cod_materia = $cod_materia");

						
						if($model->user()->rol_cod_rol == 1){
								$this->redirect("estudiante/materia_admin/$cod_estudiante&ok=28");
							}else{
								$this->redirect("estudiante/materia/$cod_estudiante&ok=28");
							}
					}
					
				}else{

					if($model->calificacion > 20.0 or $model->calificacion <= 0.0){
						$this->_view->error = "<b>!Atención¡</b> Debe establecer una nota comprendida entre 01 y 20";
						$this->_view->render("index", "grupo");
					}else{
							$model->normalQuery("select * from proc_insert_materia_estudiante ($cod_materia, $cod_estudiante, $model->calificacion);");

							$this->_view->mensaje = "Calificación Cargada con Éxito!.";
							if($model->user()->rol_cod_rol == 1){
								$this->redirect("estudiante/materia_admin/$cod_estudiante&ok=27");
							}else{
								$this->redirect("estudiante/materia/$cod_estudiante&ok=27");
							}
							
					}
					
				}

			}else{

				$this->_view->render("cargar_nota", "coordinador");
			}
		}else{
			$this->redirect("site/index");
		}  
	}


	public function eliminar_nota($cod_materia, $cod_estudiante){

		if(Session::get("autenticado")){	
			Session::accesoEstricto(["2"]);

			$model = new Coordinador();
			
			if(!$this->filtrarInt($cod_materia)){

				$this->redirect("site/index");
			}			

			if(!$this->filtrarInt($cod_estudiante)){

				$this->redirect("site/index");
			}


			$model->normalQuery("delete from materia_estudiante where cod_estudiante =  $cod_estudiante and cod_materia = $cod_materia");

			

			
			if($model->user()->rol_cod_rol == 1){
				$this->redirect("estudiante/materia_admin/$cod_estudiante&ok=29");
			}else{
				$this->redirect("estudiante/materia/$cod_estudiante&ok=29");
			}
		}else{
			$this->redirect("site/index");
		} 
	}

}

?>