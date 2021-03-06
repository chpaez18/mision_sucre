
<!DOCTYPE html>
<html>
<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo $this->titulo; ?></title>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
    
 

    <link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_css']?>estilos.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_css']?>fontello.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_css']?>dataTables.foundation.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_font_awesome']?>font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_css']?>select2.min.css">
    <link href="<?php echo $_layoutParams['ruta_css']?>bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $_layoutParams['ruta_css']?>sweetalert.css" rel="stylesheet" type="text/css" />

        <!-- SCRIPTS JS-->
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_js']?>jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_js']?>valid.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_js']?>jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_js']?>jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_js']?>select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_js']?>jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_js']?>messages_es.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_js']?>sweetalert.min.js"></script>

<script src="<?php echo $_layoutParams['ruta_js']?>bootstrap-datepicker.min.js"></script>
<script src="<?php echo $_layoutParams['ruta_js']?>bootstrap-datepicker.es.js"></script>

<style type="text/css">
  label.error {
    display:inline;
    width:50%;
    color: red;
    padding: 5px;
    margin-bottom: 2px;
}
</style>
<script type="text/javascript" charset="utf-8">
      
   $(document).ready(function() {
     $('#select1').select2({
      minimumResultsForSearch: 10,
      placeholder: "Seleccione...",
      //maximumSelectionLength: 2    definir un maximo de seleccion!! 

    });

$('#datepicker').datepicker({
   format: 'dd/mm/yyyy',
  language: 'es'

});

//validaciones javascript de las vistas lado del cliente
    $("#formulario_login").validate({
      rules:
      {
        nom_usuario:{required:true},
        pass_usuario:{required:true,minlength:6},
        respuesta:{required:true},
        confirmar:{equalTo:"#password"},
        txtcopia: {required:true}
      },

      messages:
      {
          nom_usuario:{required:"Por favor, escriba su nombre de usuario"},          
          pass_usuario:{required:"Por favor, escriba su contrase??a", minlength:"Este campo acepta m??nimo 6 Caracteres"},
          respuesta:{required:"Por favor, debe responder la pregunta de seguridad"},
          confirmar:{equalTo:"Las contrase??as no coinciden"},
          txtcopia:{required:"Por favor, ingrese el c??digo captcha"}

      },

    });    

    $("#formulario_registro").validate({
      rules:
      {
        cedula:{required:true, digits:true, minlength:7, maxlength:8},
        nom_usuario:{required:true, minlength:4},
        pass_usuario:{required:true,minlength:6},
        confirmar:{required:true, equalTo:"#password"},
        resp_secreta:{required:true, minlength:4},
        confirmar_respuesta:{required:true, equalTo:"#respuesta"},
        nac:{
            required: function(element){
                    if($('#select_nac').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_nac').val('Seleccione...');
                    }
                    return true;
                }
        },
        preg_secreta:{
            required: function(element){
                    if($('#select_pregunta_secreta').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_pregunta_secreta').val('Seleccione...');
                    }
                    return true;
                }
        },

      },

      messages:
      {        
          cedula:{required:"Debe rellenar este campo", digits:"Escriba n??meros enteros", minlength:"Este campo acepta m??nimo 7 Digitos", maxlength:"Este campo acepta m??ximo 8 Digitos"},
          nom_usuario:{required:"Por favor, escriba su nombre de usuario", minlength:"Este campo acepta m??nimo 4 Caracteres"},
          pass_usuario:{required:"Por favor, escriba su contrase??a",minlength:"Este campo acepta m??nimo 6 Caracteres"},
          confirmar:{required:"Debe rellenar este campo", equalTo:"Las contrase??as no coinciden"},
          resp_secreta:{required:"Debe rellenar este campo",  minlength:"Este campo acepta m??nimo 4 Caracteres"},
          confirmar_respuesta:{required:"Debe rellenar este campo", equalTo:"Las respuestas no coinciden"},
          nac:{required:"Debe seleccionar una nacionalidad"},
          preg_secreta:{required:"Debe seleccionar una pregunta secreta"},
      },

    });      


    $("#formulario_usuarios").validate({
      rules:
      {
        pass_usuario:{required:true,minlength:6},
        confirmar:{equalTo:"#password"},
        resp_secreta:{required:true, minlength:4},
        confirmar_respuesta:{required:true, equalTo:"#respuesta"},
        preg_secreta :{
            required: function(element){
                    if($('#select_pregunta').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_pregunta').val('Seleccione...');
                    }
                    return true;
                }
        },

      },

      messages:
      {
          pass_usuario:{required:"Por favor, escriba su contrase??a",minlength:"Este campo acepta m??nimo 6 Caracteres"},
          confirmar:{equalTo:"Las contrase??as no coinciden"},
          resp_secreta:{required:"Debe rellenar este campo",  minlength:"Este campo acepta m??nimo 4 Caracteres"},
          confirmar_respuesta:{required:"Debe rellenar este campo", equalTo:"Las respuestas no coinciden"},
          preg_secreta:{required:"Debe seleccionar una pregunta de seguridad"},

      },

    });     

    $("#formulario_zonas").validate({
      rules:
      {
        descripcion:{required:true, minlength:5},
      },

      messages:
      {
          descripcion:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"}
      },

    });    

    $("#formulario_estudiantes").validate({
      rules:
      {
        nombre_estudiante:{required:true},
        apellido_estudiante:{required:true},
        fecha_nacimiento:{required:true},
        lugar_nacimiento_estudiante:{required:true, minlength:5},
        correo_estudiante:{required:true, email:true},
        celular_estudiante:{required:true, minlength:11},
        direccion_estudiante:{required:true, minlength:10},
        ano:{required:true, minlength:4},
        sexo_estudiante:{
            required: function(element){
                    if($('#select_sexo').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_sexo').val('Seleccione...');
                    }
                    return true;
                }
        },
        estado_civil_estudiante:{
            required: function(element){
                    if($('#select_estado_civil').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_estado_civil').val('Seleccione...');
                    }
                    return true;
                }
        },        
        cod_aldea:{
            required: function(element){
                    if($('#select_aldea').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_aldea').val('Seleccione...');
                    }
                    return true;
                }
        },        

        cod_trayecto:{
            required: function(element){
                    if($('#select_trayecto').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_trayecto').val('Seleccione...');
                    }
                    return true;
                }
        },        

        cod_carrera:{
            required: function(element){
                    if($('#select_carrera').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_carrera').val('Seleccione...');
                    }
                    return true;
                }
        },
       
      },

      messages:
      {
          nombre_estudiante:{required:"Debe rellenar este campo"},
          apellido_estudiante:{required:"Debe rellenar este campo"},
          fecha_nacimiento:{required:"Debe rellenar este campo"},
          lugar_nacimiento_estudiante:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"},
          correo_estudiante:{required:"Debe rellenar este campo",email:"Debe ingresar un correo electr??nico v??lido"},

          celular_estudiante:{required:"Debe rellenar este campo",minlength:"Este campo acepta m??nimo 11 Digitos"},
          direccion_estudiante:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 10 Caracteres"},
          ano:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 4 Caracteres"},
          sexo_estudiante:{required:"Debe seleccionar un g??nero"},
          estado_civil_estudiante:{required:"Debe seleccionar un estado civil"},
          cod_aldea:{required:"Debe seleccionar una aldea"},
          cod_trayecto:{required:"Debe seleccionar un trayecto"},
          cod_carrera:{required:"Debe seleccionar una carrera"},
      },

    });     

    $("#formulario_aldeas").validate({
      rules:
      {
        nombre_aldea:{required:true, minlength:5},
        ubicacion:{required:true, minlength:5},
        "cod_carrera[]" :{required:true},
        id_zona :{
            required: function(element){
                    if($('#select_eje').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_eje').val('Seleccione...');
                    }
                    return true;
                }
        },
      },

      messages:
      {
          nombre_aldea:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"},
          ubicacion:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"},
          "cod_carrera[]":{required:"Debe seleccionar al menos 1 carrera"},
          id_zona:{required:"Debe seleccionar un eje"},
      },

    });        

    $("#formulario_coordinadores").validate({


      rules:
      {
        nombre_coordinador:{required:true, minlength:3},
        apellido_coordinador:{required:true, minlength:3},
        cedula:{required:true, digits:true, minlength:7,maxlength:8},
        ced_coordinador:{required:true, digits:true, minlength:7,maxlength:8},
        calificacion:{required:true, number:true, minlength:2,maxlength:4},
        aldea_cod_aldea:{required:true},
        correo:{required:true, email:true},
        nac: {
            required: function(element){
                    if($('#select_nac').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_nac').val('Seleccione...');
                    }
                    return true;
                }
        },        

        aldea_cod_aldea: {
            required: function(element){
                    if($('#select_aldea').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_aldea').val('Seleccione...');
                    }
                    return true;
                }
        },

    },


      messages:
      {
          nombre_coordinador:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 3 Caracteres"},
          nac:{required:"Debe Seleccionar una nacionalidad"},
          aldea_cod_aldea:{required:"Debe Seleccionar una aldea"},
          apellido_coordinador:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 3 Caracteres"},
          cedula:{required:"Debe rellenar este campo", digits:"Escriba solo n??meros enteros", minlength:"Este campo acepta m??nimo 7 Digitos",maxlength:"Este campo acepta m??ximo 8 Digitos"},
          ced_coordinador:{required:"Debe rellenar este campo", digits:"Escriba solo n??meros enteros", minlength:"Este campo acepta m??nimo 7 Digitos", maxlength:"Este campo acepta m??ximo 8 Digitos"},
          calificacion:{required:"Debe rellenar este campo", number:"Solo se Permiten N??mero Enteros, o con Decimales", minlength:"Este campo acepta m??nimo 2 Digitos", maxlength:"Este campo acepta m??ximo 4 Digitos"},
          aldea_cod_aldea:{required:"Debe seleccionar una aldea"},
          correo:{required:"Debe rellenar este campo", email:"Debe ingresar un correo electr??nico v??lido"},
      },

    });      

    $("#formulario_carreras").validate({
      rules:
      {
        nombre_carrera:{required:true, minlength:5},
        tipo:{required:true, minlength:5},
        "cod_materia[]" :{required:true},
        "cod_grupo[]" :{required:true},
      },

      messages:
      {
          nombre_carrera:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"},
          tipo:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"},
          "cod_materia[]":{required:"Seleccione al menos 1 materia"},
          "cod_grupo[]":{required:"Seleccione al menos 1 grupo"}
      },

    });       

    $("#formulario_materias").validate({
      rules:
      {
          nombre_materia:{required:true, minlength:5},
          codigo:{required:true, minlength:5},
      },

      messages:
      {
          nombre_materia:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"},
          codigo:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"}
      },

    });    

    $("#formulario_grupos").validate({
      rules:
      {
        nombre:{required:true, minlength:5},
        capacidad:{required:true, digits:true},
        "cod_estudiante[]" :{required:true},
        ano:{required:true, digits:true},
        id_carrera: {
            required: function(element){
                    if($('#select_carrera').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_carrera').val('Seleccione...');
                    }
                    return true;
                }
        },

        cod_materia: {
            required: function(element){
                    if($('#select_materia').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_materia').val('Seleccione...');
                    }
                    return true;
                }
        },        

        cod_trayecto: {
            required: function(element){
                    if($('#select_trayecto').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_trayecto').val('Seleccione...');
                    }
                    return true;
                }
        },        

        periodo: {
            required: function(element){
                    if($('#select_periodo').val() == "0"){
                        //Set predefined value to blank.
                        $('#select_periodo').val('Seleccione...');
                    }
                    return true;
                }
        },

      },       

     

      messages:
      {
          nombre:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"},
          capacidad:{required:"Debe rellenar este campo", digits:"Debe escribir un n??mero entero"},
          "cod_estudiante[]":{required:"Seleccione al menos 1 triunfador"},
          ano:{required:"Debe rellenar este campo", digits:"Escriba solo n??meros enteros"},
          id_carrera:{required:"Debe seleccionar una carrera"},
          cod_materia:{required:"Debe seleccionar una materia"},
          cod_trayecto:{required:"Debe seleccionar un trayecto"},
          periodo:{required:"Debe seleccionar un periodo"}
      },

    });     

    $("#formulario_grupos_2").validate({
      rules:
      {
        nombre:{required:true, minlength:5},
        capacidad:{required:true, digits:true},
        "cod_carrera[]" :{required:true},
      },

      messages:
      {
          nombre:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 5 Caracteres"},
          capacidad:{required:"Debe rellenar este campo", digits:"Debe escribir un n??mero entero"},
          "cod_carrera[]":{required:"Seleccione al menos 1 carrera"},
      },

    });    

    $("#formulario_profesores").validate({
      rules:
      {
        nombre_profesor:{required:true, minlength:3},
        apellido_profesor:{required:true, minlength:3},
        ced_profesor:{required:true, digits:true, minlength:7},
        "cod_materia[]" :{required:true}
      },

      messages:
      {
          nombre_profesor:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 3 Caracteres"},
          apellido_profesor:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 3 Caracteres"},
          ced_profesor:{required:"Debe rellenar este campo", digits:"Escriba solo n??meros enteros", minlength:"Este campo acepta m??nimo 7 Digitos"},
          "cod_materia[]":{required:"Seleccione al menos 1 materia"}
      },

    });    


    $("#formulario_asignar_notas").validate({
      rules:
      {
        nombre_profesor:{required:true, minlength:3},
        apellido_profesor:{required:true, minlength:3},
        ced_profesor:{required:true, digits:true, minlength:7},
      },

      messages:
      {
          nombre_profesor:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 3 Caracteres"},
          apellido_profesor:{required:"Debe rellenar este campo", minlength:"Este campo acepta m??nimo 3 Caracteres"},
          ced_profesor:{required:"Debe rellenar este campo", digits:"Escriba solo n??meros enteros", minlength:"Este campo acepta m??nimo 7 Digitos"}
      },

    });
//fin de las validaciones javascript 


    $('#datatables').DataTable( {
        "iDisplayLength": 5,
        "order": [0,"asc"],
        "language": {
            "lengthMenu": "",
            "sInfo": "Se Muestran _START_-_END_ de _TOTAL_ Registros",
            "zeroRecords": "Sin Resultados.",
            "sEmptyTable":    "Ning??n Registro Disponible",
            "info": "P??gina N?? _PAGE_ de _PAGES_",
            "infoEmpty": "Sin Resultados",
            "sSearch":        "B??squeda General:",
            "sLoadingRecords": "Cargando...",
            "infoFiltered": "",
            "paginate": {
                        "first":      "<i class='fa fa-fast-backward'></i> Primero",
                        "last":       "??ltimo <i class='fa fa-fast-forward'></i>",
                        "next":       "Siguiente <i class='fa fa-arrow-right'></i>",
                        "previous":   "<i class='fa fa-arrow-left'></i> Anterior"
                    },
        }
    } );
} );

    </script>

  </head>


