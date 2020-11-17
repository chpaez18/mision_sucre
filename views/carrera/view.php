<?php 
$frm = new HTML();

?>



<div class="panel-head">
		<h3><?php echo $this->titulo . ": ". $model->nombre_carrera; ?></h3>
	</div>	


	<div class="body-content">

	<div class="panel">
		<label><b>Nombre de la Carrera:</b></label>
		<?= $model->nombre_carrera; ?><br>
	</div>
		<br>
		<br>

		<center><p><b>Materias para esta Carrera:</b></p>
		<?php 
			$row =  $model->getMaterias($model->cod_carrera);
			$count = count($row);

			if($row){

		?>

	<table id="datatables">
		<thead>
			<th><b>Código Materia</b></th>
			<th><b>Nombre</b></th>
			<th><b>Acciones</b></th>
		</thead>

			<tbody>

						<?php
								foreach ($row as $key => $value){

									$aux = $row[$key]["cod_materia"];
									echo "<tr> <td>".$row[$key]["codigo"]."</td>";
									echo "<td>".$row[$key]["nombre_materia"]."</td>";
									echo "
									<td  width='39%'>

										<button id='boton_eliminar$aux' class='btn-danger'>
											<i class='icon-trash'></i><b>Eliminar</b>
										</button>


									</td>

									</tr>";
?>
<script type="text/javascript">
$(document).ready(function() {

$("#datatables").on("click",".btn-danger", function(){
$('#boton_eliminar<?=$aux?>').click(function(){
    swal({
        title: "¿Está Seguro de querer eliminar este registro?",
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
           window.location.href='<?= ROUTER::create_action_url("carrera/eliminarmateria", [$row[$key]["cod_materia"], $model->cod_carrera])?>';
        } else {

         }
    });
});
})


});
</script>

<?php									
								}

							}else{
								echo "Sin materia(s) asignada(s).";
							}
						?>
			</tbody>
	</table>
</center>
<br><br>


	</div>




