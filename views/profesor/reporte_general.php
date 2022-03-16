<?php
$registros = $model->searchArrayByQuery("select * from profesor order by cod_profesor");
$cant_registros = count($registros);

if($registros){
?>

<br>
<body style="font-family: Arial; font-size: 12px">

	<div style="text-align: center;">
		<h3>Listado de Profesores Registrados</h3>
	</div>
<hr style="color:red">
<div class="container-fluid">

<table class="table table-dotted table-condensed">
	<thead class="thead-default">
	    <tr>
	        <th>Número de Cédula</th>
	        <th>Nombres</th>
	        <th>Apellidos</th>
	        <th width="30%">Materia(s) Asignada(s)</th>
	    </tr>
	</thead>

	<tbody>
	        <?php for($i = 0; $i < $cant_registros; $i++){?>
	         <tr>
	            <td><?php echo $registros[$i]["ced_profesor"]?></td>
	            <td><?php echo $registros[$i]["nombre_profesor"]?></td>
	            <td><?php echo $registros[$i]["apellido_profesor"]?></td>
	            <td>
	            	<?php 
	            		$materias = $model->getMateriasProfesor($registros[$i]["cod_profesor"]);
	            		$cant_materias = count($materias);
	            		$x = 0;

	            		while($x < $cant_materias){
	            			if($cant_materias == 1){
	            				$separador = "";
	            			}else{
	            				$separador = ", ";
	            			}

	            			echo ($materias) ? $materias[$x]["nombre_materia"].$separador:"Sin Materia(s)";
	            			$x++;
	            		}
	            ?>
	            </td>
	        </tr>
	        <?php } ?>
	</tbody>

</table>
	
</div>
<?php
	}else{
?>
	<div class="container-fluid">
		!No hay profesores registrados!.
	</div>
<?php }?>

