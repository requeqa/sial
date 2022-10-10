<?php
echo	"<h2>SIAL</h2>
<div id='recibo' hidden > 
<table id='muestra' class='table table-striped table-responsive'>
<tr><th>Nro: </th><td>{$_SESSION['Recibo']['VENTA']}</td><th>Fecha: </th><td colspan='3'>{$_SESSION['Recibo']['FECHA']}</td></tr>
<tr><th>Cliente</th><td colspan='4'>{$_SESSION['Recibo']['CLIENTE']}</td></tr>
<tr><th>Detalle</th></tr>
<tr><th>Producto</th>
<th>Glosario</th>
<th>Unidades</th>
<th>Unitario</th>
<th>Total</th></tr>";
$Tot=0;
foreach ($_SESSION['Recibo']["DETALLE"] as $linea) {
	echo "<tr>";
	foreach ($linea as $campo) {
		echo "<td> $campo </td>";
	}
	echo "</tr>";
	$Tot+=$linea["TOTUNIT"];
}
echo "<tr><td colspan='3'></td><th>Total:</th><th>{$Tot}</th></tr>
</table></div>";
?>

<button type='button' onclick='javascript:imprim2();'>Imprimir</button>
<script>
function imprim2(){
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');
    mywindow.document.write('<html><head>');
	//mywindow.document.write('<style>.tabla{width:100%;border-collapse:collapse;margin:16px 0 16px 0;}.tabla th{border:1px solid #ddd;padding:4px;background-color:#d4eefd;text-align:left;font-size:15px;}.tabla td{border:1px solid #ddd;text-align:left;padding:6px;}</style>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById('recibo').innerHTML);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necesario para IE >= 10
    mywindow.focus(); // necesario para IE >= 10
    mywindow.print();
    mywindow.close();
    return true;}
</script>  