<?php require_once 'datosconexion.php';
  class basedatos{
    private static $bd=null;
    private static $conn;

    final private function __construct(){
      try{
        self::obtenerConexion();
      }catch(PDOException $e){}
    }

    public static function obtenerInstancia(){
      if(self::$bd==null){
        self::$bd=new self();
      }
      return self::$bd;
    }

    public static function obtenerConexion(){
      if(self::$conn==null){
        self::$conn=new PDO('mysql:dbname='.DATABASE.';host='.HOSTNAME.';',USERNAME,PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      return self::$conn;
    }

    final protected function __clone(){}
    function _destructor(){
      self::$conn=null;
    }

  }
 ?>
