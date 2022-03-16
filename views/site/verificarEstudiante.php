<?php
$frm = new HTML();

$nacionalidad = [
        ['id' => 'V', 'descripcion' => 'V'],
        ['id' => 'E', 'descripcion' => 'E'],
        ['id' => 'P', 'descripcion' => 'P'],
     ];
?>

<form id="formulario_registro" method="post" action="<?php BASE_URL; ?>index.php?url=site/verificarEstudiante">
	
	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">


		<?= $frm->dropDownList("nac",ArrayHelper::map($nacionalidad,'id','descripcion'), "<b>Nacionalidad:</b>", "select_nac"); ?>			
<br>
		<p><b>Número del Documento</b></p>
		<input type="text" name="cedula">

			<input type="submit" value="Consultar" class="btn">
		</p>
	</div>


</form>

