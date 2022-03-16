<?php 

/**
* 
*/
class Database extends PDO
{
	
	function __construct($user = false){
		$level = Session::get("level");

		if($level == 2){
			//para coordinadores accedemos con su respectivo usuario en base de datos
			$user = Session::get("usuario");
			$clave = "123456";
		}else{
			//usuario por default en base de datos
			$user = DB_USER;
			$clave = DB_PASS;
		}
		parent::__construct(
					'pgsql:host='.DB_HOST.
					';dbname='.DB_NAME,
					$user, 
					$clave 
					
		);
	}
}


?>