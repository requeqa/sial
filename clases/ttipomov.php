<?php
require_once("autoload.php");
class ttipomov extends conexion{
    //  --  Columnas --

    private int $TIPMOV;
    private string $ABREMOV;
    private string $DESCMOV;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
}