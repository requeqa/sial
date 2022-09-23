<?php
require_once("autoload.php");
class bmovimiento extends conexion{
    //  --  Columnas --

    private int $IDMOV;
    private int $IDDETALLE;
    private int $IDDETVENTA;
    private int $CODPRD;
    private string $GLOSAPRD;
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

    public function Ingreso($post){        
        //print_r($post);        
        $this->IDMOV = $post['IDMOV'];
        //$this->IDDETVENTA = $post['IDDETVENTA'];
        $this->CODPRD = $post['CODPRD'];
        $this->GLOSAPRD = $post['GLOSAPRD'];
        $this->CANTPRD = $post['CANTPRD'];
        $this->UNITPRD = $post['UNITPRD'];
        $this->TOTUNIT = $post['TOTUNIT'];
        
        $arrData = array( 
            $this->IDMOV,
            //$this->IDDETVENTA,
            $this->CODPRD,
            $this->GLOSAPRD,
            $this->CANTPRD,
            $this->UNITPRD,
            $this->TOTUNIT,
        );

        $sql = "INSERT INTO `bmovimiento` (`IDMOV`, `IDDETVENTA`, `CODPRD`, `GLOSAPRD`, `CANTPRD`, `UNITPRD`, `TOTUNIT`) VALUES (?,null,?,?,?,?,?);";
        //echo $sql;
        //print_r($arrData);        
        $id = $this->conexion->Insert($sql, $arrData);
        $idUPDATE = $this->actualizarInventario( $this->CODPRD,$this->CANTPRD,$this->UNITPRD,$this->TOTUNIT);

        return array('mov'=>$id,'imv'=>$idUPDATE); 
    }
    private function actualizarInventario($id,$CANT, $UNIT, $TOTU){
        $arrData = array($CANT, $UNIT, $TOTU);
        $sql = "UPDATE `binventario` SET `CANTPRD` =`CANTPRD`+ ?  , `UNITPRD` = `UNITPRD`+ ? , `TOTUNIT` = ? WHERE `CODPRD` = $id;";
        echo $sql;
        print_r($arrData);
        return $this->conexion->Insert($sql, $arrData);
    }



}