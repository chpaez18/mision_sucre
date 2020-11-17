<?php
$frm = new HTML();

$nacionalidad = [
        ['id' => 'V', 'descripcion' => 'V'],
        ['id' => 'E', 'descripcion' => 'E'],
        ['id' => 'P', 'descripcion' => 'P'],
     ];
?>
<form id="formulario_coordinadores" method="post" action="<?php BASE_URL; ?>index.php?url=coordinador/registrarCedula">
	
	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">

		<?= $frm->dropDownList("nac",ArrayHelper::map($nacionalidad,'id','descripcion'), "<b>Nacionalidad:</b>","select_nac"); ?>			
<br>
		<p><b>Número del Documento</b></p>
		<input type="text" name="cedula">			

<br>
		<p><b>Correo Electrónico</b></p>
		<input type="text" name="correo">		

			<input type="submit" value="Registrar" class="btn">
		</p>
	</div>


</form>



<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_coordinadores').submit(function (e, params) {
        var localParams = params || {};

        if (!localParams.send) {
            e.preventDefault();
        }

    swal({
            title: "¿Esta Seguro de que la información proporcionada es correcta?",
	        text: "",
	        type: "warning",
	        showCancelButton: true,
	        confirmButtonColor: "#0275d8",
	        confirmButtonText: "Si",
	        cancelButtonText: "Cancelar",
	        cancelButtonColor: "#d9534f",
	        closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {

                    $(e.currentTarget).trigger(e.type, { 'send': true });
                } else {

              //additional run on cancel  functions can be done hear

            }
        });
});

});
</script>


