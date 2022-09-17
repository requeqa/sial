<?php
require_once("autoload.php");
class ponderacion extends conexion{
    //  --  Columnas --

    private int $IDPOND;
    private int $CODPRD;
    private int $IDMOV;
    private float $PONDUNIT;
    private int $PONDVIGENTE;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}