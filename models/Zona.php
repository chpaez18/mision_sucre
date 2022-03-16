<?php 


/**
* 
*/
class Zona extends Model
{
	public $name = "zona";
	public $pk_field = "cod_zona";

	function __construct()
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
            'descripcion' => 'Descripción'
        ];
    }


/*
	public function eliminarZona($id)
	{

		$id = (int) $id; //convertimos el id que se envio, en un entero

		//los valores se pasan de esta forma por seguridad, asi se evitan las inyecciones sql
		$this->db->query("delete from zona where cod_zona = $id");


	}
*/
	
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