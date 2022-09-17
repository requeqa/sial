<?php
$objProducto;
if(!empty($_POST))
{
    print_r("POST<pre>");
    print_r($_POST);
    print_r("</pre>");
}
else {
    echo "no hay post ";
}
if(!empty($_GET))
{
    print_r("POST<pre>");
    print_r($_GET);
    print_r("</pre>");
    //$objProducto = new Productoo($_GET["ID"]);
}
else {
    echo "no hay GET ";
}

 //       /*
require_once("autoload.php");

$objProducto = new Productoo();
print_r("<pre>");
print_r($objProducto->getProducto(2));
print_r($objProducto->getProductos());
print_r($objProducto->getWea());
print_r("</pre>");

//$respuesta = $objProducto->nuevo("321",111,"Cosa numero uno");
//echo $respuesta ;

//$respuesta = $objProducto->Actualizar("3", "888","Cosa x","Cosa numero dos");
//print_r ($respuesta) ;


$cosas = get_class_vars(get_class($objProducto));        
print_r($cosas);

// */
?>
<form action="m_producto.php" method="post">
            <input type="hide" name="ID" value=<?php echo (!empty($_GET["ID"]))? "\"".$_GET["ID"]."\"":"\"\""; ?>><br>
    Codigo: <input type="text" name="codigo"><br>
    Nombre: <input type="text" name="nombre"><br>
Descripcion: <input type="text" name="descripcion"><br>
<input type="submit">
</form>