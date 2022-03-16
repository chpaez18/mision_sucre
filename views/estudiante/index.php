<?php 
$listado_estudiantes = $model->searchArrayByQuery("select * from estudiante order by cod_estudiante");

if(isset($listado_estudiantes) && count ($listado_estudiantes)):

$frm = new HTML();
$count = count($listado_estudiantes);

endif;
?>
<div class="contenido-index">

<center>

<?php if(isset($listado_estudiantes) && count ($listado_estudiantes)):?>
<br>

<table id="datatables">

<thead>
    <tr>
        <th style="display: none">cod_estudiante</th>
        <th>Número de Cédula</th>
        <th>Nombres y Apellidos</th>
        <th>Datos Completos</th>
        <th>Observaciones</th>
    </tr>
</thead>

<tbody>
        <?php for($i = 0; $i < $count; $i++){?>
         <tr>
            <td style="display: none"><?php echo $listado_estudiantes[$i]["cod_estudiante"]?></td>
            <td width="10%"><?php echo $listado_estudiantes[$i]["cedula_estudiante"]?></td>
            <td width="10%"><?php echo ($listado_estudiantes[$i]["nombre_estudiante"]) ? $listado_estudiantes[$i]["nombre_estudiante"] ." ".$listado_estudiantes[$i]["apellido_estudiante"] : "Sin Especificar"?></td>
            <td width="10%"><?php echo (!$model->VerificarEstudiante($listado_estudiantes[$i]["cod_estudiante"])) ? "SI":"NO"?></td>
            <!-- Generamos 2 botones de accion por cada registro que haya en la tabla -->
            <td width="20%">
                <?php 
                if(!$model->VerificarEstudiante($listado_estudiantes[$i]["cod_estudiante"]) ){
                    if($listado_estudiantes[$i]["inscripcion_formalizada"]){
                        echo "Inscripción formalizada.";
                    }else{
                        echo "

                        <a class='a-btn' href= '".ROUTER::create_action_url("estudiante/view", [$listado_estudiantes[$i]["cod_estudiante"]])."'>

                                            <i class='fa fa-eye'></i> <b>Ver</b>  
                                        </a>&nbsp;

                        <a href='".ROUTER::create_action_url("estudiante/formalizar_inscripcion", [$listado_estudiantes[$i]["cod_estudiante"]])."'><button class='btn'><i class='fa fa-share'></i><b> Formalizar Inscripción</b></button></a>
                            ";
                    }
                    
                }else{
                    echo "Este triunfador(a) debe completar sus datos";
                }
                
                ?>

            </td>

        </tr>
        <?php } ?>
</tbody>

</table>

<br>

<?php else:?>
    <p><strong>¡No hay Estudiantes Registrados!</strong></p>

<?php endif;?>

</center>
<br>
</div>