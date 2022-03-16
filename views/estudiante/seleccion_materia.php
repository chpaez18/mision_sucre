<script type="text/javascript">

$(document).ready(function(){
  


$("#select_carrera").change(function(){
    var id = $("#select_carrera option:selected").attr('value');

    $.post("<?= ROUTER::create_action_url("estudiante/getGruposDropdown")?>", {id:id}, function(data){

	    	if(data){
	    		 $("#select_grupo").html(data);
    			 $('#select_grupo').removeAttr('disabled');
    			 $('#btn-1').removeAttr('disabled');
    			 
	    	}else{
	    		
	    		 $('#select_grupo').attr('disabled', 'disabled');
	    		 $("#select_grupo").html("");
	    		 $('#btn-1').attr('disabled', 'disabled');

	    	}

    	
    	
    });

});



});
</script>

<?php 
$frm = new HTML();

$trayectos = $model->searchArrayByQuery("select * from trayecto order by cod_trayecto");

$aldeas = $model->searchArrayByQuery("select * from aldea order by cod_aldea");

$carreras = $model->searchArrayByQuery("select * from carrera order by cod_carrera");
?>


<?= $frm->open_form(["method"=>"post", "id"=>"formulario_estudiantes"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">


		<?php if($model->user()->rol_cod_rol == 4 or $model->user()->rol_cod_rol == 1){ ?>

		<?= $frm->dropDownList("cod_aldea",ArrayHelper::map($aldeas,'cod_aldea','nombre_aldea'), "<b>Aldea</b>", "select_aldea")."<br>"; ?>

		<label><b>Año(aaaa)</b></label>
		<input type="text" name="ano">

		<?php } ?>

		<br>
		<?= $frm->dropDownList("cod_trayecto",ArrayHelper::map($trayectos,'cod_trayecto','descripcion'), "<b>Trayecto</b>", "select_trayecto")."<br>"; ?>

		<?= $frm->dropDownList("cod_carrera",ArrayHelper::map($carreras,'cod_carrera','nombre_carrera'), "<b>Carrera</b>","select_carrera")."<br>"; ?>
		

		<label><b>Grupo</b></label>
		<select name="cod_grupo" id="select_grupo" disabled>
			
		</select>

		<?php // $frm->dropDownList("cod_grupo",ArrayHelper::map($grupos,'cod_grupo','nombre'), "<b>Grupo</b>")."<br>"; ?>




		<?= $frm->submitButton("Continuar", ["class"=>"btn", "id"=>"btn-1", "disabled"=>"disabled"]); ?>
	</div>

<?= $frm->close_form(); ?>
