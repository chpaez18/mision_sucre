<?php 
$frm = new HTML();
$x = 0;

$carreras = $model->searchByQuery("select * from carrera");
$count_carreras = count($carreras);

$carreras_select = $model->searchByQuery("select cod_carrera from aldea_carrera where cod_aldea = $model->cod_aldea ");
$count_total = count($carreras_select);


/*
echo '<pre>';
	print_r($carreras_select);
	
echo '</pre>';
die();
*/

?>




<form id="formulario_aldeas" method="post" action="<?php BASE_URL; ?>index.php?url=aldea/asig_carrera/<?= $model->cod_aldea?>">

	<div class="head">
		<center><h3><?php echo $this->titulo; ?> a la Aldea: <?= $model->nombre_aldea; ?></h3></center>
	</div>	

	<div class="body-content">

		<label for="select">Carreras:</label>

<?php if($count_total > 0){ ?>
		<select name="cod_carrera[]" multiple="multiple" id="select1">


			<?php while($x < $count_carreras){ ?>

				<?php 

					//realizamos un while general que es el contador de todas las carreras, seguido tenemos un while que es el contador de las carreras para la aldea en especifico, si encuentra coincidencia arma una variable con la palabra selected para mostrarlo y la $y la igualamos al contador para salir del ciclo, y empieze con la segunda materia del while general
					$y=0;
					 while($y < $count_total){
					 	if($count_total == 1){
							if($carreras_select["cod_carrera"] == $carreras[$x]["cod_carrera"]){ 
									$select = "selected";
									$y=$count_total;

								}else{ 
									$select = "";
									$y++;
								}
					 	}else{

						if($carreras_select[$y]["cod_carrera"] == $carreras[$x]["cod_carrera"]){ 
								$select = "selected";
								$y=$count_total;

							}else{ 
								$select = "";
								$y++;
							}
							
					 	}

					}			
				?>

				<option <?= $select ?> value="<?= $carreras[$x]["cod_carrera"]?>"><?= $carreras[$x]["nombre_carrera"]?></option>

			<?php $x++; }  ?>			
		</select>

<?php }else{?>

		<select name="cod_carrera[]" multiple="multiple" id="select1">
			<?php while($x < $count_carreras){ ?>
				
				<option value="<?= $carreras[$x]["cod_carrera"]?>"><?= $carreras[$x]["nombre_carrera"]?></option>

			<?php $x++; } ?>
		</select>
<?php } ?>


			<input type="hidden" name="cod_aldea" value="<?= $model->cod_aldea?>">
			<input type="submit" value="Asignar" class="btn">
		</p>
	</div>

<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_aldeas').submit(function (e, params) {
        var localParams = params || {};

        if (!localParams.send) {
            e.preventDefault();
        }

    swal({
            title: "¿Esta Seguro de que la información proporcionada es correcta?",
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


