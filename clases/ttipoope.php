<?php
require_once("autoload.php");
class ttipoope extends conexion{
    //  --  Columnas --

    private int $CODOPE;
    private string $ABREOPE;
    private string $DESCOPE;
    private int $TIPMOV;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}