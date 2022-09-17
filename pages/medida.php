<?php
$mi_clase = new tmedida();
if(!empty($_POST)){
    if(!empty($_GET['act']))
        if($_GET['act']=="new")$mi_clase->Nuevo($_POST);
        elseif($_GET['act']=="edit")$mi_clase->Actualizar($_POST);


}elseif (!empty($_GET['CODUNID']))
	if ($_GET['act']=='edit') {
		$objeto = $mi_clase->getOne($_GET['CODUNID'])[0];		
	}
?>

<form action="?page=medida&act=<?php echo (!empty($_GET['CODUNID']))? 'edit':'new';?>" method="post">
    <table>
    <tr>
		<td>COD Medida:</td>
		<td><input type="text" name="CODUNID" class="form-control" value="<?php echo (!empty($_GET['CODUNID']))? $_GET['CODUNID']:'0';?>" readonly></td>
    </tr>
    <tr>
		<td>Abreviacion:</td>
		<td><input type="text" name="ABREUNID" class="form-control" value="<?php echo (!empty($objeto))? $objeto["ABREUNID"] :''; ?>"></td>
    </tr>
    <tr>
		<td>DESCRIPCION:</td>
		<td><input type="text" name="DESCRUNI" class="form-control" value="<?php echo (!empty($objeto))? $objeto["DESCRUNI"] :''; ?>"></td>
    </tr>
    <tr>
    	<td></td><td><input type="submit" value="<?php echo (!empty($_GET['CODUNID']))? 'Actualizar':'Nuevo';?>" ></td>
    </tr>
    </table>
</form>
<p>
<?php
$mi_clase->doTable();


echo '<pre>';
print_r ($_POST);
print_r ($_GET);
echo '</pre>';

?>