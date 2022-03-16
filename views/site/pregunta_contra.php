<?php 
$pregunta = $_GET["id"]; 
$id_user = $_GET["user"]; 

?>


<form id="formulario_login" name="form1" method="post" action="">


	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">
	
	<?php switch ($pregunta) {
		case 1:

			?>
		<p>
			<label><b>¿Dónde nació su madre?</b></label>
			<input type="password" name="respuesta">
			<input type="hidden" name="id_user" value="<?=$id_user?>">
		</p>	

			<?php
			break;
		
		case 2:

			?>
		<p>
			<label><b>Marca de vehículo favorita</b></label>
			<input type="password" name="respuesta">
			<input type="hidden" name="id_user" value="<?=$id_user?>">
		</p>	

			<?php
			break;

		case 3:

			?>
		<p>
			<label><b>Ciudad que siempre ha querido visitar</b></label>
			<input type="password" name="respuesta">
			<input type="hidden" name="id_user" value="<?=$id_user?>">
		</p>	

			<?php

			break;

	}
	?>

		<p>
			<input type="submit" value="Continuar" class="btn">
		</p>		
	</div>


</form>