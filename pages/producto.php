<?php
$mi_clase = new mproducto();
if(!empty($_POST)){
	if(!empty($_GET['act']))
		if($_GET['act']=="new")$mi_clase->Nuevo($_POST);
		elseif($_GET['act']=="edit")$mi_clase->Actualizar($_POST);
		elseif($_GET['act']=="add"){    // Cariito
				$arr =array($_GET['CODPRD'] => $_POST['CANTIDAD']);
				if ( ! session_id() ) {
						@ session_start();            
						array_push($_SESSION['carrito'],$arr);
				}
		}
}elseif (!empty($_GET['CODPRD'])) 
	if ($_GET['act']=='edit') {
		$producto = $mi_clase->getProducto($_GET['CODPRD'])[0];
			/*
		echo '<pre>';
		print_r($producto);
		echo '</pre>';
		//	*/
	}
?>
<form action="?page=producto&act=<?php echo (!empty($_GET['CODPRD']))? 'edit':'new';?>" method="post">
		<table>
		<tr>
			<td>COD PRODUCTO:</td>
			<td><input type="text" name="CODPRD" class="form-control" value="<?php echo (!empty($_GET['CODPRD']))? $_GET['CODPRD']:'0';?>" readonly></td>
		</tr>
			<tr>
			<td>COD PROVEEDOR:</td>
			<td><input type="text" name="CODPROV" class="form-control" value="<?php echo (!empty($producto))? $producto["CODPROV"] :''; ?>" placeholder="CODIGO PROVEEDOR"></td>
		</tr>
			<tr>
			<td>PRODUCTO:</td>
			<td><input type="text" name="NOMPROD" class="form-control" value="<?php echo (!empty($producto))? $producto["NOMPROD"] :''; ?>" placeholder="NOMBRE DEL PRODUCTO"></td>
		</tr>
		<tr>
		<td>DESCRIPCION 1:</td>
		<td><input type="text" name="DESCPROD1" class="form-control" value="<?php echo (!empty($producto))? $producto["DESCPROD1"] :''; ?>" placeholder="DESCRIPCION DEL PRODUCTO"></td>
		</tr>
		<tr>
		<td>LUGAR:</td>
		<td><input type="text" name="LUGAR" class="form-control" value="<?php echo (!empty($producto))? $producto["LUGAR"] :''; ?>" placeholder="Lugar"></td>
		</tr>
		<tr>
		<td>PROCEDENCIA:</td>
		<td><input type="text" name="PROCEDENCIA" class="form-control" value="<?php echo (!empty($producto))? $producto["PROCEDENCIA"] :''; ?>" placeholder="Procedencia"></td>
		</tr>
	<tr>
		<td>COD UNIDAD:</td>
		<td><?php $mi_clase->doListMedida((!empty($producto))? $producto["CODUNID"] :'0'); ?></td>
		</tr>
	<tr>
		<td>COD MARCA:</td>
		<td><?php $mi_clase->doListMarca((!empty($producto))? $producto["CODMARC"] :'0'); ?></td>
		</tr>
	<tr>
		<td>VIENCIA: </td>
		<td><?php $mi_clase->doListVigencia((!empty($producto))? $producto["VIGENCIA"] :'1'); ?></td>
		</tr>
		<tr><td></td><td><input type="submit" value="<?php echo (!empty($_GET['CODPRD']))? 'Actualizar':'Nuevo';?>" ></td></tr>
		</table>
</form>
<p>
<?php
/*
echo '<pre>';
print_r ($_POST);
print_r ($_GET);
echo '</pre>';
// */
$mi_clase->doTableProd(); 

?>