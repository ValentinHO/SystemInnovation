<?php
require("variablesDB.php");
class Conexion
{
	private $conexion;
	private static $db;
	private $stmt;

//***************************************************************************************
	private function __construct(){
		try{
			$this->conexion = new PDO("mysql:host=".HOST.";dbname=".DB,USERDB,PASSWORDDB);
			$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->query("SET NAMES 'utf8';");
			$this->execute();
		} catch(PDOException $e){
        	echo $e->getMessage();
        }
	}
	public static function getInstance(){
    	if (  !self::$db instanceof self){self::$db = new self;}
      	return self::$db;
   	}
   	public function cerrar(){$this->conexion=null;}
   	public function getConexion(){return $this->conexion;}

   	private function query($query) {
		$this->stmt = $this->conexion->prepare($query);
		return $this;
	}

	private function execute() {
		return $this->stmt->execute();
	}
//**********************************************************************************************
//***************************************************************************************************** 	
}
?>