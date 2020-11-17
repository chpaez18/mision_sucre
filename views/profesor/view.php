<?php 
$frm = new HTML();

?>



<div class="head">
		
	</div>	
<br>

	<div class="body-content">

	<div class="panel-head">
		<h3><?php echo $this->titulo . ": ". $model->nombre_profesor." ". $model->apellido_profesor; ?></h3>
	</div>

	<div class="panel">
		<label><b>Nombre del Profesor:</b></label>
		<?= $model->nombre_profesor." ".$model->apellido_profesor; ?><br>
	</div>

<br>

		<center><p><b>Materias Asignadas:</b></p>
		<?php 
			$row = $model->getInfoProfesor($model->cod_profesor);
			$count = count($row);

			if($row){

		?>
	<table id="datatables">
		<thead>
			<th><b>Materia</b></th>
			<th><b>Carrera</b></th>
			<th><b>Grupo</b></th>
		</thead>

			<tbody>

						<?php
								foreach ($row as $key => $value){
									echo "<td>".$row[$key]["materia"]."</td>";
									echo "<td>".$row[$key]["carrera"]."</td>";
									echo "<td>".$row[$key]["grupo"]."</td>";

									echo "
									</tr>";
								}

							}else{
								echo "Sin Información.";
							}
						?>
			</tbody>
	</table>
</center>
<br><br>
	</div>















