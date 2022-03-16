<?php 
//clase de la cual extenderan todos nuestros modelos


/**
* 
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Model
{
	
	protected $db;

	static $where;
	static $atributo;

	public function __construct(){

		$this->db = new Database();

		//auto construimos dinamicamente los atributos de la clase que se esta instanciando, de tal forma de tener disponible en un simple objeto el valor que se recoge por el formulario 



			foreach ($_POST as $key => $value) {

				if(is_array($value)){
					//echo "esto es un array";
				}else{
					$this->$key = "$value";
				}
			}


	}

    public static function className()
    {
    	$mod = new Request();
    	$nom = $mod->getControlador();

    	return ucwords($nom);
    }

	//cambiar nombre a getFields()
	public function getColumns($table_name = false){

		$class_name = self::className();
		$model = new $class_name;

		if($table_name){

			$data = $model->db->query("select * from $table_name");
		}else{
			$data = $model->db->query("select * from $model->name");

		}
		
		$cant = count($data);
		$cant_fields = $data->ColumnCount();
		//devuelve un arreglo con el tipo de dato del campo
		$resp = $data->fetchall();

		$x=0;
		$y=0;

		/*
		devuelve un arreglo solo con los nombres de los campos de la tabla
		$respuesta = array_keys($data->fetch(PDO::FETCH_ASSOC));
		*/


			while ($x <= $cant_fields-1) {
				$response[$x] = $data->getColumnMeta($x);
				$x++;
			}
				
			return $response;
	}
	

	//funcion que nos permite traer cualquier tipo de informacion en un arreglo, por medio de cualquier tipo de query que le pasemos
	public function searchByQuery($query){
		$data = $this->db->query($query);
		$response = "";
		//guardamos todos los registros en una variable
		$registros = $data->fetchall(PDO::FETCH_ASSOC);

		$cant_registros = count($registros);

		//hacemos que la funcion se adapte dependiendo de cuantos registros devuelve la consulta

		if($cant_registros > 1){

				return $registros;

		}elseif($cant_registros == 1){

			foreach ($registros as $row) {

				for($x=0;$x < $cant_registros;$x++){
						
					$response = $row;
				}
			}

				return $response;

		}

	}	

	//igual que la anterior, simplemente que esta funcion siempre nos retornara un arreglo de registros
	public function searchArrayByQuery($query){
		$data = $this->db->query($query);
		$response = "";
		$registros = $data->fetchall(PDO::FETCH_ASSOC);
		
		return $registros;
	}


	//cambiar nombre a searchByModel()
	public function searchByQueryOne($query)
	{


		$data = $this->db->query($query);
		$response = [];
		//guardamos todos los registros en una variable
		$registros = $data->fetch(PDO::FETCH_ASSOC);
		//FETCH_ASSOC devuelve el arreglo indexado por el nombre de la columna seguido del valor
			
		if($registros){
			$response = new $this;

			foreach ($registros as $key => $value) {

				 $response->$key = $value;
			}

			return $response;

		}else{

			return false;
		}

		
		
	}

	//funcion para buscar toda la informacion de la tabla (o modelo) activo, se le puede pasar una condicion donde la informacion a retornar puede ser un arreglo con varios registros

	public function findAll($condicion = []){
		$class_name = self::className();
		$model = new $class_name;

		$sentencia = $this->db->prepare("select * from $this->name");
		

		if($condicion){
			$index = array_keys($condicion); //sacamos el indice del arreglo
			$valor = current($condicion);    //sacamos el valor

			$condicion = $index[0];

			$sentencia = $this->db->prepare("select * from $this->name where $condicion = :$condicion");
			$model->data = "select * from $this->name where $condicion = :$condicion";
			$model->condicion = $condicion;
			$model->valor = $valor;

			$sentencia->bindParam(":".$condicion,$valor);

		}else{
			$condicion = "";
			$valor = "";
		}

		$sentencia->execute();
		$registros = $sentencia->fetchall(PDO::FETCH_ASSOC);

		if($registros){
			foreach ($registros as $key => $value) {
				 $model->$key = $value;
			}


			return $model;
		}else{
			return false;
		}
		
	}


