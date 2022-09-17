<?php
require_once("autoload.php");
class tlistprecio extends conexion{
    //  --  Columnas --

    private int $CODLISTPRE;
    private string $DESCLISTPRE;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}