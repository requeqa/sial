<?php
$mi_clase = new mproducto();

echo '<pre>';

//$_SESSION['carrito']=array();
if(!empty($_POST)){
    if(!empty($_GET['act']))
        if($_GET['act']=="add"){
            if(empty($_SESSION['carrito'])){$_SESSION['carrito']=array();}
            $arrX = $_SESSION['carrito'];
            //print_r($arrX);

            $arr =array('CODPRD'=>$_GET['CODPRD'],'CANTIDAD'=> $_POST['CANTIDAD'],'PRECIO'=>$_POST['PRECIO']);                        
            //print_r($arr);

            array_push($arrX,$arr);       
            //print_r($arrX);
            
            $_SESSION['carrito']= $arrX;
        }
}
//    Echo '---GET---';
//    print_r($_GET);
 //   Echo '---POST---';
  //  print_r($_POST);
  //  Echo '---Session---';
print_r($_SESSION['carrito']);
echo '</pre>';


$mi_clase->doTableINV(); 
?>