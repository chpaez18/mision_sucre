<?php 
$frm = new HTML();
$registros = $model->searchArrayByQuery("select * from zona order by cod_zona");
?>


<?= $frm->open_form(["method"=>"post","id"=>"formulario_aldeas"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo . ": ". $model->nombre_aldea; ?></h3></center>
	</div>	

	<div class="body-content">
		<?= $frm->textInput($model, "nombre_aldea",["value"=>$model->nombre_aldea]); ?>

		<?= $frm->textInput($model, "ubicacion",["value"=>$model->ubicacion]); ?>

		<br>
		<?= $frm->dropDownList("id_zona",ArrayHelper::map($registros,'cod_zona','descripcion'), "<b>Eje</b>","select_eje",0, $model->id_zona); ?> 

		<?= $frm->submitButton("Guardar", ["class"=>"btn"]); ?>
	</div>

<?= $frm->close_form(); ?>


<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_aldeas').submit(function (e, params) {
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


