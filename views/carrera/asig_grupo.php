<?php 
$frm = new HTML();
$x = 0;
$grupos = $model->grupos_sin_carrera();
$count_grupos = count($grupos);

$grupos_select = $model->searchArrayByQuery("select cod_grupo from carrera_grupo where cod_carrera =  $model->cod_carrera ");
$count_total = count($grupos_select);


?>

<form id="formulario_carreras" method="post" action="<?php BASE_URL; ?>index.php?url=carrera/asig_grupo/<?= $model->cod_carrera?>">
	

	<div class="head">
		<center><h3><?php echo $this->titulo; ?> a la carrera: <?= $model->nombre_carrera; ?></h3></center>
	</div>	

	<div class="body-content">

		<label for="select">Grupos:</label>

<?php if($count_total > 0){ ?>

		<select name="cod_grupo[]" multiple="multiple" id="select1">
			<?php while($x < $count_grupos){ ?>

				<?php 

					$y=0;
					 while($y < $count_total){
					 	if($count_total == 1){
							if($grupos_select["cod_grupo"] == $grupos[$x]["cod_grupo"]){ 
									$select = "selected";
									$y=$count_total;

								}else{ 
									$select = "";
									$y++;
								}
					 	}else{
							if($grupos_select[$y]["cod_grupo"] == $grupos[$x]["cod_grupo"]){ 
								$select = "selected";
								$y=$count_total;

							}else{ 
								$select = "";
								$y++;
							}
					 	}
					}			
				?>

				<option <?= $select ?> value="<?= $grupos[$x]["cod_grupo"]?>"><?= $grupos[$x]["nombre"]?></option>

			<?php $x++; } ?>
		</select>
<?php }else{?>

		<select name="cod_grupo[]" multiple="multiple" id="select1">
			<?php while($x < $count_grupos){ ?>
				
				<option value="<?= $grupos[$x]["cod_grupo"]?>"><?= $grupos[$x]["nombre"]?></option>

			<?php $x++; } ?>
		</select>
<?php } ?>
		
		<input type="hidden" name="cod_carrera" value="<?= $model->cod_carrera?>">
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


