<?php
require_once("autoload.php");
class mproducto extends conexion{
	//  --  Columnas --

	private int $CODPRD;
	private string $CODPROV;
	private string $NOMPROD;
	private string $DESCPROD1;
	private string $LUGAR;
	private string $PROCEDENCIA;
	private int $CODUNID;
	private int $CODMARC;
	private int $VIGENCIA;

	//  --  Columnas  --
	private $conexion;
	private const VISTAPRD = "SELECT * from vw_productos order by 2 ";



	public function __construct(){
		$this->conexion = new conexion();    
	}
	public function Nuevo($post){
		$this->CODPROV = $post['CODPROV'];
		$this->NOMPROD = $post['NOMPROD'];
		$this->DESCPROD1 = $post['DESCPROD1'];
		$this->LUGAR = $post['LUGAR'];   
		$this->PROCEDENCIA = $post['PROCEDENCIA'];   
		$this->CODUNID = $post['CODUNID'];
		$this->CODMARC = $post['CODMARC'];
		$this->VIGENCIA = $post['VIGENCIA'];        
		
		$sql = "INSERT INTO mproducto(`CODPROV`,`NOMPROD`,`DESCPROD1`,`LUGAR`,`PROCEDENCIA`,`CODUNID`,`CODMARC`,`VIGENCIA`)VALUES(?,?,?,?,?,?,?,?)";        ///Modificar1
		$arrData = array( $this->CODPROV, $this->NOMPROD,$this->DESCPROD1,$this->LUGAR,$this->PROCEDENCIA,$this->CODUNID,$this->CODMARC,$this->VIGENCIA);      ///Modificar2
		$this->CODPRD = $this->conexion->Insert($sql, $arrData);
		
		$sql = "INSERT INTO `dlistprecio` (`CODLISTPRE`, `DETPRECIO`, `CODPRD`, `PRECVENT`)VALUES (1,NULL,?,0),(2,NULL,?,0),(3,NULL,?,0),(4,NULL,?,0);";
		$arrData = array($this->CODPRD,$this->CODPRD,$this->CODPRD,$this->CODPRD);
		$this->conexion->Insert($sql, $arrData);
		return $this->CODPRD;
	}
	public function Actualizar($post){
		$this->CODPROV = $post['CODPROV'];
		$this->NOMPROD = $post['NOMPROD'];
		$this->DESCPROD1 = $post['DESCPROD1'];
		$this->LUGAR = $post['LUGAR'];   
		$this->PROCEDENCIA = $post['PROCEDENCIA'];   
		$this->CODUNID = $post['CODUNID'];
		$this->CODMARC = $post['CODMARC'];
		$this->VIGENCIA = $post['VIGENCIA'];        
		
		$sql = "UPDATE mproducto Set CODPROV=?,NOMPROD=?, DESCPROD1=?, LUGAR=? ,PROCEDENCIA=? , CODUNID=?, CODMARC=?, VIGENCIA=?  WHERE CODPRD ={$post['CODPRD']};";  ///Modificar3     
		$arrData = array( $this->CODPROV,$this->NOMPROD,$this->DESCPROD1,$this->LUGAR,$this->PROCEDENCIA,$this->CODUNID,$this->CODMARC,$this->VIGENCIA);      ///Modificar2
		$resUpdate = $this->conexion->Update($sql, $arrData);
		if($resUpdate == 1)return "--ID: {$post['CODPRD']} Actualizado--";
		else return print_r($resUpdate);
	}
	public function SetPrice($post){
		foreach ($post as $key => $value) {
			$sql = "UPDATE `dlistprecio` SET `PRECVENT` = ? WHERE `dlistprecio`.`DETPRECIO` = ?; ";
			$arrData = array($value,$key);
			$resUpdate = $this->conexion->Update($sql, $arrData);					
		}
		return "Precio Actualizado";

	}

	public function getProductos(){
		$sql ="SELECT * from vw_productos order by 2"; ///Modificar4
		return $this->conexion->Select($sql); 
	}
	public function getProducto(int $ID){ //Llamada para cargar formulario
		$sql ="SELECT * from mproducto Where CODPRD = $ID"; ///Modificar5
		return $this->conexion->Select($sql); 
	}
	public function getInv(int $ID){ //Llamada para cargar formulario
		$sql ="SELECT * from mproducto Where CODPRD = $ID"; ///Modificar5
		return $this->conexion->Select($sql); 
	}
	public function getPrecio(int $IdProducto){
		$sql = "SELECT d.DETPRECIO, t.DESCLISTPRE, d.PRECVENT FROM `dlistprecio` d inner JOIN tlistprecio t on t.CODLISTPRE=d.CODLISTPRE WHERE CODPRD= $IdProducto ; ";		
		return $this->conexion->Select($sql); 
	}

