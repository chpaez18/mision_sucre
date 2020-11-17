<?php 

/**
* 
*/
class Usuarios extends Model
{
	
	public $name = "usuario";
	public $pk_field = "cod_usuario";
	public $confirmar_respuesta;

	public function __construct()
	{
		parent::__construct();
	}

	public function getName(){

		return $this->name;
	}	

	public function getFieldKey(){

		return $this->pk_field;
	}


    public function attributeLabels()
    {
        return [
            'resp_secreta' => 'Respuesta'
        ];
    }

	public function getUsuarios(){}

	public function insertarUsuario(){}


	public function editarUsuario($id){}


	public function eliminarUsuario($id){}	

	public function editarClave($cod_usuario,$pass_usuario)
	{

		$this->db->prepare("update usuario set pass_usuario = :pass_usuario where cod_usuario = $cod_usuario")
		->execute([
				':pass_usuario'=>Hash::getHash("sha1", $pass_usuario, HASH_KEY)
				]);

	}



}

?>