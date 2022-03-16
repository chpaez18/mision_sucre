<?php 
$cod_trayecto = $_GET["cod_t"];
$cod_carrera = $_GET["cod_c"];
$cod_grupo = $_GET["cod_g"];

if($model->user()->rol_cod_rol == 4 or $model->user()->rol_cod_rol == 1){
    $ano = $_GET["ano"];
    $cod_aldea = $_GET["cod_a"];
    $cod_trayecto = $_GET["cod_t"];
    $listado = $model->searchArrayByQuery("select tc.periodo, tc.ano, tc.periodo, t.descripcion, a.nombre_aldea, g.nombre, m.nombre_materia, 
        e.cedula_estudiante, e.nombre_estudiante, e.apellido_estudiante, me.calificacion
        FROM carrera c 
        INNER JOIN grupo g ON g.id_carrera = c.cod_carrera
        INNER JOIN trayecto_carrera tc ON tc.cod_carrera = c.cod_carrera
        INNER JOIN trayecto t ON t.cod_trayecto = tc.cod_trayecto
        INNER JOIN aldea_carrera ac ON ac.cod_carrera = tc.cod_carrera
        INNER JOIN aldea a ON a.cod_aldea = ac.cod_aldea
        INNER JOIN grupo_estudiante ge ON ge.cod_grupo = g.cod_grupo
        INNER JOIN estudiante e ON e.cod_estudiante = ge.cod_estudiante
        INNER JOIN materia_estudiante me ON me.cod_estudiante = e.cod_estudiante
        INNER JOIN materia m ON m.cod_materia = me.cod_materia
        WHERE  t.cod_trayecto = $cod_trayecto AND a.cod_aldea = $cod_aldea AND c.cod_carrera = $cod_carrera AND g.cod_grupo = $cod_grupo AND tc.ano = $ano
        ORDER BY m.nombre_materia
    ");


}else{

    $listado = $model->searchArrayByQuery("select tc.periodo, t.descripcion, tc.ano, tc.periodo, c.nombre_carrera, g.nombre, m.cod_materia, m.nombre_materia, ge.cod_estudiante, e.cedula_estudiante, e.nombre_estudiante, e.apellido_estudiante, me.calificacion
    FROM trayecto t
    INNER JOIN  trayecto_carrera tc ON tc.cod_trayecto = t.cod_trayecto
    INNER JOIN carrera c ON c.cod_carrera = tc.cod_carrera
    INNER JOIN carrera_materia cm ON cm.cod_carrera = c.cod_carrera
    INNER JOIN materia m ON m.cod_materia = cm.cod_materia
    INNER JOIN materia_estudiante me ON me.cod_materia = m.cod_materia
    INNER JOIN estudiante e ON e.cod_estudiante = me.cod_estudiante
    INNER JOIN grupo_estudiante ge ON ge.cod_estudiante = e.cod_estudiante
    INNER JOIN grupo g ON g.cod_grupo = ge.cod_grupo
    WHERE t.cod_trayecto = $cod_trayecto AND c.cod_carrera = $cod_carrera  AND g.cod_grupo = $cod_grupo 
    ORDER BY me.cod_materia
    ");

}


/*
echo "<pre>";
print_r($listado);
echo "</pre>";

die();

*/
if($model->user()->rol_cod_rol == 4){
    $this->titulo = "Consulta de Notas";
}

?>
<?php 
if(isset($listado) && count ($listado)):

$frm = new HTML();
$count = count($listado);

endif;

$id_user = $model->user()->cod_usuario;

$carga_notas = $model->searchByQueryOne("select * from usuario where cod_usuario = $id_user");

$aux = $carga_notas->hab_carga_notas;


if($aux == "1"){
    //esta deshabilitada la carga de notas
    
    if($model->user()->rol_cod_rol == 2){
        $readonly = "disabled = true";
        $visible = "none";
    }else{
        if($model->user()->rol_cod_rol == 1){
             $readonly = "disabled = true";
            $visible = "none";
        }
    }

    if($model->user()->rol_cod_rol == 4){
        $readonly = "disabled = true";
        $visible = "none";
    }
}else{
    //esta habilitada la carga de notas
    if($model->user()->rol_cod_rol == 2){
        $readonly = "";
        $visible = "inline";
    }else{
        if($model->user()->rol_cod_rol == 1){
             $readonly = "disabled = true";
            $visible = "none";
        }
    }
    if($model->user()->rol_cod_rol == 4){
        $readonly = "disabled = true";
        $visible = "none";
    }
}


?>
<div class="contenido-index">

<div class="contenido-alineado-izquierda">
    <legend><h3><?= $this->titulo; ?></h3></legend>
</div>



<br>
<br>
<center>




<?php if(isset($listado) && count ($listado)):?>

<center>
 <a href="<?php echo ROUTER::create_action_url("estudiante/reporte",["cod_t"=>"$cod_trayecto", "cod_c"=>$cod_carrera, "cod_g"=>$cod_grupo])?> "><button class="btn"><i class="fa fa-download" aria-hidden="true"></i> <b>Generar Reporte</b></button></a>
</center>

<?= $frm->open_form(["method"=>"post", "id"=>"form_carga"]); ?>
<input type='hidden' name='cod_t' value='<?=$cod_trayecto?>'>
<input type='hidden' name='cod_c' value='<?=$cod_carrera?>'>
<input type='hidden' name='cod_g' value='<?=$cod_grupo?>'>



<table id="datatables">

<thead>
    <tr>
        <th>Trayecto</th>
        <th>Período</th>
        <th>Cédula</th>
        <th>Nombres y Apellidos</th>
        <th>Nombre de la Materia</th>
        <th>Nota Final</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){
            $id = $listado[$i]["cod_estudiante"];
            $calificacion = $listado[$i]["calificacion"];
            $cod_materia1 = $listado[$i]["cod_materia"];
            
        ?>
         <tr>
            <td width="30%"><?php echo $listado[$i]["descripcion"]?></td>
            <td width="30%"><?php echo $listado[$i]["periodo"]?></td>
            <td width="30%"><?php echo $listado[$i]["cedula_estudiante"]?></td>
            <td width="30%"><?php echo $listado[$i]["nombre_estudiante"]." ".$listado[$i]["apellido_estudiante"]?></td>
            <td width="30%"><?php echo $listado[$i]["nombre_materia"]?></td>
            <td width="27%">
                <?= "<input type='hidden' name='estudiante[]' value='".$id."'>

                    <input type='hidden' name='materia[]' value='".$cod_materia1."'>

                <input ".$readonly." type='text' name='calificacion[]' value='".$calificacion."'>  "
                ?>
            
            </td>

        </tr>
        <?php } ?>
</tbody>


</table>
<br>
<br>

<center>

<button type="submit" class="btn" style="width: 60%; display: <?=$visible?>">
    <i class="fa fa-share"></i> <b>Cargar Notas</b>
</button>

</center>
<?= $frm->close_form(); ?>



<br>

<?php else:?>
    <p><strong>¡No se han encontrado alumnos según los criterios especificados!</strong></p>

<?php endif;?>

</center>
<br>
</div>




<script type="text/javascript">
$(document).ready(function() {


 $('#form_carga').submit(function (e, params) {
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







