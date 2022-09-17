<?php
require_once("autoload.php");
class hmovimiento extends conexion{
    //  --  Columnas --

    private int $IDMOV;
    private string $FECHA;
    private string $DESCGLOS;
    private string $ABROPE;
    private int $OPNULO;
    private int $IDVENTA;
    private int $CODOPE;
    private int $TIPMOV;
    private int $IDSUC;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}