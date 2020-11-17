<?php 
if(isset($id)){
  
   $listado_materias = $model->getMateriasEstudiante($id);  
   $estudiante = Estudiante::find()->where(["cod_estudiante" =>$id])->one();

}else{
    $id_user = $model->user()->cod_usuario;
    $estudiante = Estudiante::find()->where(["usuario_cod_usuario" =>$id])->one();

    $cod_estudiante = $estudiante->cod_estudiante;

    $listado_materias = $model->getMateriasEstudiante($cod_estudiante);
}
$promedio = $model->getPromedio($estudiante->cod_estudiante);


if(isset($listado_materias) && count ($listado_materias)):

$frm = new HTML();
$count = count($listado_materias);

endif;
?>

<center>

<center><h3><?= $this->titulo." del Alumno: ".$estudiante->nombre_estudiante." ".$estudiante->apellido_estudiante; ?></h3></center>
<br>

<?php if(isset($listado_materias) && count ($listado_materias)):?>
<br>


<table id="datatables">

<thead>
    <tr>
        <th>Código Materia</th>
        <th>Nombre de la Materia</th>
        <th>Nota Final</th>
        <th width='30%'>Acciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){
        $calificacion = $model->getCalificacion($listado_materias[$i]["cod_materia"],$estudiante->cod_estudiante);

        ?>
         <tr>
            <td><?php echo $listado_materias[$i]["cod_materia"]?></td>
            <td><?php echo $listado_materias[$i]["nombre_materia"]?></td>
            <td><?php echo ($calificacion)? $calificacion:"0.0"?></td>


            <td>
                <a href="<?php echo ROUTER::create_action_url("coordinador/cargar_nota", [$listado_materias[$i]["cod_materia"], $estudiante->cod_estudiante]) ?>"><button class="btn"><i class="fa fa-share"></i><b>Cargar/Modificar Nota</b></button></a>

                <a href="<?php echo ROUTER::create_action_url("coordinador/eliminar_nota", [$listado_materias[$i]["cod_materia"], $estudiante->cod_estudiante]) ?>"><button class="btn-danger"><i class="icon-trash"></i><b>Eliminar Nota</b></button></a> 

            </td>             

            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
        </tr>
        <?php } ?>

</tbody>

<tr>
    <td colspan="2"><b>Promedio Académico</b></td>
    <td colspan="2"><?php echo ($promedio)? $promedio:"0.0"?></td>
</tr>

</table>

<br>

<?php else:?>
    <p><strong>No tiene materias inscritas</strong></p>

<?php endif;?>

</center>
<br>