/*
	public function find(){
		$data = $this->db->query("select * from $this->name");
		$registros = $data->fetchall(PDO::FETCH_ASSOC);

		if($registros){

			foreach ($registros as $key => $value) {
				 $this->$key = $value;
			}

			return $this;

		}else{

			return false;
		}

		self::$atributo = new Model();
		return self::$atributo;

	}
*/

	//funcion para traer informacion de una manera mas simplificada

	public function find(){

		$class_name = self::className();
		$model = new $class_name;

		$data = $model->db->query("select * from $model->name");
		$response = "";
		$registros = $data->fetchall(PDO::FETCH_ASSOC);

		if($registros){

			foreach ($registros as $key => $value) {
				 $model->$key = $value;
			}

			return $model;

		}else{

			return false;
		}
		
	}


	//funcion para concatenar una condicion a una consulta general
	public function where($condicion = []){

		$class_name = self::className();
		$model = new $class_name;



		if($condicion){
			$index = array_keys($condicion); //sacamos el indice del arreglo
			$valor = current($condicion);    //sacamos el valor

			$condicion = $index[0];

			$model->data = "select * from $model->name where $condicion = :$condicion";
			$model->condicion = $condicion;
			$model->valor = $valor;
			$sentencia = $model->db->prepare("select * from $model->name where $condicion = :$condicion");

			$sentencia->bindParam(":".$condicion,$valor);
		}else{
			$condicion = "";
			$valor = "";
		}

		$sentencia->execute();
		$registros = $sentencia->fetchall(PDO::FETCH_ASSOC);

		if($registros){

			foreach ($registros as $key => $value) {
				 $model->$key = $value;
			}


			return $model;

		}else{

			return false;
		}
		
	}



	//funcion auxiliar del where, permite concatenar un and a la consulta preparada con el where
	public function andd($condicion = []){

		$class_name = self::className();

		$query = $this->data;

		if($condicion){
			$index1 = array_keys($condicion); //sacamos el indice del arreglo
			$condicion1 = $index1[0];
			$valor1 = current($condicion);    //sacamos el valor

			$sentencia = $this->db->prepare("$query and $condicion1 = :$condicion1");
			$sentencia->bindParam(":".$this->condicion,$this->valor);
			$sentencia->bindParam(":".$condicion1,$valor1);

		}
		
			$sentencia->execute();
			$registros = $sentencia->fetch(PDO::FETCH_ASSOC);


		if($registros){
			$model = new $class_name;
			foreach ($registros as $key => $value) {
				 $model->$key = $value;
			}

			return $model;

		}else{

			return false;
		}

	}

	//funcion auxiliar que nos permite preparar los registros devueltos por las consultas anteriores, en este caso all() devuelve un arreglo de registros
	public function all(){
		$class_name = self::className();
		if(isset($this->data)){
			$query = $this->data;
		}else{
			$query = "select * from $this->name order by $this->pk_field";
		}
			
		$sentencia = $this->db->prepare($query);	

		if(isset($this->condicion) and isset($this->valor)){
			$condicion = $this->condicion;
			$valor = $this->valor;

			$sentencia->bindParam(":".$this->condicion,$this->valor);
		}else{
			$condicion = "";
			$valor = "";
		}

			
			$sentencia->execute();
			$registros = $sentencia->fetchall(PDO::FETCH_ASSOC);

		if($registros){
			
			return $registros;

		}else{

			return false;
		}
	}	

	//funcion auxiliar que nos permite preparar los registros devueltos por las consultas anteriores, en este caso one() arma un objeto del primer registro devuelto por la consulta y lo retorna
	public function one(){
		$class_name = self::className();
		
		if(isset($this->data)){
			$query = $this->data;
		}else{
			$query = "select * from $this->name limit 1";
		}
		

		$sentencia = $this->db->prepare($query);

		if(isset($this->condicion) and isset($this->valor)){
			$condicion = $this->condicion;
			$valor = $this->valor;

			$sentencia->bindParam(":".$condicion,$valor);
		}else{
			$condicion = "";
			$valor = "";
		}

			
			$sentencia->execute();
			$registros = $sentencia->fetch(PDO::FETCH_ASSOC);

		if($registros){
			$model = new $class_name;
			foreach ($registros as $key => $value) {
				 $model->$key = $value;
			}


			return $model;

		}else{

			return false;
		}
	}		

	//funcion que crea un objeto con los atributos definidos dentro del formulario, de esta forma obtenemos informacion enviada por POST más rapido
	public function requestPost(){
		ActiveRecord::$class = self::className();
		
		if($_POST){

			if(ActiveRecord::validateTableFields()){

				return (object) $_POST;
			}

			return false;
		}	
	}


