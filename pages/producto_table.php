<?php
$mi_clase = new mproducto();




if(!empty($_POST)){
    if(!empty($_GET['act']))
        if($_GET['act']=="add"){
            $arr =array($_GET['CODPRD'] => $_POST['CANTIDAD']);
            if ( ! session_id() ) {
                @ session_start();            
                array_push($_SESSION['carrito'],$arr);
            }
        }

}


$mi_clase->doTableProd(); 
?>