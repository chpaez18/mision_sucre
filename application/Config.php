<?php 
//definimos constantes que podremos usar en cualquier sitio
$ruta = getcwd();
$array = explode("\\", $ruta);
$last = array_pop($array);

$GLOBALS['a'] = 1;

define("FOLDER","$last");

define("BASE_URL", "localhost/".FOLDER."/");

define("BASE_URL_ACTION", "localhost/".FOLDER."/../../index.php?url=");

define("DEFAULT_CONTROLLER", "site");

define("DEFAULT_LAYOUT", "nuevo");

define("ADMIN_EMAIL", "carlos_al09@hotmail.com");

define("PASS_EMAIL", "Hija.106");


define("SESSION_TIME", 20);		//establecemos el tiempo minimo en sesion para el usuario, en este ejemplo dejamos 10 minutos

//definimos una constante cuyo valor sea un id unico, esto nos servira para poder recuperar contraseñas 
define("HASH_KEY","5956523ba385a");

define("DB_HOST","localhost");
define("DB_USER","postgres");
define("DB_PASS","clave12345");
define("DB_NAME","mision_sucre");
define("DB_CHAR","utf8");


?>