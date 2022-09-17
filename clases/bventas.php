<?php
require_once("autoload.php");
class bventas extends conexion{
    //  --  Columnas --

    private int $IDVENTA;
    private int $DETVENTA;
    private int $CODPRD;
    private int $CODLISTPRE;
    private int $CANTPRD;
    private float $PRECVENT;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}