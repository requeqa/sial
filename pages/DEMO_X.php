<?php
require_once("autoload.php");
class Demo extends conexion{

    public int $ID;
    public string $nom="";
    public float $mon=0;
    public string $fecha="";
    private $operacion;
    
    //  --  Columnas  --
    private $conexion;
    public function __construct($get,$post){        
        $this->conexion = new conexion();
        print_r($get);
        print_r($post);

        if(!empty($get)){
            $this->id = (!empty($get["ID"]))? $get["ID"]:null;
        }elseif(!empty($post)){
            $this->ID =  (!empty($post["ID"]))?$post["ID"]:"";
            $this->nom = (!empty($post["nom"]))?$post["nom"]:"";
            $this->mon = (!empty($post["mon"]))?$post["mon"]:00;
            $this->fecha = (!empty($post["fecha"]))?$post["fecha"]:"";
        }
        if(!empty($get)){
            $operacion = "S1";
        }elseif(!empty($post)){
            $operacion = (!empty($post["ID"]))?"UP":"IN";
        }       
    }
    public function getAll($tabla){
        $sql="SELECT COLUMN_NAME, DATA_TYPE, COLUMN_COMMENT, COLUMN_KEY
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = 'sial' AND TABLE_NAME = '$tabla';" ;           
        return $this->conexion->Select($sql); 
    }
}
function doForm($DataSet){
    echo "<form action=\"DEMO.php?ID=2\" method=\"post\">";
    foreach ($DataSet as $data) {
        //  echo "$nombre : $valor\n";
        $titulo=$placeholder="";
        list($titulo,$placeholder)= explode("|",$data["COLUMN_COMMENT"].";");
        $tipo = (in_array($data["DATA_TYPE"], array("int","decimal")))?"number":"text";

        $nombre= $data["COLUMN_NAME"];
        echo $titulo.":<input type=\"{$tipo}\" name=\"{$nombre}\" value=\"\" placeholder=\"{$placeholder}\"><br>";
    }
    echo "<input type=\"submit\"></form>";
}
//function doData()





$mi_clase = new Demo($_GET,$_POST);
    //echo "<br>Hola soy {$mi_clase->nom}<br>";
/*$vars_clase = get_class_vars(get_class($mi_clase));
    echo "->donde esta mi clase";
print_r($vars_clase);//*/

doform($mi_clase->getAll('mproducto'));

echo "<pre>";
print_r ($mi_clase->getAll('mproducto'));
echo "</pre>";
/*


    Codigo: <input type="text" name="codigo"><br>
    Nombre: <input type="text" name="nombre"><br>
Descripcion: <input type="text" name="descripcion"><br>
<input type="submit">
echo "</form>";

//*/
?>




