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
		
		$sql = "INSERT INTO `binventario` (`DETINVENT`, `IDSUC`, `CODPRD`, `CANTPRD`, `UNITPRD`, `TOTUNIT`) VALUES (null, '1',?,'0','0','0');";
		$arrData = array($this->CODPRD);
		$this->CODPRD = $this->conexion->Insert($sql, $arrData);
		
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
			<th>CODUNID</th>
			<th>CODMARC</th>
			<th>Cantidad</th>   
			<th>Unitario</th>   
			<th>Editar</th>
		  </tr>
		</thead>
		<tbody>';             
		foreach ($DataSet as $linea){
			echo "<tr>";
			foreach($linea as $celda){                    
				echo "<td>$celda</td>";
			}
			echo "<td>0</td>"; 
			echo "<td>0,00</td>"; 
			echo "<td><a href='?page=producto&act=edit&CODPRD={$linea['CODPRD']}'>editar</a></td>";   
			echo "</td></tr>";
		}            
		echo '</tbody></table>';
	}	
	function doTableMOV($page){      // Tabla de Movimeinto
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
					p.CODUNID = me.CODUNID;
				WHERE 
					p.`VIGENCIA`=1S	"; // , `VIGENCIA`, `MINPRD`
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
			<th>Precio<br>Unitario</th>
			<th>Cantidad</th>
			<th>Precio<br>Unitario</th>
			<th>Ingresar </th>
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
			<form action='?page={$page}&act=add&CODPRD={$linea['CODPRD']}' method='post' id='igreso{$linea['CODPRD']}'>
			<td><input type='number' name='CANTIDAD' min='1' max='{$linea['CANTPRD']}' value='0' size='5'></td>
			<td><input type='text' name='PRECIO' placeholder='0.00' size='5'></td>
			<td><button type='submit' form='igreso{$linea['CODPRD']}' value='Submit'>".(($_GET['page']=="salida")?"-":"+")."</button></td>
			</form>
					";
			echo "</tr>";
		}            
		echo '</tbody></table>';
	}
	function doTableTienda($page,$Buscar){      // Tabla de Movimeinto
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
					p.CODUNID = me.CODUNID;
				WHERE 
					p.`VIGENCIA`=1 ".(($Buscar=="")?";":	
				"AND (`CODPROV`= $Buscar
				OR	`NOMPROD` = $Buscar
				OR	`DESCPROD1`= $Buscar);");	// , `VIGENCIA`, `MINPRD`, Buscar
					
					
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
			<th>Precio/U</th>
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
			<form action='?page={$page}&act=add&CODPRD={$linea['CODPRD']}' method='post' id='igreso{$linea['CODPRD']}'>
			<td><input type='number' name='CANTIDAD' min='1' max='{$linea['CANTPRD']}' value='0' size='5'></td>
			<td><input type='text' name='PRECIO' placeholder='0.00' size='5'></td>
			<td><input type='text' name='DESC' placeholder='Descripcion' size='5'></td>
			<td><button type='submit' form='igreso{$linea['CODPRD']}' value='Submit'>".(($_GET['page']=="salida")?"-":"+")."</button></td>
			</form>
					";
			echo "</tr>";
		}            
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




}