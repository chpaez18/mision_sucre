<?php
/**
* 
*/
class Site extends Model
{


	public $name = "usuario";
	public $pk_field = "cod_usuario";
	public $nac;
	public $cedula;
	public $confirmar;
	public $confirmar_respuesta;
	public $id_user;
	public $respuesta;
	public $captcha;
	public $txtcopia;

	
	function __construct()
	{
		parent::__construct();

	}


	
	public function users()
	{

	}	

	public function nuevo()
	{

		
	}

    public function attributeLabels()
    {
        return [
            'cod_usuario' => 'Código de Usuario',
            'nom_usuario' => 'Nombre de Usuario',
            'pass_usuario' => 'Contraseña',
            'preg_secreta' => 'Pregunta Secreta',
            'resp_secreta' => 'Respuesta',
            'rol_cod_rol' => 'Rol',
        ];
    }

	function codigo_captcha(){

		$k="";
		$paramentros="1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$maximo=strlen($paramentros)-1;

		for($i=0; $i<5; $i++){

			$k.=$paramentros{mt_rand(0,$maximo)};
		}

		return $k;
	}

	public function getHabilitado(){
		return $this->habilitar_carga_notas;
	}

	public function findModel($id){

		$id = (int) $id; //convertimos el id que se envio, en un entero
		$model = new $this->name;

		$consulta = $this->db->query("select * from ".$this->name." where ".$this->pk_field." = $id");
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);

		if($registros){
			foreach ($registros as $key => $value) {
				$model->$key = "$value";
			}
			return $model;
		}else{
			return false;
		}
	}

}
?>