<?php
$registros = $model->searchArrayByQuery("select * from grupo order by cod_grupo");

$id_usuario = $model->user()->cod_usuario;
    
$coordinador = $model->searchByQueryOne("select * from coordinador where usuario_cod_usuario = $id_usuario");

$cod_aldea = $coordinador->aldea_cod_aldea;

$listado_aldeas = $model->searchArrayByQuery("select * from aldea where cod_aldea = $cod_aldea");


$cant_registros = count($registros);

if($registros){
?>

<br>
<body style="font-family: Arial; font-size: 12px">

	<div style="text-align: center;">
		<h3>Listado de Grupos de la Aldea: <b><i><?= $listado_aldeas[0]["nombre_aldea"] ;?></i></b></h3>
	</div>
<hr style="color:red">
<div class="container-fluid">

<table class="table table-dotted table-condensed">
	<thead class="thead-default">
	    <tr>
	        <th>Nombre del Grupo</th>
	        <th>Carrera</th>
	        <th>Número de Triunfadores(as)</th>
	    </tr>
	</thead>

	<tbody>
	        <?php for($i = 0; $i < $cant_registros; $i++){?>
	         <tr>
	            <td><?php echo $registros[$i]["nombre"]?></td>
            <td><?php echo $model->getCarreras($registros[$i]["id_carrera"]);?></td>
            <td><?php echo ($registros[$i]["capacidad"] > 1) ? $registros[$i]["capacidad"]." Triunfadores(as)":$registros[$i]["capacidad"]." Triunfadores(as)"?></td>
	        </tr>
	        <?php } ?>
	</tbody>

</table>
	
</div>
<?php
	}else{
?>
	<div class="container-fluid">
		!No hay grupos registrados!.
	</div>
<?php }?>

