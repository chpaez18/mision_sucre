<?php
$frm = new HTML();

$preguntas_secretas = [
        ['id' => '1', 'pregunta' => '¿Dónde nació su madre?'],
        ['id' => '2', 'pregunta' => 'Marca de vehículo favorita'],
        ['id' => '3', 'pregunta' => 'Ciudad que siempre ha querido visitar'],
     ];
?>
<form id="formulario_usuarios" name="form1" method="post" action="">


	<div class="head"><center><h3><?php echo $this->titulo; ?></h3></center></div>

	<div class="body-content">


		<?= $frm->dropDownList("preg_secreta",ArrayHelper::map($preguntas_secretas,'id','pregunta'), "<b>Pregunta Secreta </b>", "select_pregunta"); ?>
<br>
		<?= $frm->passwordInput($model, "resp_secreta",["id"=>"respuesta"]); ?>

<br>
		<p>
			<label><b>Confirmar Respuesta</b></label>
			<input type="password" name="confirmar_respuesta">
		</p>		

		<p>
			<input type="submit" value="Guardar" class="btn">
		</p>
		
	</div>


</form>


<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_usuarios').submit(function (e, params) {
        var localParams = params || {};

        if (!localParams.send) {
            e.preventDefault();
        }

    swal({
            title: "¿Está seguro de que la información proporcionada es correcta?",
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

