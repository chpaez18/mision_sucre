<?php 
$frm = new HTML();

?>


<?= $frm->open_form(["method"=>"post","id"=>"formulario_profesores"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo . ": ". $model->nombre_profesor; ?></h3></center>
	</div>	

	<div class="body-content">
		<?= $frm->textInput($model, "ced_profesor",["value"=>$model->ced_profesor,"readonly"=>"readonly"]); ?>

		<?= $frm->textInput($model, "nombre_profesor",["value"=>$model->nombre_profesor]); ?>

		<?= $frm->textInput($model, "apellido_profesor",["value"=>$model->apellido_profesor]); ?>
		
		<?= $frm->submitButton("Guardar", ["class"=>"btn"]); ?>
	</div>

<?= $frm->close_form(); ?>





<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_profesores').submit(function (e, params) {
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


