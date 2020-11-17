<?php 
 $listado_grupos = $model->searchArrayByQuery("select * from grupo order by cod_grupo");



if(isset($listado_grupos) && count ($listado_grupos)):

$frm = new HTML();
$count = count($listado_grupos);

endif;
?>

<div class="contenido-index">

<div class="contenido-alineado-izquierda">
    <legend><h3><?= $this->titulo; ?></h3></legend>
</div>

<?php 
echo "
<div  style='display:inline;float:right'>
    <a href=".ROUTER::create_action_url("grupo/nuevo")."><button class='btn'><i class='fa fa-plus' aria-hidden='true'></i> <b> Agregar Grupo </b></button></a></div>&nbsp;";

    echo "
<div  style='display:inline; float:right; margin-right:13px'>
    <a href=".ROUTER::create_action_url("grupo/reporte")."><button class='btn'><i class='fa fa-download' aria-hidden='true'></i> <b> Generar Reporte General </b></button></a></div>";
?>

<br>
<br>

<center>


<?php if(isset($listado_grupos) && count ($listado_grupos)):?>
<br>


<table id="datatables">

<thead>
    <tr>
        <!-- <th>cod_grupo</th> -->
        <th width="20%">Nombre del Grupo</th>
        <th>Carrera</th>
        <th>Número Estudiantes</th>
        <th>Acciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){?>
         <tr>
            <!--<td><?php  //$listado_grupos[$i]["cod_grupo"]?></td>-->
            <td><?php echo $listado_grupos[$i]["nombre"]?></td>
            <td><?php echo $model->getCarreras($listado_grupos[$i]["id_carrera"]);?></td>
            <td><?php echo $listado_grupos[$i]["capacidad"]?></td>

            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
            <td width="39%">

                <a href="<?php echo ROUTER::create_action_url("grupo/view", [$listado_grupos[$i]["cod_grupo"]]) ?>"><button class="btn"><i class="fa fa-eye"></i><b> Ver</b></button></a>

                <a href="<?php echo ROUTER::create_action_url("grupo/editar", [$listado_grupos[$i]["cod_grupo"]]) ?>"><button class="btn"><i class="icon-edit"></i><b>Editar</b></button></a> 

<?php if(Session::accesoView("2")){ ?>
                <a href="<?php echo ROUTER::create_action_url("grupo/asig_materia", [$listado_grupos[$i]["cod_grupo"]]) ?>"><button class="btn"><i class="fa fa-share"></i><b>Asig. Materia</b></button></a>
                
                <a href="<?php echo ROUTER::create_action_url("grupo/asig_estudiante", [$listado_grupos[$i]["cod_grupo"]]) ?>"><button class="btn"><i class="fa fa-share"></i><b>Asig. Triunfador(a)</b></button></a>
<?php }?>

<?php if(Session::accesoViewEstricto(["1","2"])){ ?>
                

                <button id="boton_eliminar<?=$i?>" class="btn-danger"><i class="icon-trash"></i><b>Eliminar</b></button>
<?php }?>

            </td>

<script type="text/javascript">
$(document).ready(function() {

$("#datatables").on("click",".btn-danger", function(){
$('#boton_eliminar<?=$i?>').click(function(){
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
           window.location.href='<?= ROUTER::create_action_url("grupo/eliminar", [$listado_grupos[$i]["cod_grupo"]])?>';
        } else {

         }
    });
});
})


});
</script>


        </tr>
        <?php } ?>
</tbody>

</table>

<br>

<?php else:?>
    <br>
    <p><strong>¡No hay Grupos registrados!</strong></p>

<?php endif;?>

</center>
<br>
</div>










