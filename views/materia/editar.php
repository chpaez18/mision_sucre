<?php 
$frm = new HTML();

?>


<?= $frm->open_form(["method"=>"post","id"=>"formulario_materias"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo . ": ". $model->nombre_materia; ?></h3></center>
	</div>	

	<div class="body-content">
		<?= $frm->textInput($model, "nombre_materia",["value"=>$model->nombre_materia]); ?>
		<br>
		<?= $frm->textInput($model, "codigo",["value"=>$model->codigo]); ?>

		<?= $frm->submitButton("Guardar", ["class"=>"btn"]); ?>
	</div>

<?= $frm->close_form(); ?>



<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_materias').submit(function (e, params) {
        var localParams = params || {};

        if (!localParams.send) {
            e.preventDefault();
        }

    swal({
            title: "¿Está Seguro de que la información proporcionada es correcta?",
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


