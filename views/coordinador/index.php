<?php 
$listado_coordinadores = $model->searchArrayByQuery("select * from coordinador order by cod_coordinador");


if(isset($listado_coordinadores) && count ($listado_coordinadores)):

$frm = new HTML();
$count = count($listado_coordinadores);

endif;
?>

<div class="contenido-index">
<p>

<div class="contenido-alineado-izquierda">
    <legend><h3><?= $this->titulo; ?></h3></legend>
</div>

<div class="contenido-alineado-derecha">
        <a href="<?php echo ROUTER::create_action_url("coordinador/nuevo")?> "><button class="btn"><i class="fa fa-plus" aria-hidden="true"></i> <b>Agregar Coordinador </b> </button></a>
</div>  
</p>

<br>
<br>

<center>



<?php if(isset($listado_coordinadores) && count ($listado_coordinadores)):?>
<br>

<table id="datatables">

<thead>
    <tr>
        <th>Cédula</th>
        <th>Nombre Coordinador</th>
        <th>Apellido Coordinador</th>
        <th>Aldea Asignada</th>
        <th>Acciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){?>
         <tr>
            <td><?php echo $listado_coordinadores[$i]["ced_coordinador"]?></td>
            <td><?php echo $listado_coordinadores[$i]["nombre_coordinador"]?></td>
            <td><?php echo $listado_coordinadores[$i]["apellido_coordinador"]?></td>
            <td><?php echo ($model->getCordAldea($listado_coordinadores[$i]["cod_coordinador"])) ? $model->getCordAldea($listado_coordinadores[$i]["cod_coordinador"]):"No definido" ?></td>
            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
            <td width="20%">
                <a href="<?php echo ROUTER::create_action_url("coordinador/editar", [$listado_coordinadores[$i]["cod_coordinador"]]) ?>"><button class="btn"><i class="icon-edit"></i><b>Editar</b></button></a>  

                <button id="boton_eliminar<?=$i?>" class="btn-danger"><i class="icon-trash"></i><b>Eliminar</b></button>
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
           window.location.href='<?= ROUTER::create_action_url("coordinador/eliminar", [$listado_coordinadores[$i]["cod_coordinador"]])?>';
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
    <p><strong>¡No hay Coordinadores registrados!</strong></p>

<?php endif;?>

</center>
<br>
</div>















