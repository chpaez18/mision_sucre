<?php 
$frm = new HTML();

$model_aldeas = new Aldea();

$zonas =  $model->getZonas($model->cod_aldea);
?>




	

	<div class="panel-head">
		<h3><?php echo $this->titulo . ": ". $model->nombre_aldea; ?></h3>
	</div>	


	<div class="body-content">

	<div class="panel">
		<label><b>Nombre de la Aldea:</b></label>
		<?= $model->nombre_aldea; ?><br>
		<br>

		<label><b>Ubicación:</b></label>
		<?= $model->ubicacion; ?> <br>
		<br>

		<label><b>Eje:</b></label>
		<?= $zonas; ?><br>
	</div>
		<br>
		<br>

		<center><p><b>Carreras Ofertadas:</b></p>
		<?php
			$result =  $model->getCarreras($model->cod_aldea);
			$count = count($result);

			if($result){

		?>

	<table id="datatables">
		<thead>
			<th width="30%">Nombre</th>
	        <th>Tipo</th>
	        <th>Acciones</th>
		</thead>

			<tbody>

						<?php
								foreach ($result as $key => $value){
									$aux = $result[$key]["cod_carrera"];
									if(Session::accesoViewEstricto(["1"])){
										$ver_carrera = "inline";
									}else{
										$ver_carrera = "none";
									}


									echo "<td>".$result[$key]["nombre_carrera"]."</td>";
									echo "<td>".$result[$key]["tipo"]."</td>";

									echo "
									<td  width='39%'>
										<a class='a-btn' style='display:".$ver_carrera."' href= '".ROUTER::create_action_url("carrera/view", [$result[$key]["cod_carrera"]])."'> 

											<i class='fa fa-eye'></i> <b>Ver</b>  
										</a>&nbsp;				

										

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
           window.location.href='<?= ROUTER::create_action_url("aldea/eliminarcarrera", [$result[$key]["cod_carrera"], $model->cod_aldea])?>';
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
								echo "Sin carrera(s) asignada(s).";
							}
						?>
			</tbody>
	</table>

</center>
<br><br>
	</div>



