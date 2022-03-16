<?php 


/**
* 
*/
class Aldea extends Model
{
	public $name = "aldea";
	public $pk_field = "cod_aldea";
	public $cod_carrera;

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
            'nombre_aldea' => 'Nombre de la Aldea',
            'ubicacion' => 'Ubicación'
        ];
    }

    //devuelve el coordinador de x aldea
    public function getAldeaCord($cod_aldea)
    {


    	$model = new Aldea();
    	$registros = $model->searchByQuery("select c.nombre_coordinador, c.apellido_coordinador from coordinador c, aldea a where c.aldea_cod_aldea = a.cod_aldea and a.cod_aldea = $cod_aldea");

		if($registros){
			return $registros["nombre_coordinador"]." ".$registros["apellido_coordinador"];
		}else{
			return false;
		}		

    }

    //devuelve la zona de x aldea
	public function getZonas($cod)
	{

    	$model = new Aldea();
    	$registros = $model->searchByQuery("select z.cod_zona, z.descripcion  from zona z, aldea a where z.cod_zona = a.id_zona and a.cod_aldea = $cod");

		if($registros){
			return $registros["descripcion"];
		}else{
			return false;
		}	


	}	

	//devuelve las carreras asociadas a una aldea
	public function getCarreras($cod_aldea)
	{

    	$model = new Carrera();
    	$data = $this->db->query("select ac.cod_carrera, c.nombre_carrera, c.tipo from aldea_carrera ac, carrera c, aldea a where ac.cod_carrera = c.cod_carrera and a.cod_aldea = ac.cod_aldea and a.cod_aldea = $cod_aldea");

		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);


		if($registros){
			return $registros;
		}else{
			return false;
		}	


	}

/*
	public function insertAldeaCarrera($cod_aldea, $cod_carrera){
		$sentencia = $this->db->prepare("insert into aldea_carrera (cod_aldea, cod_carrera) values($cod_aldea, $cod_carrera)");
		
		$sentencia->execute();
	}
*/

/*
	public function eliminarAldea($id)
	{

		$id = (int) $id; //convertimos el id que se envio, en un entero

		$this->db->query("delete from $this->name where $this->pk_field = $id");


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