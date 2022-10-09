<?php
define("MODULO","venta");	//echo MODULO;
define("CLIENTE","cliente");	//echo MODULO;
$objProd = new mproducto();
$objHmob;
$objBmob;
//	$_SESSION=array();	// Reiniciar session	
if(!empty($_POST)){
	if(!empty($_GET['act']))
		if($_GET['act']=="add"){

			if(empty($_SESSION[MODULO])){$_SESSION[MODULO]=array();}
			$_SESSION[MODULO][$_GET['CODPRD']]=array(
				'CODPROV'=> $_POST['CODPROV'],
				'GLOSAPRD'=> $_POST['GLOSAPRD'],
				'CANTIDAD'=> $_POST['CANTIDAD'],
				'PRECIO'=>	$_POST['PRECVENT']);
		}elseif($_GET['act']=="submit" && !empty($_SESSION[CLIENTE])){
			echo '<pre>';
			$objHmob = new hmovimiento();						
			$IDVenta = $objHmob->Venta($_POST['DESCCLIENT'],$_POST['CODLISTPRE']);
			$IDSalida = $objHmob->Salida($_POST['DESCCLIENT'],6,$IDVenta);
			//$IDSalida = $objHmob->Ingreso('Descripcion Glosa',1);
			//echo "<br>Id Salida $IDSalida <br>";
			
			$objBmob = new bmovimiento();
			//print_r ($_SESSION[MODULO]);
			foreach($_SESSION[MODULO] as $IdProd=>$Detalles ){			
				$idDetVenta = $objBmob->Venta (
						$IDVenta,
						$IdProd,
						$Detalles['GLOSAPRD'],
						$_POST['CODLISTPRE'],
						$Detalles['CANTIDAD'],
						$Detalles['PRECIO']);
					
				$post=array();
				$post['IDMOV']= $IDSalida ;
				$post['IDDETVENTA']=$idDetVenta;
				$post['CODPRD']= $IdProd ;
				$post['GLOSAPRD']= $Detalles['GLOSAPRD'] ;
				$post['CANTPRD']= $Detalles['CANTIDAD'] ;
				$post['UNITPRD']= $Detalles['PRECIO'] ;
				$post['TOTUNIT']= $Detalles['PRECIO']*$Detalles['CANTIDAD'] ;			
				//if($_POST['ttipoope']==1)	$post['OP']= 1 ;				
				$IDDetSalida = $objBmob->Salida($post);
				//print_r($IDDetSalida);
			}	
			echo '</pre>';					
			unset($_SESSION[MODULO]);
			unset($_SESSION[CLIENTE]);
			//*/
		}elseif($_GET['act']=="del"){
			unset($_SESSION[MODULO][$_GET['CODPRD']]);
		}elseif($_GET['act']=="cli"){			
			if(empty($_SESSION[CLIENTE])){$_SESSION[CLIENTE]=array();}
			$_SESSION[CLIENTE]=array(
				'DESCCLIENT'=> $_POST['DESCCLIENT'],
				'CODLISTPRE'=> $_POST['CODLISTPRE']
			);
		}elseif($_GET['act']=="new"){
			unset($_SESSION[MODULO]);
			unset($_SESSION[CLIENTE]);
		}
		
}

 ?>

	<div class="row">
		<div class="col-md-4">
			<form class="form-horizontal" action="?page=venta&act=submit" method="post">
			<div class="form-group">
				<label for="DESCCLIENT" class="col-sm-2 control-label">Cliente</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="DESCCLIENT" id="DESCCLIENT" placeholder="Nombre Apellido" value="<?php echo (empty($_SESSION[CLIENTE]))?"":$_SESSION[CLIENTE]['DESCCLIENT']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="CODLISTPRE" class="col-sm-2 control-label">Lista de precio</label>
				<div class="col-sm-10">

					<?php
						$idPrLst=(empty($_SESSION['cliente']['CODLISTPRE']))?0:$_SESSION['cliente']['CODLISTPRE'];
						$objProd->doListPrecio($idPrLst); 
					?>

				</div>
			</div>			
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-2">
					<?php
						echo '<button type="submit" class="btn '.(empty($_SESSION[CLIENTE])?'btn-success':'btn-default').'" formaction="?page=venta&act=cli">'.(empty($_SESSION[CLIENTE])?'Iniciar':'Actualizar').'</button>';
						//else { echo '<button type="submit" class="btn btn-default">Lleno</button>';}					
					?>
				</div>
				<?php	if(!empty($_SESSION[CLIENTE])){	?>
				<div class="col-sm-offset-1 col-sm-2">
					<button type="submit" class="btn btn-secondary" formaction="?page=venta&act=new">Nuevo</button>
				</div>
				<div class="col-sm-offset-1 col-sm-2">
					<button type="submit" class="btn btn-success">VENDER</button>
				</div>
				<?php	} ?>
			</div>
				</form>
		</div>
		<div class="col-md-8">
			
			<table class="table table-striped table-responsive">
			<thead>
				<tr>
					<th>Id</th>
					<th>Nombre</th>
					<th>Glosa</th>
					<th>Cantidad</th>
					<th>Precio<br>Unitario</th>
					<th>Borrar</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(!empty($_SESSION[MODULO]))
					foreach ($_SESSION[MODULO] as $key => $value) {						
						echo "<tr>
						<form action='?page=".MODULO."&act=del&CODPRD={$key}' method='post' id='carrito{$key}'>						
							<td><input type='hidden' id='CANTIDAD' name='CANTIDAD' value='$key'></td>
							<td>{$value['CODPROV']}</td>
							<td>{$value['GLOSAPRD']}</td>
							<td>{$value['CANTIDAD']}</td>
							<td>{$value['PRECIO']}</td>
							<td><button type='submit' form='carrito{$key}' value='Submit'>-</button></td>
						</form>
						</tr>";
					}
				?>
			</tbody>
			</table>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-6">
			<form action="?page=venta" method="get">
				<input type="hidden" id="page" name="page" value="<?php echo MODULO;?>">
				<label for="fname">Buscar:</label><input type="text" id="buscar" name="buscar">	<input type="submit" value="Buscar">
			</form>
		</div>
		<div class="col-md-12">
			<?php
			if(!empty($_SESSION[CLIENTE])){
				$buscar = (empty($_GET['buscar']))?"":$_GET['buscar'];
				$objProd->doTableTienda(MODULO,$buscar,$_SESSION[CLIENTE]["CODLISTPRE"]);
			}	?>
		</div>


	</div>