<body>
    
  <header>

    <div class="logo">
      <img class="img-logo" src="<?php echo $_layoutParams['ruta_img']?>Cintillo-Hro_sistema.jpg">

      <img class="img-logo2" src="<?php echo $_layoutParams['ruta_img']?>cintillo_responsive.png">
    </div>


    <nav>
      <ul>
      <?php for ($i=0; $i< count($menu); $i++){ 
          if(array_key_exists("items", $menu[$i])){ 

            $result = ArrayHelper::getValue($menu[$i], ["items"]);
            $cant_items = count($result);
            
      ?>
        <li>
          <a href=""><?= $menu[$i]["titulo"]?></a>
          <ul>
            <?php $l=0; while($l < $cant_items){ ?>
              <li><a href="<?= $result[$l]["enlace"]?>"><?= $result[$l]["titulo"]?></a></li>
            <?php $l++;}?>
          </ul>
        </li>
      <?php   

        }else{
          if($menu[$i]["titulo"] == "Manual de Usuario"){
            ?>
            <li><a href="<?= $menu[$i]["enlace"] ?>" target='_blank' title='Manual de uso del sistema'><?= $menu[$i]["titulo"]?></a></li>
        <?php
          }else{
        ?>

        <li><a href="<?= $menu[$i]["enlace"]?>"><?= $menu[$i]["titulo"]?></a></li>
        <?php }?>
      <?php }
          } ?>


      </ul>
    </nav>



  </header>

      <main>
        <section>

        <br>
          <center>
            <div id="mensajes" class="cont">

                  <?php 
                  if(isset($this->error)){ ?>

                    <center class="error_mensaje"><?php if(isset($this->error)) echo $this->error;?></center>
                    <br>
                  
                  <?php } ?>

                    <?php if(isset($this->mensaje)){ ?>

                      <center class="info_mensaje"><?php if(isset($this->mensaje)) echo $this->mensaje;?></center>
                      <br>

                      <?php } ?>
                      

                      <?php 

                        if(isset($_GET["ok"]) ){

                           if( $_GET["ok"] ==1){

                            echo "<center class='info_mensaje'>Registro agregado con ??xito.</center><br>";

                           }else if ($_GET["ok"] == 2){

                            echo "<center class='info_mensaje'>Registro eliminado con ??xito.</center><br>";

                           }else if ($_GET["ok"] == 3){

                            echo "<center class='info_mensaje'>N??mero de C??dula registrado correctamente, Se ha enviado un correo electr??nico al triunfador con los detalles para finalizar su inscripci??n.</center><br>";

                           }else if ($_GET["ok"] == 4){

                            echo "<center class='error_mensaje'>El n??mero de c??dula proporcionado no se encuentra en nuestros registros.</center><br>";
                           }else if ($_GET["ok"] == 5){

                            echo "<center class='info_mensaje'>Este n??mero de c??dula se encuentra previamente registrado, por favor complete los siguientes campos para crear su nueva cuenta de usuario.</center><br>";

                           }else if ($_GET["ok"] == 6){

                            echo "<center class='info_mensaje'>Registro completado con ??xito, ahora puede iniciar sesi??n.</center><br>";
                           }else if ($_GET["ok"] == 7){

                            echo "<center class='info_mensaje'>Contrase??a actualizada con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 8){

                            echo "<center class='error_mensaje'>El triunfador con este n??mero de c??dula ya ha registrado una cuenta de usuario.</center><br>";

                           }else if ($_GET["ok"] == 9){

                            echo "<center class='info_mensaje'>Datos personales actualizados correctamente.</center><br>";
                           }else if ($_GET["ok"] == 10){

                            echo "<center class='error_mensaje'>Este n??mero de c??dula ya se encuentra registrado.</center><br>";
                           }else if ($_GET["ok"] == 11){

                            echo "<center class='info_mensaje'>Carrera(s) asignada(s) con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 12){

                            echo "<center class='error_mensaje'>Por favor, debe seleccionar al menos una carrera.</center><br>";
                           }else if ($_GET["ok"] == 13){

                            echo "<center class='error_mensaje'>Por favor, debe seleccionar al menos una materia.</center><br>";
                           }else if ($_GET["ok"] == 14){

                            echo "<center class='info_mensaje'>Materia(s) asignada(s) con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 15){

                            echo "<center class='info_mensaje'>Grupo(s) asignado(s) con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 16){

                            echo "<center class='error_mensaje'>Por favor, debe seleccionar al menos un triunfador.</center><br>";
                           }else if ($_GET["ok"] == 17){

                            echo "<center class='info_mensaje'>Triunfador(es) asignado(s) con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 18){

                            echo "<center class='info_mensaje'>El triunfador fue eliminado del grupo con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 19){

                            echo "<center class='info_mensaje'>La carrera fue eliminada de la aldea con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 20){

                            echo "<center class='info_mensaje'>La materia fue eliminada de la carrera con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 21){

                            echo "<center class='info_mensaje'>El grupo fue eliminado de la carrera con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 22){

                            echo "<center class='info_mensaje'>Registro modificado con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 23){

                            echo "<center class='info_mensaje'>Usuario registrado con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 24){

                            echo "<center class='info_mensaje'>El triunfador con este n??mero de c??dula ya cuenta con su inscripci??n formalizada</center><br>";
                           }else if ($_GET["ok"] == 25){

                            echo "<center class='info_mensaje'>Contrase??a actualizada con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 26){

                            echo "<center class='info_mensaje'>Coordinador registrado con ??xito, el nombre de usuario definido es la primera letra del nombre del coordinador seguido de su apellido y la contrase??a por defecto es '123456'</center><br>";
                           }else if ($_GET["ok"] == 27){

                            echo "<center class='info_mensaje'>Calificaci??n cargada con ??xito.</center><br>";
                           }else if ($_GET["ok"] == 28){

                            echo "<center class='info_mensaje'>Calificaci??n modificada con ??xito!.</center><br>";
                           }else if ($_GET["ok"] == 29){

                            echo "<center class='info_mensaje'>Nota eliminada con ??xito!.</center><br>";
                           }else if ($_GET["ok"] == 30){

                            echo "<center class='error_mensaje'>Por favor, debe seleccionar una cantidad de triunfadores menor a la capacidad m??xima del grupo</center><br>";
                           }else if ($_GET["ok"] == 31){

                            echo "<center class='info_mensaje'>Se ha formalizado de forma correcta la inscripci??n de este triunfador.</center><br>";
                           }else if ($_GET["ok"] == 32){

                            echo "<center class='info_mensaje'>La materia se ha asignado de forma correcta.</center><br>";
                           }else if ($_GET["ok"] == 33){

                            echo "<center class='error_mensaje'>Este grupo debe ser asignado a una carrera.</center><br>";
                           }else if ($_GET["ok"] == 34){

                            echo "<center class='info_mensaje'>Usuario actualizado correctamente.</center><br>";
                           }


                        }

                      ?>


                 </div>
          </center>


          <div class="contenido">
          <?php 
          $request = new Request();
          $controlador = ucwords($request->getControlador());
          $ruta =  ROUTER::create_action_url("$controlador/index");

          if(Session::get("autenticado")){
            if($model->user()->rol_cod_rol == 4){
            $visible = "none";
            }else{
              $visible = "";
            }

            if($model->user()->rol_cod_rol == 3){
            $visible = "none";
            }else{
              $visible = "";
            }
          }else{

          }
          
          
          if($request->getControlador() == "site" and $request->getMetodo() == "index" or $request->getControlador() == "error" and $request->getMetodo() == "access" or $request->getControlador() == "site" and $request->getMetodo() == "login" or $request->getControlador() == "site" and $request->getMetodo() == "registro" or $request->getControlador() == "site" and $request->getMetodo() == "habilitar_carga_notas" or $request->getControlador() == "site" and $request->getMetodo() == "desabilitar_carga_notas" ){
            $controlador = "";
            $ruta = "";
          }else{
            if($controlador == "Zona"){
              $controlador = "Zona";
            } 

            if($controlador == "Estudiante"){
              $controlador = "Triunfador";
            }

            if($controlador == "Usuarios"){
              $visible = "none";
            }
            if($controlador == "Site"){
              $visible = "none";
            }
          if(Session::get("autenticado")){
            
            if($model->user()->rol_cod_rol == 4 and $request->getControlador() == "estudiante" and $request->getMetodo() == "asignar_nota"){
              $this->titulo = "Consulta de Notas";
            }
          }

          ?>
            <nav class="breadcrumb">
              <a style="display: <?= $visible ?>" class="breadcrumb-item" href="<?= $ruta ?>"><?= $controlador?></a>
              <span class="breadcrumb-item active"><?= $this->titulo?></span>
            </nav>
            <br>
          <?php }?>

            <?php include_once $rutaView; ?>
          </div>

          <center><p id="d" style="background-color:  color: #A94566 ; border-radius: 5px; border-color: #EED5D7;"></center>

        </section>
      </main>

      

  </body>


</html>