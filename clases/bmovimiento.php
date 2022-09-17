<?php
require_once("autoload.php");
class bmovimiento extends conexion{
    //  --  Columnas --

    private int $IDMOV;
    private int $IDDETALLE;
    private int $IDDETVENTA;
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