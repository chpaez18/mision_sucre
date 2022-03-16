<?php 
$frm = new HTML();
$registros = $model->searchArrayByQuery("select * from carrera order by cod_carrera");
?>


<?= $frm->open_form(["method"=>"post","id"=>"formulario_grupos"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">
		<?= $frm->textInput($model, "nombre"); ?>

<br>
		<?= $frm->dropDownList("id_carrera",ArrayHelper::map($registros,'cod_carrera','nombre_carrera'), "<b>Carrera</b>","select_carrera")."<br>"; ?>

		<?= $frm->submitButton("Agregar", ["class"=>"btn"]); ?>
	</div>

<?= $frm->close_form(); ?>


<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_grupos').submit(function (e, params) {
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




