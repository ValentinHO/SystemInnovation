<?php


include_once("conexion.class.php");

class Login
{

	private $username;
	private $password;
	private $iscorrect = false;
	private $u;
	private $p;

	private $conexion;
    private $conex;
    private $pstmt;
    private $result;
    private $consulta;




	public function __construct()
	{
		$this->conex = Conexion::getInstance();
        $this->conexion = $this->conex->getConexion();

		if(isset($_POST['username']) && strlen($_POST['username']))
		{
			if (isset($_POST['password']) && strlen($_POST['password'])) 
			{
				$this->username = htmlspecialchars($_POST['username']);
				$this->password = htmlspecialchars($_POST['password']);
				$this->iscorrect = true;
				self::checkLogin();
			}
			else
			{
				$this->p = "passwordempty";
				self::checkLogin();
			}			
		}
		else
		{
			$this->u = "userempty";
			self::checkLogin();
		}

		if(isset($_POST['logout']))
		{
			self::logout();
		}
	}





	private function checkLogin()
	{
		if($this->iscorrect == true)
		{
			try 
			{
				$this->consulta = "select * from users where si_username = ? and si_password = AES_ENCRYPT(?,'admin')";
        		$this->pstmt = $this->conexion->prepare($this->consulta);
        		$this->pstmt->bindParam(1, $this->username, PDO::PARAM_STR);
            	$this->pstmt->bindParam(2, $this->password, PDO::PARAM_STR);
        		$this->pstmt->execute();

        		foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
            	{
                	 
                	if($row['si_username'] == $this->username)
        			{
        				session_name("loginAdmin");
						session_start();
						$_SESSION['nombreUsuario'] = $row['si_firstname']." ".$row['si_lastname'];
						$_SESSION['iduser'] = $row['si_id'];
        				echo "ok";
        			}
        			else
        			{
        				echo "failed";
        			}
            	}
			} 
			catch (Exception $e) 
			{
				echo $e->getMessage();
			}
		}
		else
		{
			if (strlen($this->u) > 0) 
			{
				echo $this->u;
			}
			else if(strlen($this->p) > 0)
			{
				echo $this->p;
			}
		}
	}


	private function logout(){
		try {
			session_name("loginAdmin");
			session_start();
			if(isset($_SESSION['nombreUsuario'])){
				unset($_SESSION['nombreUsuario']);
				unset($_SESSION['iduser']);
				session_destroy();
				echo "ok";			
			}else{
				echo "No se puede cerrar sesion";
			}	
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		

	}




}

$object = new Login();

?>