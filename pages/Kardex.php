<?php
define("MODULO","kardex");	//echo MODULO;
define("CLIENTE","cliente");	//echo MODULO;
$objProd = new mproducto();
$objHmob;
$objBmob;

?>

<div class="row">
		<div class="col-md-5">
			<form action="?page=venta" method="get">
				<input type="hidden" id="page" name="page" value="<?php echo MODULO;?>">
				<label for="fname">Buscar:</label><input type="text" id="buscar" name="buscar">	<input type="submit" value="Buscar">
			</form>
		</div>
		<div class="col-md-9">
			<?php		
				$buscar = (empty($_GET['buscar']))?"":$_GET['buscar'];
				if ($buscar!="")$objProd->Kardex($buscar);
		    ?>
		</div>


	</div>