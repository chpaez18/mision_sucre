<?php 

/**
* 
*/
class Coordinador extends Model
{
	
	public $name = "coordinador";
	public $pk_field = "cod_coordinador";
	public $cedula;
	public $correo;
	public $calificacion;
	public $nac;
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
            'ced_coordinador' => 'Cédula del Coordinador',
            'nombre_coordinador' => 'Nombre del Coordinador',
            'apellido_coordinador' => 'Apellido del Coordinador',
        ];
    }


	//devuelve la aldea asignada a x coordinador
	public function getCordAldea($cod_coordinador)
	{

		$carreras_aldeas = $this->db->query("select a.cod_aldea, a.nombre_aldea from coordinador c, aldea a where c.aldea_cod_aldea = a.cod_aldea and c.cod_coordinador = $cod_coordinador");

		//guardamos todos los registros en una variable
		$registros = $carreras_aldeas->fetchall();

		$cant_registros = count($registros);

		//creamos un ciclo para eliminar valores duplicados del arreglo, y guardar limpio el array a devolver

			for($x=0;$x < $cant_registros;$x++){

				$response[$x] = array_unique($registros[$x]);
			}

			if($cant_registros == null){
				$response = null;
			}

		return $response[0]["nombre_aldea"];


	}


	//Registra la cédula de un estudiante en la tabla "estudiante", tambien verifica si ya la cédula se encuentra registrada
	public function registrarCI($nac, $cedula_estudiante, $correo_estudiante)
	{

		$estudiante = $this->db->query("select * from estudiante where nac = '$nac' and cedula_estudiante = '$cedula_estudiante' ");
		$registros = $estudiante->fetchall();

		if($registros){

			return false;
		}else{
			
			$this->db->prepare("insert into estudiante (nac, cedula_estudiante, correo_estudiante) values (:nac, :cedula_estudiante, :correo_estudiante)")
			->execute([
					':nac'=>$nac,
					':cedula_estudiante'=>$cedula_estudiante,
					':correo_estudiante'=>$correo_estudiante,
					]);

			return true;
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