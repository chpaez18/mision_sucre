<?php 
$frm = new HTML();
$x = 0;


$estudiantes =  $model->searchArrayByQuery("select * from estudiante where inscripcion_formalizada = 't' and estatus = 'A'");
$count_estudiantes = count($estudiantes);

$estudiantes_select = $model->searchByQuery("select cod_estudiante from grupo_estudiante where cod_grupo = $model->cod_grupo");
$count_total = count($estudiantes_select);

/*
echo '<pre>';
	print_r("carrera_select=".$aldeas_select[0]["cod_carrera"]);
	print_r("carrera_normal=".$carreras[0]["cod_carrera"]);
echo '</pre>';
die();
*/

$res = $model->getEstudiantesGrupos($model->cod_grupo);
$total = ($res) ? count($res):"0";
if($total >= $model->capacidad ){
	echo "<center class='error_mensaje'>Este Grupo ya alcanzó el máximo de Triunfadores(as) asignados(as)</center>";
}else{

?>


<center class='info_mensaje'><b>¡Atención!</b> En la lista de selección, figurarán solo aquellos Triunfadores(as) cuya inscripción haya sido debidamente formalizada.</center>
<br>

<form id="formulario_grupos" method="post" action="<?php BASE_URL; ?>index.php?url=grupo/asig_estudiante/<?= $model->cod_grupo?>">
	
	<div class="head">
		<center><h3><?php echo $this->titulo; ?> al grupo: <?= $model->nombre; ?></h3></center>
	</div>	

	<div class="body-content">

		<label for="select">Triunfadores(as):</label>

<?php if($count_total > 0){ ?>
		<select name="cod_estudiante[]" multiple="multiple" id="select1">


			<?php while($x < $count_estudiantes){ ?>

				<?php 

					$y=0;

					 while($y < $count_total){

						if($count_total == 1){
							if($estudiantes_select["cod_estudiante"] == $estudiantes[$x]["cod_estudiante"]){ 
								$select = "selected";
								$y=$count_total;

							}else{ 
								$select = "";
								$y++;
							}
						}else{
							if($estudiantes_select[$y]["cod_estudiante"] == $estudiantes[$x]["cod_estudiante"]){ 
								$select = "selected";
								$y=$count_total;

							}else{ 
								$select = "";
								$y++;
							}
						}
					}			
				?>

				<option <?= $select ?> value="<?= $estudiantes[$x]["cod_estudiante"]?>"><?= $estudiantes[$x]["cedula_estudiante"]."/".$estudiantes[$x]["nombre_estudiante"]." ".$estudiantes[$x]["apellido_estudiante"]?></option>

			<?php $x++; }  ?>			
		</select>

<?php }else{?>

		<select name="cod_estudiante[]" multiple="multiple" id="select1">
			<?php while($x < $count_estudiantes){ ?>
				
				<option value="<?= $estudiantes[$x]["cod_estudiante"]?>"><?= $estudiantes[$x]["cedula_estudiante"]."/".$estudiantes[$x]["nombre_estudiante"]." ".$estudiantes[$x]["apellido_estudiante"]?></option>

			<?php $x++; } ?>
		</select>
<?php } ?>


		<input type="hidden" name="cod_grupo" value="<?= $model->cod_grupo; ?>">
			<input type="submit" value="Asignar" class="btn">
		</p>
	</div>
<?php }?>



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

