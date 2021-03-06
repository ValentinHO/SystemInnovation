<?php

include_once("conexion.class.php");
class Markers
{

    private $conexion;
    private $conex;
    private $pstmt;
    private $result;
    private $consulta;
    private $serviciosM = array();
    private $datos = array();
    private $ids = array();
    private $star = array();
    private $calif = array();

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
            case 'reports':
                self::reportsAction();
                break;
            case 'tips':
            	self::tipsAction();
            	break;

			default:
				# code...
				break;
		}
	}

	private function reportsAction()
	{

        $idmecanico = $_POST['idmecanico'];
        $idservicio = $_POST['idservicio'];
        $estrellas = $_POST['estrellas'];

        $this->consulta = "select * from reports where si_m_id = ? and si_service = ?";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->bindParam(1,$idmecanico,PDO::PARAM_INT);
        $this->pstmt->bindParam(2,$idservicio,PDO::PARAM_INT);
        $this->pstmt->execute();

        foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
        {

             $this->datos = $row;
        }
        
        if (sizeof($this->datos)>0) 
        {
            if ($estrellas == 1) 
            {
                $this->consulta = "select si_one_star from reports where si_m_id = ? and si_service = ?";
                $this->consultas($idmecanico,$idservicio);

                $this->consulta = "update reports set si_one_star = ? where si_m_id = ? and si_service = ?";
                $this->queries($idmecanico,$idservicio,($this->star['si_one_star']+1));
            }
            elseif ($estrellas == 2) 
            {
                $this->consulta = "select si_two_star from reports where si_m_id = ? and si_service = ?";
                $this->consultas($idmecanico,$idservicio);

                $this->consulta = "update reports set si_two_star = ? where si_m_id = ? and si_service = ?";
                $this->queries($idmecanico,$idservicio,($this->star['si_two_star']+1));
            }
            elseif ($estrellas == 3) 
            {
                $this->consulta = "select si_three_star from reports where si_m_id = ? and si_service = ?";
                $this->consultas($idmecanico,$idservicio);

                $this->consulta = "update reports set si_three_star = ? where si_m_id = ? and si_service = ?";
                $this->queries($idmecanico,$idservicio,($this->star['si_three_star']+1));
            }
            elseif ($estrellas == 4) 
            {
                $this->consulta = "select si_four_star from reports where si_m_id = ? and si_service = ?";
                $this->consultas($idmecanico,$idservicio);

                $this->consulta = "update reports set si_four_star = ? where si_m_id = ? and si_service = ?";
                $this->queries($idmecanico,$idservicio,($this->star['si_four_star']+1));
            }
            elseif ($estrellas == 5) 
            {
                $this->consulta = "select si_five_star from reports where si_m_id = ? and si_service = ?";
                $this->consultas($idmecanico,$idservicio);

                $this->consulta = "update reports set si_five_star = ? where si_m_id = ? and si_service = ?";
                $this->queries($idmecanico,$idservicio,($this->star['si_five_star']+1));
            }
            
        }
        else
        {
            if ($estrellas == 1) 
            {
                $this->consulta = "insert into reports values(null,?,?,1,0,0,0,0,now())";
            }
            elseif ($estrellas == 2) 
            {
                $this->consulta = "insert into reports values(null,?,?,0,1,0,0,0,now())";
            }
            elseif ($estrellas == 3) 
            {
                $this->consulta = "insert into reports values(null,?,?,0,0,1,0,0,now())";
            }
            elseif ($estrellas == 4) 
            {
                $this->consulta = "insert into reports values(null,?,?,0,0,0,1,0,now())";
            }
            elseif ($estrellas == 5) 
            {
                $this->consulta = "insert into reports values(null,?,?,0,0,0,0,1,now())";
            }

            $this->querys($idmecanico,$idservicio);
        }

        $estrellas = null;
        $idservicio = null;
        $idmecanico = null;
        $this->pstmt = null;
        $this->result = null;
        $this->consulta = null;

	}















    private function consultas($dato1,$dato2)
    {
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->bindParam(1,$dato1,PDO::PARAM_INT);
        $this->pstmt->bindParam(2,$dato2,PDO::PARAM_INT);
        $this->pstmt->execute();

        foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
        {

             $this->star = $row;
        }

    }

    private function queries($dato1,$dato2,$dato3)
    {
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->bindParam(1,$dato3,PDO::PARAM_INT);
        $this->pstmt->bindParam(2,$dato1,PDO::PARAM_INT);
        $this->pstmt->bindParam(3,$dato2,PDO::PARAM_INT);
        $this->result = $this->pstmt->execute();

        if ($this->result) 
        {
            echo "ok";
        }
    }

    private function querys($dato1,$dato2)
    {
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->bindParam(1,$dato1,PDO::PARAM_INT);
        $this->pstmt->bindParam(2,$dato2,PDO::PARAM_INT);
        $this->result = $this->pstmt->execute();

        if ($this->result) 
        {
            echo "ok";
        }
    }















    private function indexAction()
    {
        //$this->datos = null;
        //$this->ids = null;

        $this->consulta = "select m.si_id as idmecanico, m.si_m_name as nombre, m.si_m_lastname as apellidos, m.si_phone as telefono, k.si_lat as latitud, k.si_lon as longitud, m.image as imagen 
        from mechanics as m inner join markers as k
        where m.si_id = k.si_m_id";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->execute();
        $i=0;
        

        foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
        {

             $this->datos[$i] = $row;
             $this->ids[$i] = $row['idmecanico'];
             $i++;
        }


        $counts = sizeof($this->ids);



        //CALIFICACION

        $this->consulta = "select SUM(si_one_star) as one,SUM(si_two_star) as two,SUM(si_three_star) as three,SUM(si_four_star) as four,SUM(si_five_star) as five from reports where si_m_id = ?";
        $y = 0;

        for($r = 0; $r < $counts; $r++)
        {
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1,$this->ids[$r],PDO::PARAM_INT);
            $this->result = $this->pstmt->execute();

            //echo var_dump($this->result);
            //exit();

            if($this->result == 1)
            {
                foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
                {
                    if ($row['one'] > $row['two'] && $row['one'] > $row['three'] && $row['one'] > $row['four'] && $row['one'] > $row['five']) 
                    {
                        $this->calif[$this->ids[$r]][$y]['idmec'] = $this->ids[$r];
                        $this->calif[$this->ids[$r]][$y]['calif'] = "1";    
                    }
                    elseif ($row['two'] > $row['one'] && $row['two'] > $row['three'] && $row['two'] > $row['four'] && $row['two'] > $row['five']) 
                    {
                        $this->calif[$this->ids[$r]][$y]['idmec'] = $this->ids[$r];
                        $this->calif[$this->ids[$r]][$y]['calif'] = "2";    
                    }
                    elseif ($row['three'] > $row['one'] && $row['three'] > $row['two'] && $row['three'] > $row['four'] && $row['three'] > $row['five']) 
                    {
                        $this->calif[$this->ids[$r]][$y]['idmec'] = $this->ids[$r];
                        $this->calif[$this->ids[$r]][$y]['calif'] = "3";    
                    }
                    elseif ($row['four'] > $row['one'] && $row['four'] > $row['three'] && $row['four'] > $row['two'] && $row['four'] > $row['five']) 
                    {
                        $this->calif[$this->ids[$r]][$y]['idmec'] = $this->ids[$r];
                        $this->calif[$this->ids[$r]][$y]['calif'] = "4";    
                    }
                    elseif ($row['five'] > $row['one'] && $row['five'] > $row['three'] && $row['five'] > $row['four'] && $row['five'] > $row['two']) 
                    {
                        $this->calif[$this->ids[$r]][$y]['idmec'] = $this->ids[$r];
                        $this->calif[$this->ids[$r]][$y]['calif'] = "5";    
                    }
                    else{
                        $this->calif[$this->ids[$r]][$y]['idmec'] = $this->ids[$r];
                        $this->calif[$this->ids[$r]][$y]['calif'] = "0";        
                    }
                    $y++;
                }
            }else{
                $this->calif[$this->ids[$r]][$y]['none'] = 0;
                $y++;
            }

            $y=0;
        }



