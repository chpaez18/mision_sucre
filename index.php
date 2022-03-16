<?php 

//declaramos unas constantes
define('DS',DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);
define('VIEWS', ROOT . 'views' . DS);
define('LIB', ROOT . 'views' . DS . 'layouts' . DS . 'default' . DS . 'lib' . DS);

try{
	require_once APP_PATH . 'Config.php';
	require_once APP_PATH . 'Router.php';
	require_once APP_PATH . 'Request.php';
	require_once APP_PATH . 'Bootstrap.php';
	require_once APP_PATH . 'Controller.php';
	require_once APP_PATH . 'Model.php';
	require_once APP_PATH . 'View.php';
	require_once APP_PATH . 'Database.php';
	require_once APP_PATH . 'Session.php';
	require_once APP_PATH . 'Hash.php';
	require_once APP_PATH . 'Utilities.php';
	//require_once LIB . 'pdf/mpdf.php';
	require_once LIB . 'php-mailer/src/PHPMailer.php';
	require_once LIB . 'php-mailer/src/Exception.php';
	require_once LIB . 'php-mailer/src/SMTP.php';

	//MODELOS DE HELPERS AUXILIARES
	require_once APP_PATH . 'ArrayHelper.php';
	require_once APP_PATH . 'BaseArrayHelper.php';
	require_once APP_PATH . 'ModelHtml.php';
	require_once APP_PATH . 'App.php';
	require_once APP_PATH . 'ActiveRecord.php';

	//REQUERIMOS LOS MODELOS DE LAS TABLAS PARA PODER USARLOS EN LOS CONTROLADORES TAMBIEN
	
	//Model::get(['Usuarios', 'Site']);

/*
echo '<pre>';
	print_r(get_required_files());
echo '</pre>';die();
*/

/*

con el metodo getHash reforzamos el encriptamiento de nuestras contraseñas

echo Hash::getHash("md5","tete",HASH_KEY); exit;

echo Hash::getHash("sha1","123456",HASH_KEY); exit;

*/

	//funcion para autocargar dinamicamente las clases
	function __autoload($clase){
		include ROOT.'models'.DS. $clase.".php";
		
	}

Session::init();
Bootstrap::run(new Request);


}catch(Exception $e){

	echo $e->getMessage();

}


?>