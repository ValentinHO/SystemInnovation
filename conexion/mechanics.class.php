<?php

include_once("conexion.class.php");
class Mecanicos
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

		if (isset($_REQUEST['option'])) 
		{
			self::eleccion($_REQUEST['option']);
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

            case 'services':
                self::servicesAction();
                break;

            case 'obtain':
                self::editSelectAction();
                break;

			default:
				# code...
				break;
		}
	}

	private function indexAction()
	{
        $this->consulta = "select * from mechanics";
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

        $this->consulta = "select * from mechanics limit ?, ?";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->bindParam(1, $init, PDO::PARAM_INT);
        $this->pstmt->bindParam(2, $page_size, PDO::PARAM_INT);
        $this->pstmt->execute();

		$this->result = "<div class='table-responsive'>
                    <table class='table table-hover table-striped table-bordered no-footer'>
                        <thead>
                            <tr>
                                <th>Nombre Mecánico</th>
                                <th>Apellido(s)</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>";

        foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
        {
            $this->result .= '<tr>
                                <td>'.$row['si_m_name'].'</td>
                                <td>'.$row['si_m_lastname'].'</td>
                                <td>'.$row['si_phone'].'</td>
                                <td class="actions">
                                    <a href="#" class="btn btn-sm btn-warning" onclick="editMec('.$row['si_id'].')"><i class="glyphicon glyphicon-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger" onclick="deleteMec('.$row['si_id'].')"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>';
        }
                            
        $this->result.="</tbody></table></div>";


        if($countProducts > $page_size)
        {
                $this->result .= '<div class="pagination">;
                        <ul>';
                
                if(($page - 1) > 0){
                    $this->result .= '<li><a href="#" onclick="paginaMechanic('.($page-1).')"><b>Previous</b></a></li>';
                }

                for($i=1; $i <= $total_paginas; $i++){
                    if($page == $i){
                        $this->result .= '<li id="activo"><a href="#">'.$page.'</a></li>';
                    }else{
                        $this->result .= '<li><a href="#" onclick="paginaMechanic('.$i.')">'.$i.'</a></li>';
                    }
                }

                if($page < $total_paginas){
                    $this->result .= '<li><a href="#" onclick="paginaMechanic('.($page+1).')"><b>Next</b></a></li>';
                }
                $this->result .= '</ul>
                </div>';
        }

        echo $this->result;
	}




    private function addAction()
    {
        $name = htmlspecialchars($_POST['mechanicname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $phone = htmlspecialchars($_POST['phone']);
        $lat = htmlspecialchars($_POST['lat']);
        $lon = htmlspecialchars($_POST['lon']);
        $service = $_POST['services'];

        try {

            $this->consulta = "insert into mechanics values(null, ?,?,?)";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $name, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $lastname, PDO::PARAM_STR);
            $this->pstmt->bindParam(3, $phone, PDO::PARAM_STR);
            $this->pstmt->execute();

            $this->consulta = "select max(si_id) as last from mechanics";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->execute();

            foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
            {
                $ids = $row['last'];
            }

            $this->consulta = "insert into markers values(null, ?,?,?)";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $ids, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $lat, PDO::PARAM_STR);
            $this->pstmt->bindParam(3, $lon, PDO::PARAM_STR);
            $this->pstmt->execute();

            for($i=0;$i<count($service);$i++)
            {
                $this->consulta = "insert into service_mechanic values(null, ?,?)";
                $this->pstmt = $this->conexion->prepare($this->consulta);
                $this->pstmt->bindParam(1, $service[$i], PDO::PARAM_STR);
                $this->pstmt->bindParam(2, $ids, PDO::PARAM_STR);
                $this->result = $this->pstmt->execute();
            }



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
        $id = htmlspecialchars($_REQUEST['id']);
        $datos = array();

        try 
        {
            $this->consulta = "select * from mechanics 
            inner join markers 
            where mechanics.si_id = markers.si_m_id and mechanics.si_id = ?";

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

    private function editSelectAction()
    {
        $id = htmlspecialchars($_REQUEST['id']);
        $datos = array();

        try 
        {
            $this->consulta = "select services.si_id from services
            inner join service_mechanic
            inner join mechanics  
            where mechanics.si_id = service_mechanic.mechanic_id
            and services.si_id = service_mechanic.service_id 
            and mechanics.si_id = ?";

            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $id, PDO::PARAM_INT);
            $this->pstmt->execute();
            $i=0;
            foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
            {
                $datos['si_id'.$i] = $row['si_id'];
                $i++;
            }

            $datos['total'] = count($datos);
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
            $lastname = htmlspecialchars($_POST['lastname']);
            $phone = htmlspecialchars($_POST['phone']);
            $id = htmlspecialchars($_POST['id']);
            $lat = htmlspecialchars($_POST['lat']);
            $lon = htmlspecialchars($_POST['lon']);
            $service = $_POST['services'];
            $check = $_POST['check'];
            $datass = array();

            $this->consulta = "update mechanics set si_m_name = ? , si_m_lastname = ? , si_phone = ?  where si_id = ? ";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $name, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $lastname, PDO::PARAM_STR);
            $this->pstmt->bindParam(3, $phone, PDO::PARAM_STR);
            $this->pstmt->bindParam(4, $id, PDO::PARAM_STR);
            $this->pstmt->execute();

            $this->consulta = "update markers set si_lat = ? , si_lon = ? where si_m_id = ?";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $lat, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $lon, PDO::PARAM_STR);
            $this->pstmt->bindParam(3, $id, PDO::PARAM_STR);
            $this->pstmt->execute();

            if($check == false || $check == "false") 
            {
                $this->result = "";
                $this->consulta = "delete from service_mechanic where mechanic_id = ?";
                $this->pstmt = $this->conexion->prepare($this->consulta);
                $this->pstmt->bindParam(1, $id, PDO::PARAM_STR);
                $this->result = $this->pstmt->execute();

                if($this->result == 1){
                    for($i=0;$i<count($service);$i++)
                    {
                        $this->consulta = "insert into service_mechanic values(null, ?,?)";
                        $this->pstmt = $this->conexion->prepare($this->consulta);
                        $this->pstmt->bindParam(1, $service[$i], PDO::PARAM_STR);
                        $this->pstmt->bindParam(2, $id, PDO::PARAM_STR);
                        $this->result = $this->pstmt->execute();
                    } 
                    $this->conexion = $this->conex->cerrar();
                    $this->pstmt = "";
                    $this->result = "";
                    echo "ok";
                }
                else
                {
                    echo "errors";
                }
            }
            elseif ($check == true || $check == "true") 
            {
                for($i=0;$i<count($service);$i++)
                {
                    $datass = array();
                    $this->consulta = "select * from service_mechanic where mechanic_id = ? and service_id = ?";
                    $this->pstmt = $this->conexion->prepare($this->consulta);
                    $this->pstmt->bindParam(1, $id, PDO::PARAM_STR);
                    $this->pstmt->bindParam(2, $service[$i], PDO::PARAM_STR);
                    $this->pstmt->execute();

                    foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
                    {
                        $datass = $row;
                    }

                    if(count($datass)==0)
                    {
                        $this->consulta = "insert into service_mechanic values(null, ?,?)";
                        $this->pstmt = $this->conexion->prepare($this->consulta);
                        $this->pstmt->bindParam(1, $service[$i], PDO::PARAM_STR);
                        $this->pstmt->bindParam(2, $id, PDO::PARAM_STR);
                        $this->result = $this->pstmt->execute();
                        //echo var_dump($datass);
                        
                        unset($datass);
                    }
                
                }

                $this->conexion = $this->conex->cerrar();
                $this->pstmt = "";
                $this->result = "";
                echo "ok";
            }
            else{
                echo "error";
            }


            /*if($this->result == 1){
                echo "ok";
            }else{
                echo $this->result;
            }*/
            
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
        finally
        {
           $this->conexion = $this->conex->cerrar();
           $this->pstmt = "";
           $this->result = "";
        }
    }


    private function deleteAction()
    {
         $id = htmlspecialchars($_POST['id']);

        try {

            $this->consulta = "delete from service_mechanic where mechanic_id = ?";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $id, PDO::PARAM_STR);
            $this->pstmt->execute();

            $this->consulta = "delete from markers where si_m_id = ?";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $id, PDO::PARAM_STR);
            $this->pstmt->execute();            

            $this->consulta = "delete from mechanics where si_id = ?";
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

    private function servicesAction()
    {
         try {

            $this->consulta = "select * from services";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->execute();            

            $this->result = '<label for="Sservicios">Selecciona los servicios para el mecánico</label>';
            $this->result .= '<select name="Sservicios" id="Sservicios" multiple class="form-control" size="10">';

            foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
            {
                $this->result .= '<option value="'.$row['si_id'].'">'.$row['si_service'].'</option>';
            }
            $this->result .= '</select>';

            echo $this->result;
            
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }






}

$object = new Mecanicos();

?>