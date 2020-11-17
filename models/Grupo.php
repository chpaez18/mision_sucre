<?php 


/**
* 
*/
class Grupo extends Model
{
	public $name = "grupo";
	public $pk_field = "cod_grupo";
	public $cod_estudiante;
	public $cod_carrera;

	public $cod_trayecto;
	public $cod_materia;
	public $periodo;
	public $ano;

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
            'nombre' => 'Nombre del Grupo',
            'capacidad' => 'Número de estudiantes'
        ];
    }


    //devuelve los estudiantes de un grupo
	public function getEstudiantesGrupos($cod_grupo)
	{

    	$data = $this->db->query("select * from grupo_estudiante where cod_grupo = $cod_grupo");
		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);


		if($registros){
			return $registros;
		}else{
			return false;
		}	
	}	



	//devuelve los estudiantes de un grupo
	public function getEstudiantes($cod_grupo)
	{

    	$data = $this->db->query("select ge.cod_estudiante, e.nombre_estudiante, e.apellido_estudiante, e.cedula_estudiante
			from grupo_estudiante ge, estudiante e, grupo g 
			where ge.cod_estudiante = e.cod_estudiante and g.cod_grupo = ge.cod_grupo and g.cod_grupo = $cod_grupo");

		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);


		if($registros){
			return $registros;
		}else{
			return false;
		}	
	}	


	public function getMateriasAsignadas($cod_grupo)
	{

    	$data = $this->db->query("select ge.cod_estudiante, e.nombre_estudiante, e.apellido_estudiante, e.cedula_estudiante
			from grupo_estudiante ge, estudiante e, grupo g 
			where ge.cod_estudiante = e.cod_estudiante and g.cod_grupo = ge.cod_grupo and g.cod_grupo = $cod_grupo");

		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);


		if($registros){
			return $registros;
		}else{
			return false;
		}	
	}


	//devuelve la carrera asociada a un grupo
	public function getCarreras($cod_carrera)
	{

    	$model = new Carrera();

    	/*
    	$data = $this->db->query("select cg.cod_carrera, c.nombre_carrera from carrera_grupo cg, carrera c, grupo g  where cg.cod_carrera = c.cod_carrera and g.cod_grupo = cg.cod_grupo and g.cod_grupo = $cod_grupo");
		*/

		$data = $this->db->query("select nombre_carrera from carrera c, grupo g where g.id_carrera = c.cod_carrera and c.cod_carrera = $cod_carrera");

		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);

		if($registros){
			return $registros[0]["nombre_carrera"];
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