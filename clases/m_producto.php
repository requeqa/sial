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
}
else {
    echo "no hay GET ";
}

 //       /*
require_once("autoload.php");

$objProducto = new Producto();
print_r("<pre>");
print_r($objProducto->getProducto(2));
print_r($objProducto->getProductos());
print_r("</pre>");

$respuesta = $objProducto->Actualizar(2, 999,"Cosa x","Cosa numero dos");
print_r ($respuesta) ;

//$respuesta = $objProducto->nuevo(123,"Cosa 1","Cosa numero uno");
//echo $respuesta ;


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