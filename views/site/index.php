<?php 
$frm = new HTML();

$model = new Site();

/**********************************************************************************************
								BUSQUEDAS POR ABSTRACCIÓN DE MODELO

en esta busqueda se devolvera un objeto en caso de existir 2 registros este devolvera solo 1
$res = Site::find()->one();


en esta busqueda se devolvera un arreglo con todos los registros
$res = Site::find()->all();


en esta busqueda se aplica una condicion y la funcion devolvera un objeto en caso de existir 2 registros este devolvera siempre el primero
$res = Site::find()->where(["nom_usuario"=>"emaniger"])->one();


en esta busqueda se devolvera un arreglo con todos los registros
$res = Site::find()->where(["rol_cod_rol"=>1])->all();


busqueda mas especifica que se le concatena un and para gregar otra condicion, siempre retornara 1 registro
$res = Site::find()->where(["rol_cod_rol"=>1])->and(["nom_usuario"=>"chpaez"]);


busqueda mas general, donde se le puede agregar una condicion e igual se puede retornar un arreglo con varios registros
$res = $model->findAll(["rol_cod_rol"=>1]);


busqueda mas especifica donde se le puede agregar una condicion además de un and para especificar más la consulta, retornara 1 registro
$res = $model->findAll(["nom_usuario"=>"emaniger"])->and(["rol_cod_rol"=>3]);



traer informacion del usuario logueado
$model->user()->nom_usuario; en este caso trae el nombre del usuario


$preguntas_secretas = [
        ['id' => '1', 'pregunta' => '¿Donde nacio su madre?'],
        ['id' => '2', 'pregunta' => '¿Marca de vehiculo favorita?'],
        ['id' => '3', 'pregunta' => '¿Ciudad que siempre ha querido visitar?'],
     ];

$arreglo = ArrayHelper::map($preguntas_secretas,'id','pregunta');


$res = Site::find()->all();

echo '<pre>';
	print_r();
echo '</pre>';

***********************************************************************************************/

$id = $model->user()->cod_usuario;
if($model->user()->rol_cod_rol == 2){
    $registros = $model->searchArrayByQuery("select * from coordinador where usuario_cod_usuario = $id");
    $nombre = $registros[0]["nombre_coordinador"] . " " . $registros[0]["apellido_coordinador"];
}elseif($model->user()->rol_cod_rol == 3){

    $registros = $model->searchArrayByQuery("select * from estudiante where usuario_cod_usuario = $id");
    $nombre = $registros[0]["nombre_estudiante"] . " " . $registros[0]["apellido_estudiante"];
    if(!$registros[0]["nombre_estudiante"] and !$registros[0]["apellido_estudiante"]){
        $nombre = "Debe Completar sus Datos Personales";
    }

}elseif($model->user()->rol_cod_rol == 1){
    $nombre = "Coordinador Misión Sucre CUFM"; 
}elseif($model->user()->rol_cod_rol == 4){
    $nombre = "Control de Estudios CUFM"; 
}

?>


<center class = "bienvenida" ><h1><i>Bienvenido(a), <?= $nombre?></i></h1></center>

<img class="img-bienvenida" width="100%" src="<?php echo $_layoutParams['ruta_img']?>imagen-bienvenida_prop2.png" >
                
            

                 
             
        

            
