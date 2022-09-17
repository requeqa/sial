<?php
require_once("autoload.php");
class Producto extends conexion{
    private $intID;
    private $intCodigo;
    private $strNombre;
    private $strDescripcion;
    private $conexion;

    public function __construct(){
        $this->conexion = new conexion();
    }

    public function nuevo(int $Codigo, string $Nombre, string $Descripcion){
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
        
        $sql = "UPDATE producto Set Codigo=?, Nombre=?, Descripcion=? WHERE id =$ID;";  ///Modificar3      
        $arrData = array( $this->intCodigo,$this->strNombre,$this->strDescripcion); ///Modificar2
        $resUpdate = $this->conexion->Update($sql, $arrData);
        if($resUpdate == 1)return "--ID: $ID Actualizado--";
        else return print_r($resUpdate);
    }
    public function getProductos(){
        $sql ="SELECT * from producto"; ///Modificar4
        return $this->conexion->Select($sql); 
    }
    public function getProducto(int $ID){
        $sql ="SELECT * from producto Where id = $ID"; ///Modificar5
        return $this->conexion->Select($sql); 
    }

    




}
?>