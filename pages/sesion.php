<?php
function execPrint($command) {
    $result = array();
    exec($command, $result);
    print("<pre>");
    foreach ($result as $line) {
        print($line . "\n");
    }
    print("</pre>");
}
echo "<h1> ARDILLA </h1>"


if(!empty($_GET["act"]))
if($_GET["act"]="git"){
	//echo "XXX";
	// Print the exec output inside of a pre element
	//execPrint("git pull https://user:password@bitbucket.org/user/repo.git master");
	//	execPrint("git pull");
	//	execPrint("git status");


	// directorio actual
	echo getcwd() . "\n";
	$output = shell_exec('git-script.sh');
	print_r ($output);
	echo "\n OK";
	//chdir('public_html');

	// directorio actual
	//echo getcwd() . "\n";
	}

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
<?php	if(!empty($_SESSION[USUARIO])){	?>
	<form action="?page=sesion&act=git" method="post">
		<Button type="submit"class="btn-secundary" >Actualizar</Button>
	</form>
<?php }?>