//SERVICIOS

        $this->consulta = "select s.si_id as serviceid,s.si_service as servicio
        from services as s 
        inner join service_mechanic as c
        inner join mechanics as m
        where s.si_id = c.service_id AND c.mechanic_id = m.si_id AND c.mechanic_id = ?";

        
        $z=0;

        for($x = 0;$x < $counts; $x++)
        {

            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1,$this->ids[$x],PDO::PARAM_INT);
            $this->pstmt->execute();
        

            foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
            {
                //$this->serviciosM[$this->ids[$x]][$z] = $row['serviceid']."|".$row['servicio'];
                $this->serviciosM[$this->ids[$x]][$z] = $row;
                $z++;
            }
            
            $z=0;
        }
        $this->datos[sizeof($this->datos)] = $this->serviciosM;
        $this->datos[sizeof($this->datos)] = $this->calif;

        //var_dump($this->serviciosM);
        echo json_encode($this->datos);
        //echo json_encode($this->calif);
        //var_dump($this->datos);
        //var_dump($this->ids);
        //var_dump($this->serviciosM);
        //echo json_encode($this->serviciosM);


    }


    private function tipsAction()
    {
    	$this->consulta = "select si_folio as folio,si_t_name as nombre,si_description as pasos from tips";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->execute();
        $i=0;
        

        foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
        {

             $this->datos[$i] = $row;
             $i++;
        }

        echo json_encode($this->datos);	
    }


}

$object = new Markers();

?>