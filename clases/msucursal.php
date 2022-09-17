<?php
require_once("autoload.php");
class msucursal extends conexion{
    //  --  Columnas --

    private int $IDSUC;
    private string $DESCSUC;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}