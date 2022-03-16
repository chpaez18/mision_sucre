
<form id="formulario_login" name="form1" method="post" action="">


	

	<div class="body-content2">

		<center> <img class="img-login" src="<?php echo $_layoutParams['ruta_img']."imagen-login.png"?>"> </center>
		<br>
		<p>
			<center><label><b>Nombre de Usuario</b></label></center>
			<input type="text" name="nom_usuario" placeholder="Usuario">
		</p>	
<br>
		<p>
			<center><label><b>Contraseña</b></label></center>
			<input type="password" name="pass_usuario" placeholder="Contraseña">
		</p>

		<br>

		<center><label><b>Captcha(en mayúsculas)</b></label></center>
		<input type="text" name="captcha" id="captcha" value=<?php echo $model->codigo_captcha(); ?> class="captcha" size="4" readonly>
	
		<input type="text" name="txtcopia" id="txtcopia" size="10">

<br>
<br>
		<center><p><a href="<?php echo BASE_URL_ACTION ."site/recuperar_contra"?>"><h4>¿Olvidó su contraseña de acceso?</h4></a></p></center>	

		<p>
			<input type="submit" value="Entrar" class="btn" onclick="validar()">
			
		</p>
	</div>


</form>
