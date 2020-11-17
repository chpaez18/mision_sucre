<?php 
$frm = new HTML();

$materias = $model->searchArrayByQuery("select * from materia");
$trayectos = $model->searchArrayByQuery("select * from trayecto");

$periodo = [
        ['id' => '1', 'descripcion' => 'I'],
        ['id' => '2', 'descripcion' => 'II'],
        ['id' => '3', 'descripcion' => 'III'],
     ];


?>


<?= $frm->open_form(["method"=>"post","id"=>"formulario_grupos"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">
		
		<label><b>Año</b></label>
		<input type="text" name="ano">

		<br>

		<?= $frm->dropDownList("cod_trayecto",ArrayHelper::map($trayectos,'cod_trayecto','descripcion'), "<b>Trayecto</b>","select_trayecto")."<br>"; ?>
	

		<?= $frm->dropDownList("periodo",ArrayHelper::map($periodo,'id','descripcion'), "<b>Período</b>","select_periodo")."<br>"; ?>

		<?= $frm->dropDownList("cod_materia",ArrayHelper::map($materias,'cod_materia','nombre_materia') ,"<b>Materia</b>","select_materia")."<br>"; ?>
		<?= $frm->submitButton("Asignar", ["class"=>"btn"]); ?>
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