	public function getWea(){
		//print ("en w3a");
			return $this->conexion->wea("mproducto");
	}
	public function getAll(){	// GET COLS
		$sql="SELECT COLUMN_NAME, DATA_TYPE, COLUMN_COMMENT, COLUMN_KEY
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE TABLE_SCHEMA = 'sial_demo' AND TABLE_NAME = 'mproducto';" ;           
		return $this->conexion->Select($sql); 
	}
	function doForm($DataSet){	//	REVIEW
		echo '<form action="mproducto.php" method="post">';
		foreach ($DataSet as $data) {
			//  echo "$nombre : $valor\n";
			$titulo=$placeholder="";
			list($titulo,$placeholder)= explode("|",$data["COLUMN_COMMENT"].";");
			$tipo = (in_array($data["DATA_TYPE"], array("int","decimal")))?"number":"text";
	
			$nombre= $data["COLUMN_NAME"];
			echo $titulo.":<input type=\"{$tipo}\" name=\"{$nombre}\" value=\"\" placeholder=\"{$placeholder}\"><br>";
		}
		echo "<input type=\"submit\"></form>";
	}

	function doTableProd(){     //Tabla de productos
		$sql = SELF::VISTAPRD;
		$DataSet = $this->conexion->Select(SELF::VISTAPRD); 
		echo '<table class="table table-striped">
		<thead>
		<tr>
			<th>CODPRD</th>
			<th>CODPROV</th>
			<th>NOMPROD</th>
			<th>DESCPROD1</th>
			<th>LUGAR</th>
			<th>PROCEDENCIA</th>
			<th>U.MEDIDA</th>
			<th>MARCA</th>
			<th>STOCK</th>
			<th>UNITARIO</th>
			<th>TOTAL</th>
			<th>C/F</th>
			<th>S/F</th>
			<th>Esp C/F</th>
			<th>Esp S/F</th>
			<th>Editar</th>
		</tr>
		</thead>
		<tbody>';             
		foreach ($DataSet as $linea){
			echo "<tr>";
			foreach($linea as $celda){                    
				echo "<td>$celda</td>";
			}
			echo "<td><a href='?page=producto&act=edit&CODPRD={$linea['CODPRD']}'>editar</a></td>";   
			echo "</td></tr>";
		}            
		echo '</tbody></table>';
	}	
	function doTableMOV($page,$mov,$Buscar){      // Tabla de Movimeinto
		$sql = "SELECT
					p.`CODPRD`,
					`CODPROV`,
					`NOMPROD`,
					`DESCPROD1`,
					`LUGAR`,
					ma.DESCMARC,
					`PROCEDENCIA`,
					me.ABREUNID,
					p.CANTPRD,
					p.UNITPRD,
					p.`MINPRD`
				FROM
					`mproducto` p
				INNER JOIN tmarca ma ON
					p.CODMARC = ma.CODMARC
				INNER JOIN tmedida me ON
					p.CODUNID = me.CODUNID
				WHERE 
					p.`VIGENCIA`=1 ".(($Buscar=="")?";":	
				"AND (`CODPROV` like '%{$Buscar}%'
				OR	`NOMPROD`	like '%{$Buscar}%'
				OR	`DESCPROD1`	like '%{$Buscar}%');"); // , `VIGENCIA`, `MINPRD`
				
