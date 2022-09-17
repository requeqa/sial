<?php
$mi_clase = new tmarca();
if(!empty($_POST)){
    if(!empty($_GET['act']))
        if($_GET['act']=="new")$mi_clase->Nuevo($_POST);
        elseif($_GET['act']=="edit")$mi_clase->Actualizar($_POST);


}elseif (!empty($_GET['CODMARC']))
	if ($_GET['act']=='edit') {
		$objeto = $mi_clase->getOne($_GET['CODMARC'])[0];		
	}
?>

<form action="?page=marca&act=<?php echo (!empty($_GET['CODMARC']))? 'edit':'new';?>" method="post">
    <table>
    <tr>
      <td>COD MArca:</td>
      <td><input type="text" name="CODMARC" class="form-control" value="<?php echo (!empty($_GET['CODMARC']))? $_GET['CODMARC']:'0';?>" readonly></td>
    </tr>
    <tr>
      <td>Descripcion:</td>
      <td><input type="text" name="DESCMARC" class="form-control" value="<?php echo (!empty($objeto))? $objeto["DESCMARC"] :''; ?>"  class="form-control"></td>
    </tr>    
    <tr>
      <td></td><td><input type="submit" value="<?php echo (!empty($_GET['CODMARC']))? 'Actualizar':'Nuevo';?>" ></td>
    </tr>
    </table>    
</form>
<p>
<?php
$mi_clase->doTable();

?>