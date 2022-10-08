<?php
define("MODULO","venta");	//echo MODULO;
$objProd = new mproducto();
$objHmob;
$objBmob;
//$_SESSION=array();
if(!empty($_POST)){
	if(!empty($_GET['act']))
		if($_GET['act']=="add"){
			if(empty($_SESSION[MODULO])){$_SESSION[MODULO]=array();}
			$_SESSION[MODULO][$_GET['CODPRD']]=array(
				'CANTIDAD'=> $_POST['CANTIDAD'],
				'PRECIO'=>	($_POST['PRECIO']=="")?0:$_POST['PRECIO']);
		}elseif($_GET['act']=="submit"){
			echo '<pre>';
			$objHmob = new hmovimiento();			
			$IDIngreso = $objHmob->Salida($_POST['DESCGLOS'],$_POST['ttipoope'],0);
			//$IDIngreso = $objHmob->Ingreso('Descripcion Glosa',1);
			//echo "<br>Id Salida $IDIngreso <br>";
			
			$objBmob = new bmovimiento();
			//print_r ($_SESSION[MODULO]);
			foreach($_SESSION[MODULO] as $IdProd=>$Detalles ){
				$post=array();
				$post['IDMOV']= $IDIngreso ;
				$post['CODPRD']= $IdProd ;
				$post['GLOSAPRD']= '' ;
				$post['CANTPRD']= $Detalles['CANTIDAD'] ;
				$post['UNITPRD']= $Detalles['PRECIO'] ;
				$post['TOTUNIT']= $Detalles['PRECIO']*$Detalles['CANTIDAD'] ;			
				//if($_POST['ttipoope']==1)	$post['OP']= 1 ;				
				$IDDetSalida = $objBmob->Salida($post);
				//print_r($IDDetSalida);
			}	
			echo '</pre>';		
			$_SESSION[MODULO]=array();

			//*/
		}elseif($_GET['act']=="del"){
			unset($_SESSION[MODULO][$_GET['CODPRD']]);
		}
		
}

if(!empty($_SESSION[MODULO])){ ?>

	<div class="row">
		<div class="col-md-6">
			<form class="form-horizontal" action="?page=venta&act=submit" method="post">
			<div class="form-group">
				<label for="DESCGLOS" class="col-sm-2 control-label">Glosa</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="DESCGLOS" id="DESCGLOS" placeholder="Glosa" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="ttipoope" class="col-sm-2 control-label">Tipo Salida</label>
				<div class="col-sm-4">

					<?php 		
					$objHmob = new hmovimiento();					
					$objHmob->doListTmov(2,6);  
					?>

				</div>
			</div>			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-4">
				<button type="submit" class="btn btn-default">Ingresar</button>
				</div>
			</div>
			</form>
		</div>
		<div class="col-md-6">
			
			<table class="table table-striped table-responsive">
			<thead>
				<tr>
					<th>Id</th>
					<th>Nombre</th>
					<th>Cantidad</th>
					<th>Precio<br>Unitario</th>
					<th>Borrar</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($_SESSION[MODULO] as $key => $value) {
						
						echo "<tr>
						<form action='?page=".MODULO."&act=del&CODPRD={$key}' method='post' id='igreso{$key}'>
						
							<td><input type='hidden' id='CANTIDAD' name='CANTIDAD' value='$key'></td>
							<td> Nombre X </td>
							<td>{$value['CANTIDAD']}</td>
							<td>{$value['PRECIO']}</td>
							<td><button type='submit' form='igreso{$key}' value='Submit'>-</button></td>
						</form>
						</tr>";
					}
				?>
			</tbody>
			</table>
		</div>
	</div>
<?php
}
 $objProd->doTableMOV(MODULO); ?>