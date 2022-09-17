<?php
require_once("autoload.php");
class Productoo extends conexion{
    private int $intID;
    private int $intCodigo;
    private string $strNombre;
    private string $strDescripcion;
    private $conexion;

    public function __construct($GET,$POST){
        $this->conexion = new conexion();
    //    $this->conexion = $this->conexion->connect();
    }
    

    public function nuevo($Codigo, $Nombre, $Descripcion){
        $this->intCodigo = $Codigo;
        $this->strNombre = $Nombre;
        $this->strDescripcion = $Descripcion;        
        
        $sql = "Insert Into producto(Codigo,Nombre,Descripcion)Values(?,?,?)";        ///Modificar1
        $arrData = array( $this->intCodigo,$this->strNombre,$this->strDescripcion);///Modificar2
        return $this->conexion->Insert($sql, $arrData);
    }

    public function Actualizar(int $ID, int $Codigo, string $Nombre, string $Descripcion){
        $this->intCodigo = $Codigo;
        $this->strNombre = $Nombre;
        $this->strDescripcion = $Descripcion;        
        
        $sql = "UPDATE producto Set Codigo=?, Nombre=?,Descripcion=? WHERE id =$ID;";  ///Modificar3      
        $arrData = array( $this->intCodigo,$this->strNombre,$this->strDescripcion); ///Modificar2
        $resUpdate = $this->conexion->Update($sql, $arrData);
        if($resUpdate == 1)return "--ID: $ID Actualizado--";
        else return print_r($resUpdate);
    }

    public function getAll(){
        $sql ="SELECT * from producto"; ///Modificar4
        return $this->conexion->Select($sql); 
    }
    public function getOne($ID){
        echo "in get producto";
        $this->intID= $ID;
        $sql ="SELECT * from producto Where id = $ID"; ///Modificar5
        echo $sql;
        return $this->conexion->Select($sql); 
    }

    public function getWea(){
    print ("en w3a")        ;
        return this->conexion->wea("producto");
    }
    public function getAll(){
        $sql="SELECT COLUMN_NAME, DATA_TYPE, COLUMN_COMMENT, COLUMN_KEY
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = 'sial_demo' AND TABLE_NAME = 'producto';" ;           
        return $this->conexion->Select($sql); 
    }
    function doForm($DataSet){
        echo "<form action=\"DEMO.php?ID=2\" method=\"post\">";
        foreach ($DataSet as $data) {
            //  echo "$nombre : $valor\n";
            $titulo=$placeholder="";
            list($titulo,$placeholder)= explode(";",$data["COLUMN_COMMENT"].";");
            $tipo = (in_array($data["DATA_TYPE"], array("int","decimal")))?"number":"text";
    
            $nombre= $data["COLUMN_NAME"];
            echo $titulo.":<input type=\"{$tipo}\" name=\"{$nombre}\" value=\"\" placeholder=\"{$placeholder}\"><br>";
        }
        echo "<input type=\"submit\"></form>";
    }




}
?>