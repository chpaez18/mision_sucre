<?php

/*
$registros = $model->searchArrayByQuery("select e.cod_estudiante, me.cod_materia, g.nombre, e.nombre_estudiante, e.apellido_estudiante, e.cedula_estudiante, me.calificacion 
from estudiante e 
inner join materia_estudiante me on e.cod_estudiante = me.cod_estudiante 
inner join grupo_estudiante ge on ge.cod_estudiante = e.cod_estudiante 
inner join grupo g on g.cod_grupo = ge.cod_grupo 
where cod_materia = $model->cod_m and g.cod_grupo= $model->cod_g");
*/
$registros = $model->searchArrayByQuery("select t.descripcion, tc.ano, tc.periodo, c.nombre_carrera, g.nombre, m.cod_materia, m.nombre_materia, ge.cod_estudiante, e.cedula_estudiante, e.nombre_estudiante, e.apellido_estudiante, me.calificacion
FROM trayecto t
INNER JOIN  trayecto_carrera tc ON tc.cod_trayecto = t.cod_trayecto
INNER JOIN carrera c ON c.cod_carrera = tc.cod_carrera
INNER JOIN carrera_materia cm ON cm.cod_carrera = c.cod_carrera
INNER JOIN materia m ON m.cod_materia = cm.cod_materia
INNER JOIN materia_estudiante me ON me.cod_materia = m.cod_materia
INNER JOIN estudiante e ON e.cod_estudiante = me.cod_estudiante
INNER JOIN grupo_estudiante ge ON ge.cod_estudiante = e.cod_estudiante
INNER JOIN grupo g ON g.cod_grupo = ge.cod_grupo
WHERE t.cod_trayecto = $model->cod_t AND c.cod_carrera = $model->cod_c  AND g.cod_grupo = $model->cod_g 
ORDER BY me.cod_materia
");


$cant_registros = count($registros);



if($registros){
?>

<br>
<body style="font-family: Arial; font-size: 12px">

<div style="text-align: center;">
		<h3>Reporte de Calificaciones</h3>
	</div>

<hr style="color:red">
<div class="container-fluid">

<table class="table table-dotted table-condensed">
	<thead class="thead-default">
	    <tr>
	    	<th>Trayecto</th>
	    	<th>Periodo</th>
	    	<th>Grupo</th>
	        <th width="20%">Número de Cédula</th>
	        <th>Nombres</th>
	        <th>Apellidos</th>
	        <th>Materia</th>
	        <th width="10%">Nota Final</th>
	    </tr>
	</thead>

	<tbody>
	        <?php for($i = 0; $i < $cant_registros; $i++){
	        	$cod_materia = $registros[$i]["cod_materia"];
				$id = $registros[$i]["cod_estudiante"];
            	$calificacion = $model->getCalificacion($cod_materia,$id);
            	$leng = strlen($calificacion);

            	if($leng == 1){
            		$calificacion = "0".$calificacion;
            	}else{
            		$calificacion = $calificacion;
            	}
	        ?>
	         <tr>
	         	<td><?php echo $registros[$i]["descripcion"]?></td>
	         	<td><?php echo $registros[$i]["periodo"]?></td>
	         	<td><?php echo $registros[$i]["nombre"]?></td>
	            <td><?php echo $registros[$i]["cedula_estudiante"]?></td>
	            <td><?php echo $registros[$i]["nombre_estudiante"]?></td>
	            <td><?php echo $registros[$i]["apellido_estudiante"]?></td>
	            <td><?php echo $registros[$i]["nombre_materia"]?></td>
	            <td><?php echo $calificacion?></td>
	        </tr>
	        <?php } ?>
	</tbody>

</table>
	
</div>
<?php
	}else{
?>
	<div class="container-fluid">
		 <p><strong>¡No se han encontrado alumnos según los criterios especificados!</strong></p>
	</div>
<?php }?>

