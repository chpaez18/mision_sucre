<?php 

/**
* 
*/
class Carrera extends Model
{
	
	public $name = "carrera";
	public $pk_field = "cod_carrera";
	public $cod_materia;
	public $cod_grupo;

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
            'nombre_carrera' => 'Nombre de la Carrera',
            'tipo' => 'Tipo'
        ];
    }


/*
	//devuelve los grupos asociados a una carrera
	public function getGrupos($cod_carrera)
	{

    	$model = new Carrera();
    	$data = $this->db->query("select cg.cod_grupo, g.nombre, g.capacidad from carrera_grupo cg, carrera c, grupo g where cg.cod_grupo = g.cod_grupo and c.cod_carrera = cg.cod_carrera and c.cod_carrera = $cod_carrera");

		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);


		if($registros){
			return $registros;
		}else{
			return false;
		}	


	}	
*/
	
	//devuelve las materias asociadas a una carrera
	public function getMaterias($cod_carrera)
	{

    	$model = new Carrera();
    	$data = $this->db->query("select cm.cod_materia, m.nombre_materia from carrera_materia cm, carrera c, materia m where cm.cod_materia = m.cod_materia and c.cod_carrera = cm.cod_carrera and c.cod_carrera = $cod_carrera");

		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);


		if($registros){
			return $registros;
		}else{
			return false;
		}	
	}	

	//devuelve los grupos que aun no pertenecen a una carrera
	public function grupos_sin_carrera()
	{

    	$model = new Carrera();
    	$data = $this->db->query("select * from grupo g where cod_grupo not in (select cod_grupo from carrera_grupo)");

		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);


		if($registros){
			return $registros;
		}else{
			return false;
		}	
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