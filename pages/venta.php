<?php
define("MODULO","venta");	//echo MODULO;
define("CLIENTE","cliente");	//echo MODULO;
$objProd = new mproducto();
$objHmob;
$objBmob;
$recibo=array();
//	$_SESSION=array();	// Reiniciar session	
if(!empty($_POST)){
	if(!empty($_GET['act']))
		if($_GET['act']=="add"){

			if(empty($_SESSION[MODULO])){$_SESSION[MODULO]=array();}
			$_SESSION[MODULO][$_GET['CODPRD']]=array(
				'CODPROV'	=>	$_POST['CODPROV'],
				'GLOSAPRD'	=>	$_POST['GLOSAPRD'],
				'CANTIDAD'	=>	$_POST['CANTIDAD'],
				'PRECIO'	=>	$_POST['PRECVENT']);
		}elseif($_GET['act']=="submit" && !empty($_SESSION[CLIENTE])){
			echo '<pre>';
			$objHmob = new hmovimiento();						
			$IDVenta = $objHmob->Venta($_POST['DESCCLIENT'],$_POST['CODLISTPRE']);
			$IDSalida = $objHmob->Salida($_POST['DESCCLIENT'],6,$IDVenta);
			$objBmob = new bmovimiento();
			$reciboDet= array();
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
				$IDDetSalida = $objBmob->Salida($post);				
				array_push($reciboDet, array_slice($post,2));				
			}	
			$_SESSION['Recibo']=array('VENTA'=>$IDVenta,'FECHA'=>date("Y-m-d H:i:s", strtotime('-6 hours'),'CLIENTE'=>$_POST['DESCCLIENT'],'VENTA'=>$IDVenta,'DETALLE'=>$reciboDet);	
			print_r($recibo);
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
echo	"<div id='recibo' hidden > 
<table id='muestra' class='tabla'>
<tr><th>Nro: </th><td>{$_SESSION['Recibo']['VENTA']}</td><th>Fecha: </th><td colspan='3'>{$_SESSION['Recibo']['FECHA']}</td></tr>
<tr><th>Cliente</th><td colspan='4'>{$_SESSION['Recibo']['CLIENTE']}</td></tr>
<tr><th>Detalle</th></tr>
<tr><th>Producto</th>
<th>Glosario</th>
<th>Unidades</th>
<th>Unitario</th>
<th>Total</th></tr>";
$Tot=0;
foreach ($_SESSION['Recibo']["DETALLE"] as $linea) {
	echo "<tr>";
	foreach ($linea as $campo) {echo "<td> $campo </td>";}
	echo "</tr>";
	$Tot+=$linea["TOTUNIT"];
}
echo "<tr><td colspan='3'></td><th>Total:</th><th>{$Tot}</th></tr>
</table></div>";
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
						<button type="submit" class="btn btn-primary">VENDER</button>
					</div>
					<?php	} ?>

					<div class="col-sm-offset-1 col-sm-2">
						<button type='button' class="btn btn-info" onclick='javascript:imprim2();'>Imprimir</button>
						<script>
						function imprim2(){
							var mywindow = window.open('', 'PRINT', 'height=400,width=600');
							mywindow.document.write('<html><head>');
							mywindow.document.write('<style>.tabla{width:100%;border-collapse:collapse;margin:16px 0 16px 0;}.tabla th{border:1px solid #ddd;padding:4px;background-color:#d4eefd;text-align:left;font-size:15px;}.tabla td{border:1px solid #ddd;text-align:left;padding:6px;}</style>');
							mywindow.document.write('</head><body >');
							mywindow.document.write(document.getElementById('recibo').innerHTML);
							mywindow.document.write('</body></html>');
							mywindow.document.close(); // necesario para IE >= 10
							mywindow.focus(); // necesario para IE >= 10
							mywindow.print();
							mywindow.close();
							return true;}
						</script>  
					</div>
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