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
	public function Nuevo($post){ 				//	Insert H Movimiento
		//$this->FECHA = $post['FECHA'];
		$this->DESCGLOS = $post['DESCGLOS'];
		//$this->ABROPE = $post['ABROPE'];
		$this->OPNULO = $post['OPNULO'];
		$this->IDVENTA = $post['IDVENTA'];
		$this->CODOPE = $post['CODOPE'];
		$this->TIPMOV = $post['TIPMOV'];
		$this->IDSUC = $post['IDSUC'];
		//"('1', '2022-09-16', 'PRUEBA', '1', NULL, '1', '1', '1');"
		$sql;	$arrData;		///Instanciar variables a nivel metodo
		if($this->IDVENTA==0){	// Id
			$sql = "INSERT INTO `hmovimiento` (`FECHA`, `DESCGLOS`, `OPNULO`, `IDVENTA`, `CODOPE`, `TIPMOV`, `IDSUC`) VALUES (now(),?,?,null,?,?,?)";
			$arrData = array( 
				$this->DESCGLOS,
				$this->OPNULO,
				//$this->IDVENTA,	//null
				$this->CODOPE,
				$this->TIPMOV,
				$this->IDSUC
			);
		}else{
			$sql = "INSERT INTO `hmovimiento` (`FECHA`, `DESCGLOS`, `OPNULO`, `IDVENTA`, `CODOPE`, `TIPMOV`, `IDSUC`) VALUES (now(),?,?,?,?,?,?)";
			$arrData = array( 
				$this->DESCGLOS,
				$this->OPNULO,
				$this->IDVENTA,
				$this->CODOPE,
				$this->TIPMOV,
				$this->IDSUC
			);
		}
		//echo $sql."<br>";	print_r($arrData);
		//return 2;
		return $this->conexion->Insert($sql, $arrData);
	}

	public function Ingreso($glosa,$tMovimiento){			//Ingreso	--	OK
		$post = array();
		$post['DESCGLOS']= $glosa;
		$post['OPNULO']= 1;
		$post['IDVENTA']= 0;
		$post['CODOPE']= $tMovimiento;
		$post['TIPMOV']= 1;
		$post['IDSUC']= 1;
		return $this->Nuevo($post);
	}

	public function Salida($glosa,$tMovimiento,$venta){		//	Salida	--	OK
		$post = array();
		$post['DESCGLOS']= $glosa;
		$post['OPNULO']= 1; 
		$post['IDVENTA']= $venta;
		$post['CODOPE']= $tMovimiento;
		$post['TIPMOV']= 2;
		$post['IDSUC']= 1;
		return $this->Nuevo($post);
	}



	public function Actualizar($post){	//POR pROCESAR
		$this->FECHA = $post['FECHA'];
		$this->DESCGLOS = $post['DESCGLOS'];
		$this->ABROPE = $post['ABROPE'];
		$this->OPNULO = $post['OPNULO'];
		$this->IDVENTA = $post['IDVENTA'];
		$this->CODOPE = $post['CODOPE'];
		$this->TIPMOV = $post['TIPMOV'];
		$this->IDSUC = $post['IDSUC'];

		$sql = "Insert Into tmarca(`DESCMARC`)Values(?)";        ///Modificar1
		$arrData = array( 
			$this->FECHA,
			$this->DESCGLOS,
			$this->ABROPE,
			$this->OPNULO,
			$this->IDVENTA,
			$this->CODOPE,
			$this->TIPMOV,
			$this->IDSUC

		);
		return $this->conexion->Insert($sql, $arrData);
	}

	public function doListTmov($tmov,$id){    
		$sql = "SELECT `CODOPE`,`DESCOPE` FROM `ttipoope` WHERE `TIPMOV`=$tmov;"; ///Modificar5
		$DataSet = $this->conexion->Select($sql);
		echo '<select class="form-control" name="ttipoope" id="ttipoope" >'; //readonly
		echo ($id==0)?'<option value="0">Select...</option>':'';        
		foreach ($DataSet as $data){
			$selected = ($data['CODUNID']==$id)?'Selected':'';
			echo "<option value='{$data['CODOPE']}' $selected >{$data['DESCOPE']}</option>";
		}            
		echo '</select>';
	}
   
	public function Venta ($DESCCLIENT,$CODLISTPRE){
		$arrData = array($CODLISTPRE,$DESCCLIENT);	
		$sql = "INSERT INTO `hventas` (`IDVENTA`, `CODLISTPRE`, `OPNULO`, `DESCCLIENT`, `FECHAVENT`) VALUES (NULL, ?, 1, ?, current_timestamp());";
		return $this->conexion->Insert($sql,$arrData);
	}




}