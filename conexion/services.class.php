<?php

include_once("conexion.class.php");
class Services
{

	private $conexion;
    private $conex;
    private $pstmt;
    private $result;
    private $consulta;

	public function __construct()
	{
		$this->conex = Conexion::getInstance();
        $this->conexion = $this->conex->getConexion();

		if (isset($_POST['option'])) 
		{
			self::eleccion($_POST['option']);
		}
	}

	private function eleccion($option)
	{
		switch ($option) 
		{
			case 'index':
				self::indexAction();
				break;

			case 'add':
				self::addAction();
				break;

			case 'edit':
				self::editAction();
				break;

			case 'update':
				self::updateAction();
				break;

			case 'delete':
				self::deleteAction();
				break;
			
			default:
				# code...
				break;
		}
	}

	private function indexAction()
	{

		$this->consulta = "select * from services";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->execute();

        $countProducts = $this->pstmt->rowCount();            

            $page_size = 5;

            if (isset($_REQUEST['numPag'])) {
                $page = $_REQUEST['numPag'];
                $init = ($page - 1) * $page_size;
            }else{
                $page = 1;
                $init = 0;
            }

            $total_paginas = ceil($countProducts / $page_size);

        $this->consulta = "select * from services limit ?, ?";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->bindParam(1, $init, PDO::PARAM_INT);
        $this->pstmt->bindParam(2, $page_size, PDO::PARAM_INT);
        $this->pstmt->execute();

		$this->result = "<div class='table-responsive'>
                    <table class='table table-hover table-striped table-bordered no-footer'>
                        <thead>
                            <tr>
                            	<th>Id</th>
                                <th>Nombre del Servicio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>";
        foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
        {
        	$this->result .= '<tr>
                                <td>'.$row['si_id'].'</td>
                                <td>'.$row['si_service'].'</td>
                                <td class="actions">
                                    <a href="#" class="btn btn-sm btn-warning" onclick="editTip('.$row['si_id'].')"><i class="glyphicon glyphicon-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger" onclick="deleteTip('.$row['si_id'].')"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>';
        }
                            
        $this->result .= '</tbody></table></div>';


        if($countProducts > $page_size)
        {
                $this->result .= '<div class="pagination">;
                        <ul>';
                
                if(($page - 1) > 0){
                    $this->result .= '<li><a href="#" onclick="paginaService('.($page-1).')"><b>Previous</b></a></li>';
                }

                for($i=1; $i <= $total_paginas; $i++){
                    if($page == $i){
                        $this->result .= '<li id="activo"><a href="#">'.$page.'</a></li>';
                    }else{
                        $this->result .= '<li><a href="#" onclick="paginaService('.$i.')">'.$i.'</a></li>';
                    }
                }

                if($page < $total_paginas){
                    $this->result .= '<li><a href="#" onclick="paginaService('.($page+1).')"><b>Next</b></a></li>';
                }
                $this->result .= '</ul>
                </div>';
        }

        echo $this->result;
	}






	private function addAction()
    {
        $name = htmlspecialchars($_POST['servicename']);

        try {

            $this->consulta = "insert into services values(null, ?)";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $name, PDO::PARAM_STR);
            $this->result = $this->pstmt->execute();

            if($this->result == 1){
                echo "ok";
            }else{
                echo $this->result;
            }
            
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }

    }






    private function editAction()
    {
        $id = htmlspecialchars($_POST['id']);
        $datos = array();

        try 
        {
            $this->consulta = "select * from services where si_id = ?";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $id, PDO::PARAM_INT);
            $this->pstmt->execute();

            foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
            {
                $datos = $row;
            }
            echo json_encode($datos);
        } 
        catch (PDOException $e) 
        {
            echo $e->getMessage();
        }
    }







    private function updateAction()
    {
        try {

            $name = htmlspecialchars($_POST['name']);
            $id = htmlspecialchars($_POST['id']);

            $this->consulta = "update services set si_service = ? where si_id = ? ";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $name, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $id, PDO::PARAM_STR);
            $this->result = $this->pstmt->execute();

            if($this->result == 1){
                echo "ok";
            }else{
                echo $this->result;
            }
            
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }






    private function deleteAction()
    {
         $id = htmlspecialchars($_POST['id']);

        try {

            $this->consulta = "delete from service_mechanic where service_id = ?";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $id, PDO::PARAM_STR);
            $this->pstmt->execute();

            $this->consulta = "delete from services where si_id = ?";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $id, PDO::PARAM_STR);
            $this->result = $this->pstmt->execute();

            if($this->result == 1){
                echo "ok";
            }else{
                echo $this->result;
            }
            
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }





}

$object = new Services();

?>