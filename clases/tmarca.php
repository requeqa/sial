<?php
require_once("autoload.php");
class tmarca extends conexion{
    //  --  Columnas --

    private int $CODMARC;
    private string $DESCMARC;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
    public function Nuevo($post){
        $this->DESCMARC = $post['DESCMARC'];
        $sql = "Insert Into tmarca(`DESCMARC`)Values(?)";        ///Modificar1
        $arrData = array( $this->DESCMARC);
        return $this->conexion->Insert($sql, $arrData);
    }
    public function Actualizar( $post){
        $this->DESCMARC = $post['DESCMARC'];
        $sql = "UPDATE tmarca Set DESCMARC=? WHERE CODMARC ={$post['CODMARC']};";  ///Modificar3     
        $arrData = array( $this->DESCMARC);      ///Modificar2
        $resUpdate = $this->conexion->Update($sql, $arrData);
        if($resUpdate == 1)return "--ID: {$post['DESCMARC']} Actualizado--";
        else return print_r($resUpdate);
    }
    public function TraerTodo(){
        $sql ="SELECT * from tmarca"; ///Modificar4
        return $this->conexion->Select($sql); 
    }
    public function getOne(int $ID){ //Llamada para cargar formulario
        $sql ="SELECT * from tmarca Where CODMARC = $ID"; ///Modificar5
        return $this->conexion->Select($sql);
    }
    public function doTable(){
        $dataset= $this->TraerTodo();
        Echo "<table class='table table-striped'><tr>
        <th>ID</th>
        <th>Descripcion</th>
        <th>Editar</th>
        </tr>";
        foreach($dataset as $linea){
            echo '<tr>';
            foreach($linea as $dato)echo "<td>$dato</td>";
            echo "<td><a href='?page=marca&act=edit&CODMARC={$linea['CODMARC']}'>editar</a></td>";
            echo '</tr>';
        }
        Echo "</table>";
    }

}