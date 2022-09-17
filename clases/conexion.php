<?php
class conexion {

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    //private $db = "sial";
    private $db = "sial";
    
    private $conect;  // = mysqli_connect($servidor,$usuario,$clave,$database);
    private $idInsert;

    public function __construct(){
            $connectionString = "mysql:hos=". $this->host .";dbname=". $this->db .";charset=utf8";
            try{
                $this->conect = new PDO($connectionString,$this->user,$this->pass);
                $this->conect->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "<b>-- Online --</b>";
            }
        catch(Exception $e){
            $this->conect = 'Error de conexion';
            echo  "ERROR: ".$e->getMessage();
        }
    }

    public function connect(){
        return $this->conect;
    }
    public function Insert(string $sql,$arrData){
        $insert = $this->conect->prepare($sql);
        $resInsert = $insert->execute($arrData);
        $this->idInsert = $this->conect->lastInsertId();        
        return $this->idInsert;
    }
    public function Update(string $sql,$arrData){
        $update = $this->conect->prepare($sql);
        $resUpdate = $update->execute($arrData);
        if(!$resUpdate)
            {return $resUpdate->errorInfo();}
        else
            {return $resUpdate; }
    }
    
    public function Select(string $sql){
        $execute = $this->conect->query($sql);
        $request = $execute->fetchall(PDO::FETCH_ASSOC);
        return $request;
    }  
    public function wea($tabla){        
        $lista_fk = $this->conect->cubrid_schema(PDO::CUBRID_SCH_IMPORTED_KEYS, $tabla);
        return $lista_fk;
    }
    
    



}

?>