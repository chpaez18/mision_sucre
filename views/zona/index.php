<?php 
$listado_zonas = $model->searchArrayByQuery("select * from zona order by cod_zona");
if(isset($listado_zonas) && count ($listado_zonas)):

$frm = new HTML();
$count = count($listado_zonas);

endif;
?>

<div class="contenido-index">

<div class="contenido-alineado-izquierda">
    <legend><h3><?= $this->titulo; ?></h3></legend>
</div>

<div class="contenido-alineado-derecha">
    <a href="<?php echo ROUTER::create_action_url("zona/nuevo")?> "><button class="btn"><i class="fa fa-plus" aria-hidden="true"></i> <b>Agregar Eje </b></button></a>
</div>
<br>
<br>
<center>

<?php if(isset($listado_zonas) && count ($listado_zonas)):?>
<br>

<table id="datatables">

<thead>
    <tr>
        <th style="display: none">cod_zona</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){?>
         <tr>
            <td style="display: none"><?php echo $listado_zonas[$i]["cod_zona"]?></td>

            <td><?php echo $listado_zonas[$i]["descripcion"]?></td>
            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
            <td width="39%">
                <a href="<?php echo ROUTER::create_action_url("zona/editar", [$listado_zonas[$i]["cod_zona"]]) ?>"><button class="btn"><i class="icon-edit"></i><b>Editar</b></button></a> 
                
                <!-- <a href="<?php //echo ROUTER::create_action_url("zonas/eliminar", [$zonas[$i]["cod_zona"]]) ?>"><button class="btn-danger"><i class="icon-trash"></i><b>Eliminar</b></button></a> -->
            </td>

        </tr>
        <?php } ?>
</tbody>

</table>

<br>

<?php else:?>
    <p><strong>¡No hay Ejes registrados!</strong></p>

<?php endif;?>

</center>
<br>
</div>