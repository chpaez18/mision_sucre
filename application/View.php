<?php 


/**
* 
*/

class View 
{
	
	private $_controlador;

	public function __construct(Request $peticion){

		$this->_controlador = $peticion->getControlador();
	}	


	//metodo que renderiza las vistas
	public function render($vista, $item = false, $vars =[]){
		$model = new Site();

		    if(Session::get("level") == 1){
		      $ruta_archivo = "manuales/Manual Usuario Rol-Coordinador CUFM.pdf";
		    }elseif(Session::get("level") == 2){
		      $ruta_archivo = "manuales/Manual Usuario Rol-Coordinador ALDEA.pdf";
		    }elseif(Session::get("level") == 3) {
		      $ruta_archivo = "manuales/Plantilla Manual Usuario Rol-Triunfador.pdf";
		    }elseif(Session::get("level") == 4){
		      $ruta_archivo = "manuales/Plantilla Manual Usuario Rol-Control de Estudios CUFM.pdf";
		    }

		$_layoutParams = array(

		


			'ruta_css' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/css/",
			'ruta_img' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/img/",
			'ruta_js' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/js/",
			'ruta_lib' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/lib/",
			'ruta_font_awesome' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/font-awesome/css/"
		);
		
		//foreach que por cada variable que venga, le sacamos la clave y el valor
		foreach ($vars as $key => $value) {
			$$key = $value;   //instanciamos una variable con el valor, para instanciar variables se usa 2 veces el $, $$key
		}

		//variable que contiene todas las opciones del menu

		if(Session::get("autenticado")){

				if(Session::get("level") == 1){


							$menu = [

										[
										'id'=>'inicio',
										'titulo'=>'Inicio',
										'enlace' => ROUTER::create_action_url("site/index")

										],			

										[
											'id'=>'gestion',
											'titulo'=>'Gestión',
											'items' => [
															[
																'titulo'=>'Ejes',
																'enlace'=>ROUTER::create_action_url("zona/index"),
															],

															[
																'titulo'=>'Aldeas',
																'enlace'=>ROUTER::create_action_url("aldea/index"),
															],							
															[
																'titulo'=>'Coordinadores',
																'enlace'=>ROUTER::create_action_url("coordinador/index"),
															],								

															[
																'titulo'=>'Materias',
																'enlace'=>ROUTER::create_action_url("materia/index"),
															],															
																						
															[
																'titulo'=>'Carreras',
																'enlace'=>ROUTER::create_action_url("carrera/index"),
															],																														
															[
																'titulo'=>'Triunfadores(as)',
																'enlace'=>ROUTER::create_action_url("estudiante/index"),
															],

														], 
										],

										[
											'id'=>'notas',
											'titulo'=>"Notas",
											'items'=>[
															[
																'titulo'=>'Consultar',
																'enlace'=>ROUTER::create_action_url("estudiante/seleccion_materia"),
															],

															[
																'id'=>'habilitar',
																'titulo'=>"Habilitar carga",
																'enlace' => ROUTER::create_action_url("site/habilitar_carga_notas")

															],										
															[
																'id'=>'deshabilitar',
																'titulo'=>"Deshabilitar carga",
																'enlace' => ROUTER::create_action_url("site/desabilitar_carga_notas")

															],										
											]
										],

										
										[
											'id'=>'usuario',
											'titulo'=>'Usuario',
											'items' => [
															[
																'titulo'=>'Actualizar Contraseña',
																'enlace'=>ROUTER::create_action_url("site/actualizar_contra_1", [Session::get("cod_usuario")]),
															],
															[
																'titulo'=>'Actualizar Información',
																'enlace'=>ROUTER::create_action_url("usuarios/actualizar_info", [Session::get("cod_usuario")]),
															],

													], 
										],
																			
										[
											'id'=>'Manual',
											'titulo'=>"Manual de Usuario",
											'enlace'=>"$ruta_archivo",

										],										

										[
											'id'=>'cerrar',
											'titulo'=>'Cerrar Sesión ('.Session::get("usuario").")",
											'enlace' => ROUTER::create_action_url("site/cerrar")

										],


									];

									if($model->user()->first_login){
										$menu = [
																					[
											'id'=>'usuario',
											'titulo'=>'Usuario',
											'items' => [
															[
																'titulo'=>'Actualizar Contraseña',
																'enlace'=>ROUTER::create_action_url("site/actualizar_contra", [Session::get("cod_usuario")]),
															],
															[
																'titulo'=>'Actualizar Información',
																'enlace'=>ROUTER::create_action_url("usuarios/actualizar_info", [Session::get("cod_usuario")]),
															],

													], 
										],

										[
											'id'=>'Manual',
											'titulo'=>"Manual de Usuario",
											'enlace'=>"$ruta_archivo",

										],																			
										[
											'id'=>'cerrar',
											'titulo'=>'Cerrar Sesión ('.Session::get("usuario").")",
											'enlace' => ROUTER::create_action_url("site/cerrar")

										],
										];
									}

						}else if(Session::get("level") == 2){

							$menu = [

									[
										'id'=>'inicio',
										'titulo'=>'Inicio',
										'enlace' => ROUTER::create_action_url("site/index")

									],


									[
										'id'=>'pre-inscribir',
										'titulo'=>'Pre-Inscripción',
										'items' => [
														[
															'titulo'=>'Registrar Triunfador(a)',
															'enlace'=>ROUTER::create_action_url("coordinador/registrarCedula"),
														],

												], 
											   

									],

									[
										'titulo'=>'Aldeas',
										'enlace'=>ROUTER::create_action_url("aldea/index"),
									],									

									[
										'titulo'=>'Grupos',
										'enlace'=>ROUTER::create_action_url("grupo/index"),
									],

									[
										'id'=>'notas',
										'titulo'=>"Notas",
										'enlace' => ROUTER::create_action_url("estudiante/seleccion_materia")

									],

									[
										'titulo'=>'Profesores',
										'enlace'=>ROUTER::create_action_url("profesor/index"),
									],

									[
										'id'=>'usuario',
										'titulo'=>'Usuario',
										'items' => [
														[
															'titulo'=>'Actualizar Contraseña',
															'enlace'=>ROUTER::create_action_url("site/actualizar_contra", [Session::get("cod_usuario")]),
														],
														[
																'titulo'=>'Actualizar Información',
																'enlace'=>ROUTER::create_action_url("usuarios/actualizar_info", [Session::get("cod_usuario")]),
															],

												], 
									],

										[
											'id'=>'Manual',
											'titulo'=>"Manual de Usuario",
											'enlace'=>"$ruta_archivo",

										],
				 					[
										'id'=>'cerrar',
										'titulo'=>'Cerrar Sesión ('.Session::get("usuario").")",
										'enlace' => ROUTER::create_action_url("site/cerrar")

									],

							];

							if($model->user()->first_login){
										$menu = [
																					[
											'id'=>'usuario',
											'titulo'=>'Usuario',
											'items' => [
															[
																'titulo'=>'Actualizar Contraseña',
																'enlace'=>ROUTER::create_action_url("site/actualizar_contra", [Session::get("cod_usuario")]),
															],
															[
																'titulo'=>'Actualizar Información',
																'enlace'=>ROUTER::create_action_url("usuarios/actualizar_info", [Session::get("cod_usuario")]),
															],

													], 
										],

										[
											'id'=>'Manual',
											'titulo'=>"Manual de Usuario",
											'enlace'=>"$ruta_archivo",

										],																			
										[
											'id'=>'cerrar',
											'titulo'=>'Cerrar Sesión ('.Session::get("usuario").")",
											'enlace' => ROUTER::create_action_url("site/cerrar")

										],
										];
									}

						}else if(Session::get("level") == 3){


							$menu = [

								[
										'id'=>'inicio',
										'titulo'=>'Inicio',
										'enlace' => ROUTER::create_action_url("site/index")

								],								


									[
										'id'=>'pre-inscribir',
										'titulo'=>'Pre-Inscripción',
										'items' => [
														[
															'titulo'=>'Datos Personales',
															'enlace'=>ROUTER::create_action_url("estudiante/actualizar"),
														],

												], 
											   

									],
									[
									'id'=>'materia',
									'titulo'=>'Materias',
									'enlace' => ROUTER::create_action_url("estudiante/materia")

									],

								[

											'id'=>'usuario',
											'titulo'=>'Usuario',
											'items' => [
															[
																'titulo'=>'Actualizar Contraseña',
																'enlace'=>ROUTER::create_action_url("site/actualizar_contra", [Session::get("cod_usuario")]),
															],
															[
																'titulo'=>'Actualizar Información',
																'enlace'=>ROUTER::create_action_url("usuarios/actualizar_info", [Session::get("cod_usuario")]),
															],

													], 
													],									

						
										[
											'id'=>'Manual',
											'titulo'=>"Manual de Usuario",
											'enlace'=>"$ruta_archivo",

										],

				 				[
										'id'=>'cerrar',
										'titulo'=>'Cerrar Sesión ('.Session::get("usuario").")",
										'enlace' => ROUTER::create_action_url("site/cerrar")

								],

							];

							if(!$model->user()->first_login){
										$menu = [
																					[
											'id'=>'usuario',
											'titulo'=>'Usuario',
											'items' => [
															[
																'titulo'=>'Actualizar Contraseña',
																'enlace'=>ROUTER::create_action_url("site/actualizar_contra", [Session::get("cod_usuario")]),
															],
															[
																'titulo'=>'Actualizar Información',
																'enlace'=>ROUTER::create_action_url("usuarios/actualizar_info", [Session::get("cod_usuario")]),
															],

													], 
										],

										[
											'id'=>'Manual',
											'titulo'=>"Manual de Usuario",
											'enlace'=>"$ruta_archivo",

										],																			
										[
											'id'=>'cerrar',
											'titulo'=>'Cerrar Sesión ('.Session::get("usuario").")",
											'enlace' => ROUTER::create_action_url("site/cerrar")

										],
										];
									}

						}else if(Session::get("level") == 4){

							$menu = [

								[
										'id'=>'inicio',
										'titulo'=>'Inicio',
										'enlace' => ROUTER::create_action_url("site/index")

								],								


								[
										'id'=>'notas',
										'titulo'=>'Notas',
										'enlace' => ROUTER::create_action_url("estudiante/seleccion_materia")

								],

										[
											'id'=>'Manual',
											'titulo'=>"Manual de Usuario",
											'enlace'=>"$ruta_archivo",

										],
				 				[
										'id'=>'cerrar',
										'titulo'=>'Cerrar Sesión ('.Session::get("usuario").")",
										'enlace' => ROUTER::create_action_url("site/cerrar")

								],

							];

						}

		}else{
			$menu = [

					[
					'id'=>'login',
					'titulo'=>'Iniciar Sesión',
					'enlace' => ROUTER::create_action_url("site/login")

					],

					/*[
					'id'=>'registro',
					'titulo'=>'Registro de Usuario',
					'enlace' => ROUTER::create_action_url("registro/index")

					],*/		

			];
		}
		


		$rutaView = ROOT . "views" . DS . $this->_controlador . DS . $vista . ".php";  //armamos la ruta hasta la vista


			//verificamos que el archivo sea legible

			if(is_readable($rutaView)){



				include_once ROOT . "views" . DS . "layouts" . DS . DEFAULT_LAYOUT . DS . "content.php";
                include_once ROOT . "views" . DS . "layouts" . DS . DEFAULT_LAYOUT . DS . "footer.php";


			}else{

				throw new Exception("Vista no encontrada", 1);
				

			}

		
	}



}



?>