<?php
define("HEAD","Cabecer");
define("BODY","Cuerpo");
define("MODULO","ingreso");
$objProd = new mproducto();
$objHmob;
$objBmob;
//$_SESSION=array();
if(!empty($_POST)){
	if(!empty($_GET['act']))
		if($_GET['act']=="add"){
			if(empty($_SESSION[MODULO])){$_SESSION[MODULO]=array();}
			$_SESSION[MODULO][BODY][$_GET['CODPRD']]=array(
				'CANTIDAD'=> $_POST['CANTIDAD'],
				'PRECIO'=>$_POST['PRECIO']);
		}elseif($_GET['act']=="submit"){
			echo '<pre>';
			$objHmob = new hmovimiento();			
			$IDIngreso = $objHmob->Ingreso($_POST['DESCGLOS'],$_POST['ttipoope']);
			
			$objBmob = new bmovimiento();
			foreach($_SESSION[MODULO][BODY] as $IdProd=>$Detalles ){
				$post=array();
				$post['IDMOV']= $IDIngreso ;
				$post['CODPRD']= $IdProd ;
				$post['GLOSAPRD']= '' ;
				$post['CANTPRD']= $Detalles['CANTIDAD'] ;
				$post['UNITPRD']= $Detalles['PRECIO'] ;
				$post['TOTUNIT']= $Detalles['PRECIO']*$Detalles['CANTIDAD'] ;	
				$IDDetIngreso = $objBmob->Ingreso($post);
			}	
			echo '</pre>';		
			$_SESSION[MODULO]=array();
		}elseif($_GET['act']=="del"){
			unset($_SESSION[MODULO][BODY][$_GET['CODPRD']]);
		}elseif ($_GET['act']==HEAD) {			
			$_SESSION[MODULO][HEAD]=array(
				'DESCGLOS'=> $_POST['DESCGLOS'],
				'ttipoope'=> $_POST['ttipoope']);
		}
		
}
?>

	<div class="row">
		<div class="col-md-6">
			<form class="form-horizontal" action="?page=ingreso&act=submit" method="post">
			<div class="form-group">
				<label for="DESCGLOS" class="col-sm-2 control-label">Glosa</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="DESCGLOS" id="DESCGLOS" placeholder="Glosa" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="ttipoope" class="col-sm-2 control-label">Tipo Ingreso</label>
				<div class="col-sm-4">

					<?php 		
					$objHmob = new hmovimiento();					
					$idTiOp=(empty($_SESSION[MODULO][HEAD]))?0:$_SESSION[MODULO][HEAD]['ttipoope'];										
					$objHmob->doListTmov(1,$idTiOp);  
					?>

				</div>
			</div>			
			<div class="form-group">				
				<div class="col-sm-offset-1 col-sm-2">
						<?php echo '<button type="submit" class="btn '.(empty($_SESSION[MODULO][HEAD])?'btn-success':'btn-default').'" formaction="?page='.MODULO.'&act='.HEAD.'">'.(empty($_SESSION[MODULO][HEAD])?'Iniciar':'Actualizar').'</button>'; ?>
					</div>

					<?php	if(!empty($_SESSION[MODULO][HEAD])){	?>
					<div class="col-sm-offset-1 col-sm-2">
						<button type="submit" class="btn btn-secondary" formaction="?page=venta&act=new">Nuevo</button>
					</div>
					<div class="col-sm-offset-1 col-sm-2">
						<button type="submit" class="btn btn-success">Finalizar</button>
					</div>
					<?php	} ?>
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
					if(!empty($_SESSION[MODULO][BODY]))
					foreach ($_SESSION[MODULO][BODY] as $key => $value) {
						
						echo "<tr>
						<form action='?page=".MODULO."&act=del&CODPRD={$key}' method='post' id='igreso{$key}'>
						
							<td><input type='hidden' id='CANTIDAD' name='CANTIDAD' value='$key'>$key</td>
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
	<div class="row">
		<div class="col-md-6">
			<form action="?page=venta" method="get">
				<input type="hidden" id="page" name="page" value="<?php echo MODULO;?>">
				<label for="fname">Buscar:</label><input type="text" id="buscar" name="buscar">	<input type="submit" value="Buscar">
			</form>
		</div>
		<div class="col-md-12">
			<?php
			if(!empty($_SESSION[MODULO][HEAD])){
				$buscar = (empty($_GET['buscar']))?"":$_GET['buscar'];
				$objProd->doTableMOV(MODULO,1,$buscar); 
			}	?>
		</div>
	</div>