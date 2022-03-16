<?php 
$frm = new HTML();

$sexo = [
          ['id' => 'F', 'descripcion' => 'Femenino'],
          ['id' => 'M', 'descripcion' => 'Masculino'],
      ];

$estado_civil = [
          ['id' => 'CASADO(A)', 'descripcion' => 'CASADO(A)'],
          ['id' => 'DIVORSIADO(A)', 'descripcion' => 'DIVORSIADO(A)'],
          ['id' => 'SOLTERO(A)', 'descripcion' => 'SOLTERO(A)'],
          ['id' => 'VIUDO(A)', 'descripcion' => 'VIUDO(A)'],
      ];



if($model->sexo_estudiante != NULL){

	$select_sexo = $frm->dropDownList("sexo_estudiante",ArrayHelper::map($sexo,'id','descripcion'), "<b>Género</b>","select_sexo",0, $model->sexo_estudiante);

}else{

	$select_sexo = $frm->dropDownList("sexo_estudiante",ArrayHelper::map($sexo,'id','descripcion'),"<b>Género</b>","select_sexo");

}

if($model->estado_civil_estudiante != NULL){

	$select_estado_civil = $frm->dropDownList("estado_civil_estudiante",ArrayHelper::map($estado_civil,'id','descripcion'), "<b>Estado Civil</b>","select_estado_civil",0, $model->estado_civil_estudiante);

}else{

	$select_estado_civil = $frm->dropDownList("estado_civil_estudiante",ArrayHelper::map($estado_civil,'id','descripcion'),"<b>Estado Civil</b>","select_estado_civil");

}


if($model->fecha_nacimiento != NULL){

	$fecha_formateada = date("d-m-Y", strtotime($model->fecha_nacimiento));

}else{

	$fecha_formateada ="";

}

if($model->inscripcion_formalizada == TRUE){

	$readonly = "readonly";

}else{

	$readonly = "";

}


?>

<script type="text/javascript">
//establecer mascara a un input, en este caso al input con el id "phone" se le aplicara una mascara de telefono
	jQuery(function($){
	   $("#celular_estudiante").mask("(9999)999-9999");
	   $("#tlf_local_estudiante").mask("(9999)999-9999");
	   $("#fecha_nacimiento").mask("99/99/9999");
   });
</script>

<?= $frm->open_form(["method"=>"post","id"=>"formulario_estudiantes"]); ?>

	<div class="head">
		<center><h3><?php echo $this->titulo; ?></h3></center>
	</div>	

	<div class="body-content">
		<?= $frm->textInput($model, "cedula_estudiante",["value"=>$model->cedula_estudiante, "readonly"=>"readonly"]); ?>

		<?= $frm->textInput($model, "nombre_estudiante", ["value"=>$model->nombre_estudiante, $readonly=>$readonly]); ?>		

		<?= $frm->textInput($model, "apellido_estudiante", ["value"=>$model->apellido_estudiante, $readonly=>$readonly]); ?>		

		<?= $frm->textInput($model, "fecha_nacimiento", ["value"=>$fecha_formateada, $readonly=>$readonly]); ?>

<br>
		<!-- SELECT DEL GÉNERO-->
	    <?= $select_sexo; ?>


		<!-- SELECT DEL ESTADO CIVIL-->
	    <?= $select_estado_civil; ?>

		<?= $frm->textInput($model, "lugar_nacimiento_estudiante", ["value"=>$model->lugar_nacimiento_estudiante]); ?>		

		<?= $frm->textInput($model, "correo_estudiante", ["value"=>$model->correo_estudiante]); ?>		

		<?= $frm->textInput($model, "celular_estudiante", ["value"=>$model->celular_estudiante]); ?>		

		<?= $frm->textInput($model, "tlf_local_estudiante", ["value"=>$model->tlf_local_estudiante]); ?>
<br>
		<p><b>Dirección</b></p>
	    <textarea name="direccion_estudiante"><?php if($model->direccion_estudiante != NULL){echo $model->direccion_estudiante;}?></textarea>


		<?= $frm->submitButton("Guardar", ["class"=>"btn", "id"=>"btn-1"]); ?>
	</div>

<?= $frm->close_form(); ?>








<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_estudiantes').submit(function (e, params) {
        var localParams = params || {};

        if (!localParams.send) {
            e.preventDefault();
        }

    swal({
            title: "¿Esta Seguro de que la información proporcionada es correcta?",
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





