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

	private int $OP;
	
	//  --  Columnas  --
	private $conexion;
	public function __construct(){
		$this->conexion = new conexion();    
	}
	
	public function SetVarsArr($post){    //Setea las variables del $post
		$this->IDMOV = $post['IDMOV'];
		if(isset($post['IDDETALLE']))   $this->IDDETALLE = $post['IDDETALLE']; 
		$this->IDDETVENTA = (isset($post['IDDETVENTA']))?$post['IDDETVENTA']:0 ;
		$this->CODPRD = $post['CODPRD'];
		$this->GLOSAPRD = $post['GLOSAPRD'];
		$this->CANTPRD = $post['CANTPRD'];
		$this->UNITPRD = ($post['UNITPRD']=="")?0:$post['UNITPRD'];
		$this->TOTUNIT = $post['TOTUNIT'];
		$this->OP = (isset($post['OP']))?$post['OP']:0 ;
		return 1;
	}
	public function GetVarsArr(){  //Obtiene un arreglo de las vaiables apra ingrear los datos
		if($this->IDDETVENTA==0){
			$arrData = array( 
				$this->IDMOV,
				//$this->IDDETVENTA,
				$this->CODPRD,
				$this->GLOSAPRD,
				$this->CANTPRD,
				$this->UNITPRD,
				$this->TOTUNIT
			);
		}else{            
			$arrData = array( 
				$this->IDMOV,
				$this->IDDETVENTA,
				$this->CODPRD,
				$this->GLOSAPRD,
				$this->CANTPRD,
				$this->UNITPRD,
				$this->TOTUNIT,
			);
		}
		return $arrData;
	}
	public function GetInv(int $ID){
		$sql ="SELECT `CODPRD`, `CANTPRD`, `UNITPRD`  from mproducto Where CODPRD = $ID"; ///
		echo $sql;
		return $this->conexion->Select($sql); 
	}
	

	public function Nuevo($post){
		$x= $this->SetVarsArr($post);
		$arrData = $this->GetVarsArr();
		$sql = "INSERT INTO `bmovimiento` (`IDMOV`, `IDDETVENTA`, `CODPRD`, `GLOSAPRD`, `CANTPRD`, `UNITPRD`, `TOTUNIT`) VALUES (?,".(($this->IDDETVENTA==0)?"null":"?").",?,?,?,?,?);";
		return $this->conexion->Insert($sql,$arrData);
	}
	public function Ingreso($post){  
		$x= $this->SetVarsArr($post);

		$arrData = $this->GetVarsArr();
		$sql = "INSERT INTO `bmovimiento` (`IDMOV`, `IDDETVENTA`, `CODPRD`, `GLOSAPRD`, `CANTPRD`, `UNITPRD`, `TOTUNIT`) VALUES (?,null,?,?,?,?,?);";	
		$IDDETMOV = $this->conexion->Insert($sql, $arrData);	// Save Bmovimiento		

		$sql ="SELECT `CODPRD`, $IDDETMOV as `IDDETMOV` , `CANTPRD`, `UNITPRD`,1  from mproducto Where CODPRD = {$this->CODPRD}"; ///
		$arrINV = $this->conexion->Select($sql)[0];	

		$oldCant = $arrINV['CANTPRD'];
		$oldUnit = $arrINV['UNITPRD'];
		$newCant	= $oldCant+$this->CANTPRD;
		$newTotal	= $this->TOTUNIT+($oldCant*$oldUnit);
		$newUnit	= $newTotal / $newCant;

		$arrData=array($this->CODPRD,$IDDETMOV,$oldCant,$oldUnit,1);
		$sql = "INSERT INTO `ponderacion` (`IDPOND`, `CODPRD`, `IDDETMOV`, `CANTPRD`, `UNITPRD`, `PONDVIGENTE`) VALUES (null,?,?,?,?,?);";		
		$idPon = $this->conexion->Insert($sql, $arrData);	// Save Bmovimiento 

		$arrData= array($newCant, $newUnit,$newTotal, $this->CODPRD);
		$sql = "UPDATE `mproducto` set `CANTPRD` = ? , `UNITPRD` = ? , `TOTUNIT` = ?  where `CODPRD` = ? ;";
		$INVUpdated = $this->conexion->Insert($sql, $arrData);
		
		$arrData= array($this->CODPRD, $IDDETMOV);
		$sql = "UPDATE `ponderacion` set `PONDVIGENTE` = 0 where `CODPRD` = ? and `PONDVIGENTE` = 1 and `IDDETMOV`<> ?;";
		$PonUpdated = $this->conexion->Insert($sql, $arrData);

		return array(
				'movimiento'=>$IDDETMOV,
				'ponderacion'=>$idPon,
				'inv'=>$INVUpdated,
				'upon'=>$PonUpdated	); 
	}

	public function Salida($post){ 
		$x= $this->SetVarsArr($post);
		
		$arrData = $this->GetVarsArr();		
		$sql = "INSERT INTO `bmovimiento` (`IDMOV`, `IDDETVENTA`, `CODPRD`, `GLOSAPRD`, `CANTPRD`, `UNITPRD`, `TOTUNIT`) VALUES (?,".(($this->IDDETVENTA==0)?"NULL":"?").",?,?,?,?,?);";
//		echo $sql."<br>";print_r($arrData);
		$id = $this->conexion->Insert($sql, $arrData);
		
		$sql = "UPDATE `mproducto` SET `CANTPRD` =`CANTPRD`- ? WHERE `CODPRD` = ?;";
		$arrData=array($this->CANTPRD,$this->CODPRD);
//		echo $sql."<br>";print_r($arrData);
		$UD1 = $this->conexion->Insert($sql, $arrData);
		
		$sql = "UPDATE `mproducto` SET `TOTUNIT` = `CANTPRD`*`UNITPRD` WHERE `CODPRD` = ?;";
		$arrData=array($this->CODPRD);
//		echo $sql."<br>";print_r($arrData);
		$UD2 = $this->conexion->Insert($sql, $arrData);
		return array($id,$UD1,$UD2); 
	}

	
	public function Venta ($IDVENTA,$CODPRD,$GLOSAPRD,$CODLISTPRE,$CANTPRD,$PRECVENT){
		$arrData = array($IDVENTA,$CODPRD,$GLOSAPRD,$CODLISTPRE,$CANTPRD,$PRECVENT);	
		$sql = "INSERT INTO `bventas` (`IDVENTA`, `DETVENTA`, `CODPRD`, `GLOSAPRD`, `CODLISTPRE`, `CANTPRD`, `PRECVENT`) VALUES (?, NULL,?,?,?,?,?);";
		return $this->conexion->Insert($sql,$arrData);
	}

}