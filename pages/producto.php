<?php
$mi_clase = new mproducto();
$IDProd=0;
$Notif="";
if(!empty($_POST)){
	if(!empty($_GET['act']))
		if($_GET['act']=="new")$IDProd=$mi_clase->Nuevo($_POST);
		elseif($_GET['act']=="edit")$mi_clase->Actualizar($_POST);
		elseif($_GET['act']=="add"){    // Carrito
			$arr =array($_GET['CODPRD'] => $_POST['CANTIDAD']);
			if ( ! session_id() ) {
				@ session_start();            
				array_push($_SESSION['carrito'],$arr);
			}
		}elseif($_GET['act']=="price"){
			$mi_clase->SetPrice($_POST['PRECIO']);
		}
}elseif (!empty($_GET['CODPRD'])) 
	if ($_GET['act']=='edit') {
		$IDProd=$_GET['CODPRD'];
		$producto = $mi_clase->getProducto($IDProd)[0];		
	}
?>

<div class="row">
	<div class="col-md-4">
		<form action="?page=producto&act=<?php echo (!empty($_GET['CODPRD']))? 'edit':'new';?>" method="post">
			<table>
			<tr>
				<td>COD PRODUCTO:</td>
				<td><input type="text" name="CODPRD" class="form-control" value="<?php echo (!empty($_GET['CODPRD']))? $_GET['CODPRD']:'0';?>" readonly></td>
			</tr><tr>
				<td>COD PROVEEDOR:</td>
				<td><input type="text" name="CODPROV" class="form-control" value="<?php echo (!empty($producto))? $producto["CODPROV"] :''; ?>" placeholder="CODIGO PROVEEDOR"></td>
			</tr><tr>
				<td>PRODUCTO:</td>
				<td><input type="text" name="NOMPROD" class="form-control" value="<?php echo (!empty($producto))? $producto["NOMPROD"] :''; ?>" placeholder="NOMBRE DEL PRODUCTO"></td>
			</tr><tr>
				<td>DESCRIPCION 1:</td>
				<td><input type="text" name="DESCPROD1" class="form-control" value="<?php echo (!empty($producto))? $producto["DESCPROD1"] :''; ?>" placeholder="DESCRIPCION DEL PRODUCTO"></td>
			</tr><tr>
				<td>LUGAR:</td>
				<td><input type="text" name="LUGAR" class="form-control" value="<?php echo (!empty($producto))? $producto["LUGAR"] :''; ?>" placeholder="Lugar"></td>
			</tr><tr>
				<td>PROCEDENCIA:</td>
				<td><input type="text" name="PROCEDENCIA" class="form-control" value="<?php echo (!empty($producto))? $producto["PROCEDENCIA"] :''; ?>" placeholder="Procedencia"></td>
			</tr><tr>
				<td>COD UNIDAD:</td>
				<td><?php $mi_clase->doListMedida((!empty($producto))? $producto["CODUNID"] :'0'); ?></td>
				</tr>
			<tr>
				<td>COD MARCA:</td>
				<td><?php $mi_clase->doListMarca((!empty($producto))? $producto["CODMARC"] :'0'); ?></td>
			</tr><tr>
				<td>VIGENCIA: </td>
				<td><?php $mi_clase->doListVigencia((!empty($producto))? $producto["VIGENCIA"] :'1'); ?></td>
			</tr><tr><td></td><td>
			<button type="button" class="btn btn-primary"><?php echo (!empty($_GET['CODPRD']))? 'Actualizar Producto':'Guardar Nuevo Producto';?></button>			
			</table>
		</form>
	</div>
	<div class="col-md-4">
		<form class="form-horizontal" action="?page=producto&act=price" method="post" >
			<?php	
			if($IDProd!=0 && (!empty($_SESSION[USUARIO]))){
				echo 
				'<div class="form-group">
					<div class="col-sm-9">
						<h3>Lista de Precios</h3>
					</div>
				</div>';	

				$dataSet= $mi_clase->getPrecio($IDProd);	
				foreach ($dataSet as $value) {
					echo '<div class="form-group">
							<label for="PRECIO" class="col-sm-3 control-label">'.$value['DESCLISTPRE'].'</label>	
							<div class="col-sm-9">
								<input type="text" class="form-control" name="PRECIO['.$value['DETPRECIO'].']" placeholder="'.$value['PRECVENT'].'" value="'.$value['PRECVENT'].'" '.(($IDProd==0)?"disabled":"").' >
							</div>
						</div>';
				}

				?>
	
			<div class="form-group">					
				<div class="col-sm-offset-1 col-sm-2">
					<button type="submit" class="btn btn-primary" <?php echo ($IDProd==0)?"disabled":"";?>>Guardar Precios</button>
				</div>
			</div>
			<?php } ?>
		</form>
	</div>
</div>
<p>
<?php
/*
echo '<pre>';
print_r ($_POST);
print_r ($_GET);
echo '</pre>';
// */
$show=(!empty($_SESSION[USUARIO]))?1:0;
$mi_clase->doTableProd($show); 

?>