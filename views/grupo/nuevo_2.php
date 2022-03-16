<?php 
$frm = new HTML();

$carreras = $model->searchByQuery("select * from carrera");
$count_carreras = count($carreras);
?>


<?= $frm->open_form(["method"=>"post","id"=>"formulario_grupos_2"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">
		<?= $frm->textInput($model, "nombre"); ?>

		<?= $frm->hiddenInput($model, "capacidad",["value"=>"45"]); ?>

		<br>
		<br>
		<label><b>Carrera(s)</b></label>
		<select name="cod_carrera[]" multiple="multiple" id="select1">


			<?php $x=0; while($x < $count_carreras){ ?>

				<option value="<?= $carreras[$x]["cod_carrera"]?>"><?= $carreras[$x]["nombre_carrera"]?></option>

			<?php $x++; }  ?>			
		</select>


		<?= $frm->submitButton("Agregar", ["class"=>"btn"]); ?>
	</div>

<?= $frm->close_form(); ?>



<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_grupos_2').submit(function (e, params) {
        var localParams = params || {};

        if (!localParams.send) {
            e.preventDefault();
        }

    swal({
            title: "¿Está Seguro de que la información proporcionada es correcta?",
	        text: "",
	        type: "info",
	        showCancelButton: true,
	        confirmButtonColor: "#6A9944",
	        confirmButtonText: "Si",
	        cancelButtonText: "Cancelar",
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



