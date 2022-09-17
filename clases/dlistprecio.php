<?php
require_once("autoload.php");
class dlistprecio extends conexion{
    //  --  Columnas --

    private int $CODLISTPRE;
    private int $DETPRECIO;
    private int $CODPRD;
    private float $PRECVENT;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}