/////////////////////////////FUNCIONES DE INSERT, UPDATE Y DELETE////////////////////////////
	public static function insert(){
		$class_name = self::className();
		$model = new $class_name;
		return "insert into $model->name";
	}	

	public static function update1(){
		$class_name = self::className();
		$model = new $class_name;
		return "update $model->name set";
	}	


	public function insertCommand(){
		$class_name = self::className();
		//$model = new $class_name;
		App::$class = self::className();

		$index = App::getKeyArray($_POST);
		$valor = App::getValueArray($_POST);
		$cant_1 = count($index);
		$x = 0;
		$command_fields = "";
		$command_fields2 = "";
		$valor1 = [];
		$arr = get_object_vars($this);



		$fields = Model::getColumns();
		$index2 = (array) $fields;
		$campos_tabla = ArrayHelper::map($index2, 'name', 'name'); //campos de la tabla}

		foreach ($arr as $key3 => $value3) {
			if(array_key_exists($key3, $campos_tabla)){

			}else{
				ArrayHelper::remove($arr, $key3);
			}
		}



		ArrayHelper::remove($arr, $this->pk_field);
		ArrayHelper::remove($arr, "pk_field");
		ArrayHelper::remove($arr, "db");
		ArrayHelper::remove($arr, "name");

		


		foreach ($arr as $key => $value) {
			

			$command_fields .= "$key, ";
			$command_fields2 .= ":$key, ";
			array_push($valor1, $value);
			
		}

		$command_fields = substr_replace($command_fields, "", -2);
		$command_fields2 = substr_replace($command_fields2, "", -2);

		$query = static::insert()."($command_fields) values ($command_fields2)";
		$sentencia = $this->db->prepare($query);
		while ($x < $cant_1) {
			$sentencia->bindParam(":".$index[$x], $valor1[$x]);
			$x++;
		}
		if($sentencia->execute()){
			return true;
		}else{
			throw new Exception("Ha ocurrido un error",1);
				exit;
		}

	}	



	public function updateCommand($id){
		$class_name = self::className();
		//$model = new $class_name;
		App::$class = self::className();

		$index = App::getKeyArray($_POST);
		$valor = App::getValueArray($_POST);

		$cant_1 = count($index);
		$x = 0;
		$command_fields = "";
		$valor1 = [];
		
		$arr = get_object_vars($this);


		$fields = Model::getColumns();
		$index4 = (array) $fields;
		$campos_tabla = ArrayHelper::map($index4, 'name', 'name'); //campos de la tabla}

		foreach ($arr as $key3 => $value3) {
			if(array_key_exists($key3, $campos_tabla)){

			}else{
				ArrayHelper::remove($arr, $key3);
			}
		}


		ArrayHelper::remove($arr, $this->pk_field);
		ArrayHelper::remove($arr, "pk_field");
		ArrayHelper::remove($arr, "db");
		ArrayHelper::remove($arr, "name");


		foreach ($arr as $key => $value) {
			$command_fields .= "$key = :$key, ";
			array_push($valor1, $value);
			
		}

		$command_fields = substr_replace($command_fields, "", -2);

		$query = static::update1()." $command_fields where $this->pk_field = $id";

		$sentencia = $this->db->prepare($query);

		while ($x < $cant_1) {
			$sentencia->bindParam(":".$index[$x], $valor1[$x]);
			$x++;
		}
		if($sentencia->execute()){
			return true;
		}else{
			throw new Exception("Ha ocurrido un error",1);
				exit;
		}

	}


	public function save(){
		
		if(static::insertCommand()){
			return true;
		}else{
			return false;
		}
	}	

	public function update($id){

		if(static::updateCommand($id)){
			return true;
		}else{
			return false;
		}
	}	



	public function normalQuery($query){
		$sentencia = $this->db->prepare($query);
		
		if($sentencia->execute()){
			return true;
		}else{
			return false;
		}
	}
///////////////////////////FIN FUNCIONES DE INSERT, UPDATE Y DELETE////////////////////////////




	//funcion auxiliar que nos ayuda a buscar un registro en especifico dinamicamente
	public function findModel($id){


		$id = (int) $id; //convertimos el id que se envio, en un entero

		$model = $this->db->query("select * from ".$this->name." where ".$this->field_key." = $id");
		return $model->fetch();

	}


	public function encrypt($cadena){
		return Hash::getHash("sha1",$cadena,HASH_KEY);
	}

	public function user(){
		$model = new ActiveRecord();
		$cod_usuario = Session::get("cod_usuario");
		$user_info = self::searchByQuery("select * from usuario where cod_usuario = $cod_usuario");
		foreach ($user_info as $key => $value) {
			$model->$key = "$value";
		}
		return $model;
	}

	public function sendMail($destinatario, $asunto, $cuerpo_correo){

		$mail = new PHPMailer(true);
		
		//PARAMETROS DE CONFIGURACION PARA ENVIOS POR SMTP
		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);

		$mail->isSMTP();
		$mail->Host = 'smtp.live.com';
		$mail->SMTPAuth = true;
		$mail->Username = ADMIN_EMAIL;
		$mail->Password = PASS_EMAIL;
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		//FIN PARAMETROS


		$mail->setFrom(ADMIN_EMAIL);
		$mail->addAddress($destinatario);
		$mail->Subject = $asunto;
		$mail->Body = $cuerpo_correo;
		$mail->isHTML();
		$mail->CharSet = 'UTF-8';

		$mail->send();

	}	

	public function getTypeField($campo){
		$campos_tabla = $this->getColumns($this->name);
		$count = count($campos_tabla);
		$x = 0;

		while ($x < $count) {
			if($campos_tabla[$x]["name"] == $campo){
				return $campos_tabla[$x]["native_type"];
				exit;
			}
			$x++;
		}
	}

	//funcion para validar un campo Unique en cualquier tabla, basandonos en la informacion que se este guardando
	public function validateUnique($campo, $valor){
		$tipo = $this->getTypeField($campo);

		if($tipo == "varchar"){
			$query = "$campo = '$valor' ";

		}elseif($tipo == "int4"){
			$query = "$campo = $valor ";

		}elseif(!$tipo){
			throw new Exception("El atributo <b>$campo</b> no existe en la tabla",1);
			exit;
		}

		$registros = $this->searchByQuery("select * from $this->name where $query");

		if($registros){
			return true;
		}else{
			return false;
		}
	}

	
}



?>