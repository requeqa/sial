<?php
require_once("autoload.php");
class bmovimiento extends conexion{
    //  --  Columnas --

    private int $IDMOV;
    private int $IDDETALLE;
    private int $IDDETVENTA;
    private int $CODPRD;
    private int $GLOSAPRD;
    private int $CANTPRD;
    private float $UNITPRD;
    private float $TOTUNIT;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct(){
        $this->conexion = new conexion();    
    }
    public function Nuevo($post){
        $this->IDMOV = $post['IDMOV'];
        $this->IDDETVENTA = $post['IDDETVENTA'];
        $this->CODPRD = $post['CODPRD'];
        $this->GLOSAPRD = $post['GLOSAPRD'];
        $this->CANTPRD = $post['CANTPRD'];
        $this->UNITPRD = $post['UNITPRD'];
        $this->TOTUNIT = $post['TOTUNIT'];
        $sql = "INSERT INTO `bmovimiento` (`IDMOV`, `IDDETVENTA`, `CODPRD`, `GLOSAPRD`, `CANTPRD`, `UNITPRD`, `TOTUNIT`) VALUES (?,?,?,?,?,?,?);";
        $arrData = array( 
            $this->IDMOV,
            $this->IDDETVENTA,
            $this->CODPRD,
            $this->GLOSAPRD,
            $this->CANTPRD,
            $this->UNITPRD,
            $this->TOTUNIT,
        );
        return $this->conexion->Insert($sql, $arrData);
    }
}