		$dataSet = $this->conexion->Select($sql); 
		echo '<table class="table table-striped table-responsive">
		<thead>
		  <tr>
			<th>Id</th>
			<th>Codigo<br>proveedor</th>
			<th>Nombre</th>
			<th>Descripcion</th>
			<th>Lugar</th>
			<th>Marca</th>
			<th>Procedencia</th>
			<th>Medida</th>
			<th>En Inventario</th>
			'.(($mov==2)?'':'<th>Precio<br>Unitario</th>').'
			<th>Cantidad</th>
			'.(($mov==2)?'':'<th>Precio<br>Unitario</th>').'
			<th>Ingresar </th>
		  </tr>
		</thead>
		<tbody>';
		$canCols=($mov==2)?9:10;
		foreach ($dataSet as $linea){
			$dataX = array_slice($linea,0,$canCols);
			$warning =  ($linea['CANTPRD']>$linea['MINPRD'])?"":"class='warning'";
			echo "<tr $warning>";
			foreach($dataX as $celda){                    
				echo "<td>$celda</td>";
			}
			$max=($mov==2)?" max='{$linea['CANTPRD']}' ":"";
			echo "
			<form action='?page={$page}&act=add&CODPRD={$linea['CODPRD']}' method='post' id='mov{$linea['CODPRD']}'>
			<td><input type='number' name='CANTIDAD' min='1' $max value='0' size='5'></td>".
			(($mov==2)?"<input type='hidden' name='PRECIO' value ='{$linea['UNITPRD']}'>":"<td><input type='text' name='PRECIO' placeholder='0.00' size='5'></td>")."			
			<td><button type='submit' form='mov{$linea['CODPRD']}' value='Submit'>".(($_GET['page']=="salida")?"-":"+")."</button></td>
			</form>";
			echo "</tr>";
		}            
		echo '</tbody></table>';
	}
	function doTableTienda($page,$Buscar,$Lista){      // Tabla de Movimeinto
		$sql = "SELECT
				p.`CODPRD`,
				`CODPROV`,
				`NOMPROD`,
				`DESCPROD1`,
				`LUGAR`,
				ma.DESCMARC,
				`PROCEDENCIA`,
				me.ABREUNID,
				p.CANTPRD,
				l.PRECVENT,
				p.`MINPRD`
			FROM
				`mproducto` p
			INNER JOIN tmarca ma ON
				p.CODMARC = ma.CODMARC
			INNER JOIN tmedida me ON
				p.CODUNID = me.CODUNID
			INNER JOIN dlistprecio l ON
				p.CODPRD = l.CODPRD
			WHERE
				p.`VIGENCIA` = 1 AND l.CODLISTPRE = $Lista ".(($Buscar=="")?";":	
				"AND (`CODPROV` like '%{$Buscar}%'
				OR	`NOMPROD`	like '%{$Buscar}%'
				OR	`DESCPROD1`	like '%{$Buscar}%');");	// , `VIGENCIA`, `MINPRD`, Buscar
					
					
		$dataSet = $this->conexion->Select($sql); 
		echo '<table class="table table-striped table-responsive">
		<thead>
		  <tr>
			<th>Id</th>
			<th>Codigo<br>proveedor</th>
			<th>Nombre</th>
			<th>Descripcion</th>
			<th>Lugar</th>
			<th>Marca</th>
			<th>Procedencia</th>
			<th>Medida</th>
			<th>Stock</th>
			<th>Precio/U</th>
			<th>Cantidad</th>
			<th>Desc.</th>
			<th>Ingresar</th>
		  </tr>
		</thead>
		<tbody>';
		foreach ($dataSet as $linea){
			$dataX = array_slice($linea,0,10);
			$warning =  ($linea['CANTPRD']>$linea['MINPRD'])?"":"class='warning'";
			echo "<tr $warning>";
			foreach($dataX as $celda){                    
				echo "<td>$celda</td>";
			}
			echo "
			<form action='?page={$page}&act=add&CODPRD={$linea['CODPRD']}' method='post' id='venta{$linea['CODPRD']}'>
			<td>
				<input type='hidden' name='CODPROV' value='{$linea['CODPROV']}' size='5' readonly>
				<input type='hidden' name='PRECVENT' value='{$linea['PRECVENT']}' size='5' readonly>
				<input type='number' name='CANTIDAD' min='1' max='{$linea['CANTPRD']}' value='0' size='5'>
			</td>
			<td><input type='text' name='GLOSAPRD' placeholder='Descripcion' size='15'></td>
			<td><button type='submit' form='venta{$linea['CODPRD']}' value='Submit'>".(($_GET['page']=="salida")?"-":"+")."</button></td>
			</form>
					";
			echo "</tr>";
		}            
		echo '</tbody></table>';
	}
	function doMov(){
		$sql = "SELECT hm.`IDMOV`, hm.`FECHA`, hm.`DESCGLOS`, m.DESCMOV, o.DESCOPE, hm.IDVENTA, IF(hm.`TIPMOV`=1 ,SUM(TOTUNIT), 0) as Ingreso, IF(hm.`TIPMOV`=2 ,SUM(TOTUNIT), 0) as Salida 
		FROM hmovimiento hm inner JOIN bmovimiento bm on hm.IDMOV = bm.IDMOV inner JOIN ttipomov m on hm.TIPMOV = m.TIPMOV inner JOIN ttipoope o on hm.CODOPE = o.CODOPE GROUP BY 1 ORDER BY 2; ";
		$dataSet = $this->conexion->Select($sql);
		
		echo '<table class="table table-striped table-responsive">
		<thead>
		  <tr>
			<th>Fecha</th>
			<th>Glosa</th>
			<th>Movimiento</th>
			<th>Operacion</th>
			<th>Venta</th>
			<th>Ingreso</th>
			<th>Salida</th>
			<th>Ver</th>			
		  </tr>
		</thead>
		<tbody>';
		foreach ($dataSet as $linea){
			$dataX = array_slice($linea,1);
			$warning = "" ;
			echo "<tr $warning>";
			foreach($dataX as $celda){echo "<td>$celda</td>";}
			echo "</tr>";		}            
		echo '</tbody></table>';
	}
	function Kardex($id){
		$sql = "SELECT cast(hm.`FECHA` as date) as FECHA, hm.IDVENTA, bm.CANTPRD, IF(hm.`TIPMOV` = 1, bm.TOTUNIT,0) AS INGRESO, IF(hm.`TIPMOV` = 2, bm.TOTUNIT,0) AS SALIDA 
		FROM hmovimiento hm INNER JOIN bmovimiento bm ON hm.IDMOV = bm.IDMOV Where CODPRD = $id ORDER BY hm.IDMOV";
		$dataSet = $this->conexion->Select($sql);
		
		echo '<table class="table table-striped table-responsive">
		<thead>
		  <tr>
			<th>Fecha</th>
			<th>Venta</th>
			<th>Cantidad</th>
			<th>Ingreso</th>
			<th>Salida</th>			
		  </tr>
		</thead>
		<tbody>';
		foreach ($dataSet as $linea){
	//		$dataX = array_slice($linea,1);
			$warning = "" ;
			echo "<tr $warning>";
			foreach($linea as $celda){echo "<td>$celda</td>";}
			echo "</tr>";		}            
		echo '</tbody></table>';
	}


