<?php

	?>
	<div class="col-md-4">
		<form class="form-horizontal" action="?page=sesion&act=submit" method="post">
			<div class="form-group">
				<?php	if(empty($_SESSION[USUARIO])){	?>
				<label for="NOMBRE" class="col-sm-2 control-label">Usuario</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="NOMBRE" id="NOMBRE" value="Rodrigo">
				</div>
			</div>
			<div class="form-group">
				<label for="CLAVE" class="col-sm-2 control-label">Usuario</label>
				<div class="col-sm-4">
					<input type="password" class="form-control" name="CLAVE" id="CLAVE" value="<?php echo PASS; ?>" >
				</div>
			</div>
			
			<div class="form-group">				
				<div class="col-sm-offset-1 col-sm-2">
					<button type="submit" class="btn btn-primary" formaction="?page=sesion&act=login">Iniciar</button>
				</div>
			<?php	} 
			else{
				echo'<button type="submit" class="btn btn-danger" formaction="?page=sesion&act=out">SALIR</button>';
			}
			?>
			</div>
		</form>
	</div>