<h2>Mucho texto</h2>
<div id="muestra"> 
<table id="muestra" class="tabla">
<tr><th>Columna 1</th><th>Columna 2</th></tr>
<tr><td>datos...</td><td>datos....</td></tr>
<tr><td>datos...</td><td>datos...</td></tr>
</table></div>
<button type="button" onclick="javascript:imprim2();">Imprimir</button>

<script>
function imprim2(){
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');
    mywindow.document.write('<html><head>');
	mywindow.document.write('<style>.tabla{width:100%;border-collapse:collapse;margin:16px 0 16px 0;}.tabla th{border:1px solid #ddd;padding:4px;background-color:#d4eefd;text-align:left;font-size:15px;}.tabla td{border:1px solid #ddd;text-align:left;padding:6px;}</style>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById('muestra').innerHTML);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necesario para IE >= 10
    mywindow.focus(); // necesario para IE >= 10
    mywindow.print();
    mywindow.close();
    return true;}
</script>  