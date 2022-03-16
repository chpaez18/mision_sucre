<form id="formulario_usuarios" name="form1" method="post" action="">

<input type="hidden" value="1" name="guardar">

	<div class="head"><?= $this->titulo ?></div>

	<div class="body-content">
	
		<p>
			<label><b>Ingrese su nueva Contraseña</b></label>
			<input type="password" name="pass_usuario" id="password">
		</p>

		<p>
			<label><b>Confirmar Contraseña</b></label>
			<input type="password" name="confirmar">
		</p>	

		<p>
			<input type="submit" value="Actualizar" class="btn">
		</p>
		
	</div>


</form>


<script type="text/javascript">
$(document).ready(function() {


 $('#formulario_usuarios').submit(function (e, params) {
        var localParams = params || {};

        if (!localParams.send) {
            e.preventDefault();
        }

    swal({
            title: "¿Está seguro de que la información proporcionada es correcta?",
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

