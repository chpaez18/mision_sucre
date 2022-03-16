<?php 
$frm = new HTML();

$res = $model->getEstudiantesGrupos($model->cod_grupo);
$total = ($res) ? count($res):"0";

?>


<?php if($total >= $model->capacidad ){
	
	echo "<center class='error_mensaje'>Este Grupo ya alcanzó el máximo de triunfadores(as) asignados.</center><br>";

}else{
	echo "<center class='info_mensaje'>Este Grupo actualmente cuenta con: <b>$total</b> triunfador(es) asignado(s).</center><br>";
}


?>



<div class="panel-head">
		<h3><?php echo $this->titulo . ": ". $model->nombre; ?></h3>
	</div>	


	<div class="body-content">

	<div class="panel">
		<label><b>Nombre del Grupo:</b></label>
		<?= $model->nombre; ?><br>
		<br>		

		<label><b>Número de Estudiantes:</b></label>
		<?= $model->capacidad; ?><br>
		<br>		


		<label><b>Carrera:</b></label>
		<?= $model->getCarreras($model->id_carrera); ?><br>
	</div>

	<br>
	<br>
		<center><p><b>Triunfadores Asignados:</b></p>


			<?php 

				$row = $model->getEstudiantes($model->cod_grupo);
				$count = count($row);

				if($row){ 
			?>
	<table id="datatables">
		<thead>
			<th><b>Número de Cédula</b></th>
			<th><b>Nombre</b></th>
			<th><b>Apellido</b></th>
			<th><b>Acciones</b></th>

		</thead>

			<tbody>
						<?php
								foreach ($row as $key => $value){
									$aux = $row[$key]["cod_estudiante"];
									echo "<tr>  <td>".$row[$key]["cedula_estudiante"]."</td>";
									echo "<td>".$row[$key]["nombre_estudiante"]."</td>";
									echo "<td>".$row[$key]["apellido_estudiante"]."</td>";
									

									if(Session::accesoViewEstricto(["1"])){
										$visible = "inline";
										$visible_materia = "none";
										$cargar_nota = "inline";
									}else{
										$visible = "none";
										$visible_materia = "inline";
										$cargar_nota = "none";
									}

									
									echo "
									<td  width='39%'>
										<a class='a-btn' href= '".ROUTER::create_action_url("estudiante/view", [$row[$key]["cod_estudiante"]])."'>

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
           window.location.href='<?= ROUTER::create_action_url("grupo/eliminardelgrupo", [$row[$key]["cod_estudiante"], $model->cod_grupo])?>';
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
								echo "Sin Triunfadores(s) asignado(s).";
							}
						?>
			</tbody>
	</table>

</center>
<br><br>
	</div>

