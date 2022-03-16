<?php

/**
* 
*/
class ActiveRecord extends Model
{
	static $class;
	static $logueado;
	static $id_user;
	function __construct()
	{
		# code...
	}

	

	public static function validateTableFields(){
		$model = new ActiveRecord::$class;

		$fields = Model::getColumns($model->name); //obtenemos los campos de la tabla
		$index = (array) $fields;
		$campos_tabla = ArrayHelper::map($index, 'name', 'name'); //campos de la tabla

		foreach ($_POST as $key => $value) {
			if (array_key_exists($key, $campos_tabla)) {

			}else{

					if(property_exists(ActiveRecord::$class, $key)){
						
					}else{
						throw new Exception("El atributo $key no existe en la tabla",1);
						exit;
					}

			}
		}

		return true;
	}
}
?>