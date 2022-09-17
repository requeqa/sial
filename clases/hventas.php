<?php
require_once("autoload.php");
class hventas extends conexion{
    //  --  Columnas --

    private int $IDVENTA;
    private int $CODOPE;
    private int $TIPMOV;
    private int $CODLISTPRE;
    private int $OPNULO;
    private string $DESCCLIENT;
    private string $FECHAVENT;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}