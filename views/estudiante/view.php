<?php 
$frm = new HTML();

$fecha_formateada = date("d-m-Y", strtotime($model->fecha_nacimiento));
?>



<div class="panel-head">
		<h3><?php echo $this->titulo; ?></h3>
	</div>	

	
	<div class="body-content">
		
	<div class="panel">
		<label><b>Número de Cédula:</b></label>
		<?= $model->cedula_estudiante; ?><br>
		<br>		

		<label><b>Nombres y Apellidos:</b></label>
		<?= $model->nombre_estudiante . " " . $model->apellido_estudiante ; ?><br>
		<br>

		<label><b>Fecha de Nacimiento:</b></label>
		<?= $fecha_formateada; ?> <br>
		<br>

		<label><b>Género:</b></label>
		<?=( $model->sexo_estudiante != "M") ? "Femenino":"Masculino"; ?><br>
		<br>		

		<label><b>Estado Civil:</b></label>
		<?= $model->estado_civil_estudiante; ?><br>
		<br>		

		<label><b>Lugar de Nacimiento:</b></label>
		<?= $model->lugar_nacimiento_estudiante; ?><br>
		<br>		

		<label><b>Correo Eléctronico:</b></label>
		<?= $model->correo_estudiante; ?><br>
		<br>

		<label><b>Teléfono Celular:</b></label>
		<?= $model->celular_estudiante; ?><br>
		<br>		

		<label><b>Teléfono Habitación:</b></label>
		<?= ($model->tlf_local_estudiante != NULL) ? $model->tlf_local_estudiante:"Sin especificar"; ?><br>
		<br>		

		<label><b>Dirección:</b></label>
		<?= $model->direccion_estudiante; ?><br>
	</div>
	<br>
	<br>


	</div>



