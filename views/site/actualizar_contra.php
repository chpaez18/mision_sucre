<?php 

if(isset($_GET["id"])){
	$id_user = $_GET["id"]; 
}else{
	$id_user = "";
}

?>
<?php 
if(Session::get("autenticado")){
if($model->user()->first_login){ ?>

<center class="info_mensaje"><b>¡Atención!</b>, Actualice su contraseña e información de su cuenta de usuario.</center>

<?php }} ?>
<form id="formulario_login" name="form1" method="post" action="">

	<div class="head"><center><h3><?php echo $this->titulo; ?></h3></center></div>

	<div class="body-content">
	
		<p>
			<label><b>Ingrese su nueva contraseña</b></label>
			<input type="password" name="pass_usuario" id="password">
			<input type="hidden" name="id_user" value="<?=$id_user?>">
		</p>
<br>
		<p>
			<label><b>Confirme la contraseña</b></label>
			<input type="password" name="confirmar">
		</p>	

		<p>
			<input type="submit" value="Guardar" class="btn">
		</p>
		
	</div>


</form>