// Controles de Formulario
	function doListMarca($id){        
		$sql ="SELECT * from tmarca "; ///Modificar5
		$DataSet = $this->conexion->Select($sql);
		echo '<select class="form-control" name="CODMARC">';
		echo  ($id==0)?'<option value="0">Select...</option>':'';
		foreach ($DataSet as $data){
			$selected = ($data['CODMARC']==$id)?'Selected':'';
			echo "<option value='{$data['CODMARC']}' $selected >{$data['DESCMARC']}</option>";
		}
		echo '</select>';
		
	}

	function doListMedida($id){        
		$sql ="SELECT * from tmedida "; ///Modificar5
		$DataSet = $this->conexion->Select($sql);
		echo '<select class="form-control" name="CODUNID">';
		echo ($id==0)?'<option value="0">Select...</option>':'';        
		foreach ($DataSet as $data){
			$selected = ($data['CODUNID']==$id)?'Selected':'';
			echo "<option value='{$data['CODUNID']}' $selected >{$data['ABREUNID']}</option>";
		}            
		echo '</select>';
	}
	
	function doListVigencia($id){
		echo '<select class="form-control" name="VIGENCIA">';
		if($id==1)
			echo"<option value='1' selected>Vigente</option>            
			<option value='0'>Descontinuado</option>";
		else
			echo"<option value='1'>Vigente</option>            
			<option value='0' selected>Descontinuado</option>";
		echo"</select>";
	}
	function doListPrecio($id){        
		if($id==0){
			$sql = "SELECT * FROM `tlistprecio`;";
			$DataSet = $this->conexion->Select($sql);		
			echo "<select class='form-control' name='CODLISTPRE' required>";
				echo '<option value="" selected>Seleccionar...</option>';
			foreach ($DataSet as $data){
				echo "<option value='{$data['CODLISTPRE']}' >{$data['DESCLISTPRE']}</option>";
			}            
			echo '</select>';
		}
		else{
			$sql = "SELECT * FROM `tlistprecio` where `CODLISTPRE`= $id ;";
			$DataSet = $this->conexion->Select($sql)[0];
			echo "<input type='hidden' name='CODLISTPRE' id='CODLISTPRE' value='{$DataSet['CODLISTPRE']}' >";	
			echo "<input type='text' class='form-control' value='{$DataSet['DESCLISTPRE']}' readonly >";
		}		
	}




}