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
		
		$sql = "Insert Into mproducto(`CODPROV`,`NOMPROD`,`DESCPROD1`,`LUGAR`,`PROCEDENCIA`,`CODUNID`,`CODMARC`,`VIGENCIA`)Values(?,?,?,?,?,?,?,?)";        ///Modificar1
		$arrData = array( $this->CODPROV, $this->NOMPROD,$this->DESCPROD1,$this->LUGAR,$this->PROCEDENCIA,$this->CODUNID,$this->CODMARC,$this->VIGENCIA);      ///Modificar2
		return $this->conexion->Insert($sql, $arrData);
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
		$sql ="SELECT * from vw_productos "; ///Modificar4
		return $this->conexion->Select($sql); 
	}
	public function getProducto(int $ID){ //Llamada para cargar formulario
		$sql ="SELECT * from mproducto Where CODPRD = $ID"; ///Modificar5
		return $this->conexion->Select($sql); 
	}

    public function getWea(){
        //print ("en w3a");
            return $this->conexion->wea("mproducto");
    }
    public function getAll(){
        $sql="SELECT COLUMN_NAME, DATA_TYPE, COLUMN_COMMENT, COLUMN_KEY
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = 'sial_demo' AND TABLE_NAME = 'mproducto';" ;           
        return $this->conexion->Select($sql); 
    }
    function doForm($DataSet){
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
    function doTableProd(){
        $sql = "Select * from vw_productos ";
        $DataSet = $this->conexion->Select($sql); 
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
    }function doTableINV(){
        $sql = "Select CODPRD, `CODPROV`,`NOMPROD`,`DESCPROD1`,`LUGAR`,`CODUNID`,`CODMARC` from mproducto";
        $dataSet = $this->conexion->Select($sql); 
        echo '<table class="table table-striped">
        <thead>
          <tr>
            <th>CODPRD</th>
            <th>CODPROV</th>
            <th>NOMPROD</th>
            <th>DESCPROD1</th>
            <th>LUGAR</th>
            <th>CODUNID</th>
            <th>CODMARC</th>
            <th>editar</th>
            <th>Cantidad</th>   
          </tr>
        </thead>
        <tbody>';             
        foreach ($dataSet as $linea){
            echo "<tr>";
            foreach($linea as $celda){                    
                echo "<td>$celda</td>";
            }
            echo "<td><a href='?page=producto&act=edit&CODPRD={$linea['CODPRD']}'>editar</a></td>";   
            echo "<td><form action='?page=productos&act=add&CODPRD={$linea['CODPRD']}' method='post'><input type='number name='CANTIDAD' value='0'><input type='submit'value='+' ></td></form> "; 
            echo "</td></tr>";
        }            
        echo '</tbody></table>';
    }



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