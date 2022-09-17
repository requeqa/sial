<?php
require_once("autoload.php");
class binventario extends conexion{
    //  --  Columnas --

    private int $DETINVENT;
    private int $IDSUC;
    private int $CODPRD;
    private int $CANTPRD;
    private float $UNITPRD;
    private float $TOTUNIT;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}