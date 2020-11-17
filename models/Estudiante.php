<?php 

/**
* 
*/
class Estudiante extends Model
{
	
	public $name = "estudiante";
	public $pk_field = "cod_estudiante";
	public $cod_materia;

	public $cod_grupo;
	public $cod_trayecto;
	public $cod_carrera;
	public $cod_aldea;
	public $ano;

	public $calificacion;
	public $estudiante;
	
	public $cod_t;
	public $cod_c;
	public $cod_g;
	public $cod_m;
	public $materia;

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
            'cedula_estudiante' => 'Número de Cédula',
            'nombre_estudiante' => 'Nombre',
            'apellido_estudiante' => 'Apellido',
            'fecha_nacimiento' => 'Fecha de Nacimiento(dd/mm/yyyy)',
            'lugar_nacimiento_estudiante' => 'Lugar de Nacimiento',
            'correo_estudiante' => 'Correo Eléctronico',
            'celular_estudiante' => 'Teléfono Celular',
            'tlf_local_estudiante' => 'Teléfono Habitación',
            'direccion_estudiante' => 'Dirección'
        ];
    }

    public function getMateriasEstudiante($cod_estudiante){
    	$registros = $this->searchArrayByQuery("select m.cod_materia, m.nombre_materia
		from estudiante e
		inner join grupo_estudiante ge on ge.cod_estudiante = e.cod_estudiante
		inner join grupo g on g.cod_grupo = ge.cod_grupo
		inner join carrera_materia cm on cm.cod_carrera = g.id_carrera
		inner join materia m on m.cod_materia = cm.cod_materia
		where e.cod_estudiante = $cod_estudiante");

    	return $registros;
    }    

    public function getMateriasEstudianteAll(){
    	$registros = $this->searchArrayByQuery("select m.cod_materia, m.nombre_materia
		from estudiante e
		inner join grupo_estudiante ge on ge.cod_estudiante = e.cod_estudiante
		inner join carrera_grupo cg on cg.cod_grupo = ge.cod_grupo
		inner join carrera_materia cm on cm.cod_carrera = cg.cod_carrera
		inner join materia m on m.cod_materia = cm.cod_materia
		");

    	return $registros;
    }

	//devuelve la calificacion en x materia de x estudiante
	public function getCalificacion($cod_materia, $cod_estudiante)
	{

		$model = new Estudiante();
		
		$materia_calificacion = $model->searchArrayByQuery("select calificacion from materia_estudiante where cod_estudiante = $cod_estudiante and cod_materia = $cod_materia order by cod_estudiante");
		$calificacion = $materia_calificacion[0]["calificacion"];
			
		if($calificacion != 0){
			return $calificacion;
		}else{
			
			return false;
		}
	}	

	//devuelve el promedio del estudiante x
	public function getPromedio($cod_estudiante)
	{

		$materia_calificacion = $this->db->query("select avg(calificacion) as promedio from materia_estudiante  where cod_estudiante = $cod_estudiante");
		$registros = $materia_calificacion->fetchall(PDO::FETCH_ASSOC);

		if($registros){

			return $registros[0]["promedio"];
		}else{
			
			return false;
		}
	}


	//verifica si los datos del estudiante estan completos
	public function VerificarEstudiante($cod_estudiante){

		$reg= $this->searchArrayByQuery("select * from estudiante where cod_estudiante = $cod_estudiante");
		/*
		echo "<pre>";
		print_r($reg[0]["correo_estudiante"]);
		echo "<pre>";
		die();
		*/
		if($reg[0]["nombre_estudiante"] == "" or $reg[0]["apellido_estudiante"] == "" or $reg[0]["fecha_nacimiento"] == "" or $reg[0]["sexo_estudiante"] == "" or $reg[0]["estado_civil_estudiante"] == "" or $reg[0]["lugar_nacimiento_estudiante"] == "" or $reg[0]["celular_estudiante"] == "" or $reg[0]["correo_estudiante"] == "" or $reg[0]["direccion_estudiante"] == ""){
                    return true;
                }else{
                   return false;
                }
	}


	
/*
	public function getEstudiantes()
	{

		$estudiantes = $this->db->query("select * from estudiante where inscripcion_formalizada = 'TRUE' ");
		$registros = $estudiantes->fetchall();

		return $registros;

	}	

	public function getEstudiantesNotInGroup()
	{

		$estudiantes = $this->db->query("select * from estudiante where pertenece_grupo = FALSE");
		$registros = $estudiantes->fetchall();

		return $registros;

	}		

	/*
	public function getEstudiantesNotin()
	{

		$estudiantes = $this->db->query("select e.cod_estudiante, e.nombre_estudiante, e.apellido_estudiante, e.cedula_estudiante from estudiante e, grupos_estudiantes ge where  e.cod_estudiante not in (select ge.cod_estudiante from grupos_estudiantes ge) and e.inscripcion_formalizada = true/*
		");
		$registros = $estudiantes->fetchall();

		return $registros;

	}	
	*/

/*
	public function getEstudiante($id_user)
	{

		$usuarios = $this->db->query("select * from estudiante where usuario_cod_usuario = $id_user ");
		$registros = $usuarios->fetchall();

		return $registros;

	}

	public function updateEstudianteGroup($cod_estudiante)
	{

		$this->db->prepare("update estudiante set pertenece_grupo = 'TRUE' where cod_estudiante = :cod_estudiante")
		->execute(
			[
				':cod_estudiante'=>$cod_estudiante 
			]);

	}	



	public function actualizarEstudiante($cedula_estudiante, $nombre_estudiante, $apellido_estudiante, $fecha_nacimiento, $sexo_estudiante, $estado_civil_estudiante, $lugar_nacimiento_estudiante, $correo_estudiante, $celular_estudiante, $tlf_local_estudiante, $direccion_estudiante)
	{

		$this->db->prepare("update estudiante set nombre_estudiante = :nombre_estudiante, apellido_estudiante = :apellido_estudiante, fecha_nacimiento = :fecha_nacimiento, sexo_estudiante = :sexo_estudiante, estado_civil_estudiante = :estado_civil_estudiante, lugar_nacimiento_estudiante = :lugar_nacimiento_estudiante, correo_estudiante = :correo_estudiante, celular_estudiante = :celular_estudiante, tlf_local_estudiante = :tlf_local_estudiante, direccion_estudiante = :direccion_estudiante, inscripcion_formalizada = 'TRUE'  where cedula_estudiante = :cedula_estudiante")
		->execute(
			[
				':nombre_estudiante'=>$nombre_estudiante, 
				':apellido_estudiante'=>$apellido_estudiante, 
				':fecha_nacimiento'=>$fecha_nacimiento, 
				':sexo_estudiante'=>$sexo_estudiante, 
				':estado_civil_estudiante'=>$estado_civil_estudiante, 
				':lugar_nacimiento_estudiante'=>$lugar_nacimiento_estudiante, 
				':correo_estudiante'=>$correo_estudiante, 
				':celular_estudiante'=>$celular_estudiante, 
				':tlf_local_estudiante'=>$tlf_local_estudiante, 
				':direccion_estudiante'=>$direccion_estudiante, 
				':cedula_estudiante'=>$cedula_estudiante
			]);

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