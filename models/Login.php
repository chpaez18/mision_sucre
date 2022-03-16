<?php 
/**
* 
*/
class Login extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}

//en este metodo consultamos la base de datos para obtener el usuario, y se nos da una respuesta
	
	public function getUsuario($usuario, $password)
	{

		$datos = $this->db->query("select * from usuario where nom_usuario = '$usuario' and pass_usuario ='".$password."'");

		return $datos->fetch();
	}	

	public function getPregunta($usuario)
	{

		$datos = $this->db->query("select * from usuario where nom_usuario = '$usuario'");
		$row = $datos->fetch();
		$pregunta_secreta = $row["preg_secreta"];

		return $pregunta_secreta;
	}

	public function VerificarPreguntaSeguridad($usuario, $respuesta)
	{

		$datos = $this->db->query("select * from usuario where nom_usuario = '$usuario' and resp_secreta ='".$respuesta."'");

		if($datos->fetch()){

			return true;
			exit;

		}else{

			return false;
			exit;
		}
	}


	public function actualizarContra($usuario, $contra)
	{

		
		//con el metodo prepare() limpiamos los parametros para evitar inyecciones sql y xss
		$this->db->prepare("update usuario set pass_usuario = :pass_usuario where nom_usuario = '$usuario'")
		->execute(
			[
				':pass_usuario'=>$contra
			]);


	}	


}


?>