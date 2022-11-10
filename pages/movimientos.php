<?php
define("MODULO","movimiento");	//echo MODULO;
$objProd = new mproducto();
$show=(!empty($_SESSION[USUARIO]))?1:0;

$idate=(!empty($_POST["datei"]))? $_POST["datei"]:0;
$itxt=($idate==0)?"":" value='{$idate}'";
$fdate=(!empty($_POST["datef"]))? $_POST["datef"]:0;
$ftxt=($fdate==0)?"":" value='{$fdate}'";
//    $idate=(!empty($_POST["datei"]))?strtotime($_POST["datei"]):0;
//    $fdate=(!empty($_POST["datef"]))?strtotime($_POST["datef"]):0;
//echo " $idate - $fdate ";




    $IDMov;
    if (!empty($_GET['IDMov']))
    {
        $IDMov=$_GET['IDMov'];
?>
<h1>Detalle Movimiento</h1>
<div class="row">
    <div class="col-md-6">
    <?php
        $objProd->doHeadMov($IDMov);
    ?>
    </div>  
    <div class="col-md-6">
    <?php
        $objProd->doDetMov($IDMov,$show);
    ?>
    </div>  
</div>
    <?php
    }
    else{
?>
<h1>Movimientos</h1>
        <form action="?page=movimientos" method="post">
            <div class="form-row">
                <div class="col-md-2">
                    <label for="datei">Desde:</label>
                    <input type="date" class="form-control" id="datei" name="datei" <?php echo $itxt; ?> >
                </div>
                <div class="col-md-2"><label for="datef">Hasta:</label>
                    <input type="date" class="form-control" id="datef" name="datef" <?php echo $ftxt; ?>>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
    
<div class="row">
    <div class="col-md-11">
        <?php
            $objProd->doMov($show,$idate,$fdate);
        ?>
    </div>
</div>
<?php
    }    
?>
	    
	