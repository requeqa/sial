<?php
require_once("autoload.php");
class tmedida extends conexion{
    //  --  Columnas --

    private int $CODUNID;
    private string $ABREUNID;
    private string $DESCRUNI;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
    public function Nuevo($post){
        $this->ABREUNID = $post['ABREUNID'];
        $this->DESCRUNI = $post['DESCRUNI'];
        $sql = "Insert Into tmedida(`ABREUNID`,`DESCRUNI`)Values(?,?)";        ///Modificar1
        $arrData = array( $this->ABREUNID,$this->DESCRUNI);
        return $this->conexion->Insert($sql, $arrData);
    }
    public function Actualizar( $post){
        $this->ABREUNID = $post['ABREUNID'];
        $this->DESCRUNI = $post['DESCRUNI'];
        $sql = "UPDATE tmedida Set ABREUNID=?, DESCRUNI=?  WHERE CODUNID ={$post['CODUNID']};";  ///Modificar3     
        $arrData = array( $this->ABREUNID,$this->DESCRUNI);      ///Modificar2
        $resUpdate = $this->conexion->Update($sql, $arrData);
        if($resUpdate == 1)return "--ID: {$post['CODUNID']} Actualizado--";
        else return print_r($resUpdate);
    }
    public function TraerTodo(){
        $sql ="SELECT * from tmedida"; ///Modificar4
        return $this->conexion->Select($sql); 
    }    
    public function getOne(int $ID){ //Llamada para cargar formulario
        $sql ="SELECT * from tmedida Where CODUNID = $ID"; ///Modificar5
        return $this->conexion->Select($sql);
    }
    public function doTable(){
        $dataset= $this->TraerTodo();
        Echo "<table class='table table-striped'><tr>
        <th>ID</th>
        <th>Abreviacion</th>
        <th>Unidad</th>
        <th>Editar</th>
        </tr>";
        foreach($dataset as $linea){
            echo '<tr>';
            foreach($linea as $dato)echo "<td>$dato</td>";
            echo "<td><a href='?page=medida&act=edit&CODUNID={$linea['CODUNID']}'>editar</a></td>";
            echo '</tr>';
        }
        Echo "</table>";
    }
}