<?php 
require_once("autoload.php");
header("Pragma: public");
header("Expires: 0");
$filename = "nombreArchivoQueDescarga.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?>
<table>
<tbody>
<tr>
    <th>
    <h2>Listado en tabla excel</h2>
    </th>
</tr>
<tr>
    <td>1</td>
</tr>
</tbody>
</table>