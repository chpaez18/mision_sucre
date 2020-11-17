<?php 


/**
* 
*/
class Profesor extends Model
{
	public $name = "profesor";
	public $pk_field = "cod_profesor";
	public $cod_materia;
	
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
            'ced_profesor' => 'Número de Cédula',
            'nombre_profesor' => 'Nombre del Profesor',
            'apellido_profesor' => 'Apellido del Profesor'
        ];
    }

	public function getProfesores()
	{

		$profesores = $this->db->query("select * from profesor order by cod_profesor");

		//guardamos todos los registros en una variable
		$registros = $profesores->fetchall();
		$cant_registros = count($registros);

		//creamos un ciclo para eliminar valores duplicados del arreglo, y guardar limpio el array a devolver

			for($x=0;$x < $cant_registros;$x++){

				$response[$x] = array_unique($registros[$x]);
			}

			if($cant_registros == null){
				$response = null;
			}



		return $response;

	}	



		

	public function insertarProfesor($ced_profesor, $nombre_profesor, $apellido_profesor)
	{

		//los valores se pasan de esta forma por seguridad, asi se evitan las inyecciones sql
		$this->db->prepare("insert into profesor (ced_profesor, nombre_profesor, apellido_profesor) values (:ced_profesor, :nombre_profesor, :apellido_profesor)")
		->execute([
				':ced_profesor'=>$ced_profesor,	
				':nombre_profesor'=>$nombre_profesor,	
				':apellido_profesor'=>$apellido_profesor	
				]);


	}	


	public function editarProfesor($id, $ced_profesor, $nombre_profesor, $apellido_profesor)
	{

		$id = (int) $id; 

		//los valores se pasan de esta forma por seguridad, asi se evitan las inyecciones sql

		//con el metodo prepare() limpiamos los parametros para evitar inyecciones sql y xss
		$this->db->prepare("update profesor set ced_profesor = :ced_profesor, nombre_profesor = :nombre_profesor, apellido_profesor = :apellido_profesor where cod_profesor = :id")
		->execute(
			[
				':ced_profesor'=>$ced_profesor, 
				':nombre_profesor'=>$nombre_profesor, 
				':apellido_profesor'=>$apellido_profesor, 
				':id'=>$id
			]);


	}	


	public function eliminarProfesor($id)
	{

		$id = (int) $id; //convertimos el id que se envio, en un entero

		//los valores se pasan de esta forma por seguridad, asi se evitan las inyecciones sql
		$this->db->query("delete from profesor where cod_profesor = $id");


	}



	public function isExists($cod_profesor){

	//verificamos si la carrera tiene materias asignadas
		$profesor_materias = $this->db->query("select * from materia_profesor where cod_profesor = $cod_profesor ");
		$registros = $profesor_materias->fetchall();

		if($registros){
			return true;
		}else{
			return false;
		}
	}

	public function asigMateria1($cod_materia, $cod_profesor)
	{

		$this->db->prepare("insert into materia_profesor (cod_materia, cod_profesor) values (:cod_materia, :cod_profesor)")
		->execute([
				':cod_materia'=>$cod_materia,	
				':cod_profesor'=>$cod_profesor	
				]);


	}


	public function getMateriasProfesor($cod_profesor){

		$registros = $this->searchArrayByQuery("select m.nombre_materia from materia m, profesor p, materia_profesor mp where m.cod_materia = mp.cod_materia and p.cod_profesor = mp.cod_profesor and p.cod_profesor = $cod_profesor
		");
		if($registros){
			return $registros;
		}else{
			return false;
		}
    	
	}


	public function profesorMateriaSelect($cod_profesor){

		$materia_profesor = $this->db->query("select cod_materia from materia_profesor where cod_profesor = $cod_profesor ");
		$registros = $materia_profesor->fetchall();

		return $registros;
	}

	//devuelve informacion del profesor, que materias dicta, en que carreras y los grupos
	public function getInfoProfesor($cod_profesor)
	{

		$info_profesor = $this->db->query("select p.nombre_profesor || ' ' || p.apellido_profesor AS nombre_profesor, m.nombre_materia AS materia, c.nombre_carrera AS carrera, g.nombre AS grupo
			FROM profesor p
			INNER JOIN materia_profesor mp ON mp.cod_profesor = p.cod_profesor
			INNER JOIN materia m ON m.cod_materia = mp.cod_materia
			INNER JOIN carrera_materia cm ON cm.cod_materia = m.cod_materia
			INNER JOIN carrera c ON c.cod_carrera = cm.cod_carrera
			INNER JOIN grupo g ON g.id_carrera = c.cod_carrera 
			where p.cod_profesor = $cod_profesor");

		//guardamos todos los registros en una variable
		$registros = $info_profesor->fetchall();

		$cant_registros = count($registros);

		//creamos un ciclo para eliminar valores duplicados del arreglo, y guardar limpio el array a devolver

			for($x=0;$x < $cant_registros;$x++){

				$response[$x] = array_unique($registros[$x]);
			}

			if($cant_registros == null){
				$response = null;
			}

		return $response;


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