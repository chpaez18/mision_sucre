<?php 
$frm = new HTML();
$x = 0;
$materias = $model->searchArrayByQuery("select * from materia");
$count_materias = count($materias);


$materias_select = $model->searchArrayByQuery("select cod_materia from carrera_materia where cod_carrera = $model->cod_carrera ");
$count_total = count($materias_select);









?>

<form id="formulario_carreras" method="post" action="<?php BASE_URL; ?>index.php?url=carrera/asig_materia/<?= $model->cod_carrera?>">
	

	<div class="head">
		<center><h3><?php echo $this->titulo; ?> a la Carrera: <?= $model->nombre_carrera; ?></h3></center>
	</div>	

	<div class="body-content">

		<label for="select">Materias:</label>

		
		<?php if($count_total > 0){ ?>
				<select name="cod_materia[]" multiple="multiple" id="select1">
					<?php while($x < $count_materias){ ?>

						<?php 

							$y=0;
							 while($y < $count_total){

							 	if($count_total == 1){
									if($materias_select["cod_materia"] == $materias[$x]["cod_materia"]){ 
											$select = "selected";
											$y=$count_total;

										}else{ 
											$select = "";
											$y++;
										}
							 	}else{
									if($materias_select[$y]["cod_materia"] == $materias[$x]["cod_materia"]){ 
											$select = "selected";
											$y=$count_total;

									}else{ 
										$select = "";
										$y++;
									}							 		
							 	}
							}			
						?>

						<option <?= $select ?> value="<?= $materias[$x]["cod_materia"]?>"><?= $materias[$x]["nombre_materia"]?></option>

					<?php $x++; } ?>
				</select>
		<?php }else{?>

				<select name="cod_materia[]" multiple="multiple" id="select1">
					<?php while($x < $count_materias){ ?>
						
						<option value="<?= $materias[$x]["cod_materia"]?>"><?= $materias[$x]["nombre_materia"]?></option>

					<?php $x++; } ?>
				</select>

		<?php } ?>
		
		<input type="hidden" name="cod_carrera" value="<?= $model->cod_carrera;?>">
			<input type="submit" value="Asignar" class="btn">
		</p>
	</div>



<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_carreras').submit(function (e, params) {
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





