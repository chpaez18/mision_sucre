<?php 
$frm = new HTML();
$registros = $model->searchArrayByQuery("select a.cod_aldea, a.nombre_aldea
from aldea a
where a.cod_aldea not in (select aldea_cod_aldea from coordinador) order by a.cod_aldea");
?>


<?= $frm->open_form(["method"=>"post","id"=>"formulario_coordinadores"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">
		<?= $frm->textInput($model, "ced_coordinador"); ?>

		<?= $frm->textInput($model, "nombre_coordinador"); ?>

		<?= $frm->textInput($model, "apellido_coordinador"); ?>
<br>
		<?= $frm->dropDownList("aldea_cod_aldea",ArrayHelper::map($registros,'cod_aldea','nombre_aldea'), "<b>Aldea</b>", "select_aldea"); ?>

		<?= $frm->submitButton("Agregar", ["class"=>"btn"]); ?>
	</div>

<?= $frm->close_form(); ?>






<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_coordinadores').submit(function (e, params) {
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






