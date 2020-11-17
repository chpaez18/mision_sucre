<?php 
if(isset($id)){
  
   $listado_materias = $model->getMateriasEstudiante($id);  
   $estudiante = $model->searchArrayByQuery("select * from estudiante where cod_estudiante = $id");


}else{
    $id_user = $model->user()->cod_usuario;
    $estudiante = $model->searchArrayByQuery("select * from estudiante where usuario_cod_usuario = $id_user");
    $cod_estudiante = $estudiante[0]["cod_estudiante"];
    $listado_materias = $model->getMateriasEstudiante($cod_estudiante);
}
if($model->getPromedio($cod_estudiante)){
    $promedio = $model->getPromedio($cod_estudiante);
}else{
    $promedio = "0.0";
}



if(isset($listado_materias) && count ($listado_materias)):

$frm = new HTML();
$count = count($listado_materias);

endif;
?>

<center>

<center><h3><?= $this->titulo." del Triunfador(a): ".$estudiante[0]["nombre_estudiante"]." ".$estudiante[0]["apellido_estudiante"]; ?></h3></center>
<br>

<?php if(isset($listado_materias) && count ($listado_materias)):?>
<br>

<?php
$id_user = $model->user()->cod_usuario;

$carga_notas = $model->searchByQueryOne("select * from usuario where cod_usuario = $id_user");

$aux = $carga_notas->hab_carga_notas;

?>

<table id="datatables">

<thead>
    <tr>
        <th>Código Materia</th>
        <th>Nombre de la Materia</th>
        <th>Nota Final</th>
<?php if(Session::accesoViewEstricto(["2"])){ ?>
        
<?php if($aux == "1"){?>

<?php }else{
    echo "<th width='30%'>Acciones</th>";
    } ?>

<?php }?>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){
        $calificacion = $model->getCalificacion($listado_materias[$i]["cod_materia"],$cod_estudiante);
        
        if($calificacion != 0){
            $calificacion = $model->getCalificacion($listado_materias[$i]["cod_materia"],$cod_estudiante);
        }else{
            $calificacion = "0.0";
        }

        if($calificacion >= 0 and $calificacion <=11){
            $calificacion = "<center style='color:red'>".$model->getCalificacion($listado_materias[$i]["cod_materia"],$cod_estudiante)."</center>";
        }else{
            $calificacion = "<center style='color:blue'>".$model->getCalificacion($listado_materias[$i]["cod_materia"],$cod_estudiante)."</center>";
        }

        ?>
         <tr>
            <td><?php echo $listado_materias[$i]["codigo"]?></td>
            <td><?php echo $listado_materias[$i]["nombre_materia"]?></td>
            <td><?php echo ($calificacion)? $calificacion:"0.0"?></td>

<?php if(Session::accesoViewEstricto(["2"])){ ?>
    <?php if($aux == "1"){?>
    <?php }else{?>
            <td>
                <a href="<?php echo ROUTER::create_action_url("coordinador/cargar_nota", [$listado_materias[$i]["cod_materia"], $cod_estudiante]) ?>"><button class="btn"><i class="fa fa-share"></i><b>Cargar/Modificar Nota</b></button></a>

                <a href="<?php echo ROUTER::create_action_url("coordinador/eliminar_nota", [$listado_materias[$i]["cod_materia"], $cod_estudiante]) ?>"><button class="btn-danger"><i class="icon-trash"></i><b>Eliminar Nota</b></button></a> 

            </td>             

<?php }?>
<?php }?>
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