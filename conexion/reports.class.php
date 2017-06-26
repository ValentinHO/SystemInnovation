<?php

include_once("conexion.class.php");
header("Content-Type: text/html;charset=utf-8");
class Reportes
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
			
			default:
				# code...
				break;
		}
	}

	private function indexAction()
	{
		$this->consulta = "select s.si_service as servicio,r.si_five_star,r.fec_last_solicited,m.si_m_name,m.si_m_lastname 
		from services as s 
		inner join reports as r 
		inner join mechanics as m 
		WHERE m.si_id = r.si_m_id 
        AND s.si_id = r.si_service 
        AND r.si_five_star > r.si_four_star
        AND r.si_five_star > r.si_three_star
        AND r.si_five_star > r.si_two_star
        AND r.si_five_star > r.si_one_star
		ORDER BY r.si_m_id";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->execute();


        $countProducts = $this->pstmt->rowCount();            

            $page_size = 3;

            if (isset($_REQUEST['numPag'])) {
                $page = $_REQUEST['numPag'];
                $init = ($page - 1) * $page_size;
            }else{
                $page = 1;
                $init = 0;
            }

            $total_paginas = ceil($countProducts / $page_size);

        $this->consulta = "select s.si_service as servicio,r.si_five_star,r.fec_last_solicited,m.si_m_name,m.si_m_lastname 
        from services as s 
        inner join reports as r 
        inner join mechanics as m 
        WHERE m.si_id = r.si_m_id 
        AND s.si_id = r.si_service 
        AND r.si_five_star > r.si_four_star
        AND r.si_five_star > r.si_three_star
        AND r.si_five_star > r.si_two_star
        AND r.si_five_star > r.si_one_star
        ORDER BY r.si_m_id limit ?, ?";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->bindParam(1, $init, PDO::PARAM_INT);
        $this->pstmt->bindParam(2, $page_size, PDO::PARAM_INT);
        $this->pstmt->execute();

        $contador = 0;
        
        $this->result ="";

        foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
        {

            $this->result .='<div class="col-sm-6"><div class="panel panel-info">
                <div class="panel-heading"><span class="glyphicon glyphicon-th"></span> '.$row['si_m_name']." ".$row['si_m_lastname'].'</div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <p class="card-text"><strong>Servicio:</strong> '.$row['servicio'].'</p>
                                <label><img src="img/fivestars.fw.png" width="100"/>
                                <strong>: '.$row['si_five_star'].' personas.</strong></label>
                            <p class="card-text"><strong>Últ. vez solicitado:</strong> '.$row['fec_last_solicited'].' hrs</p>
                        </div>
                    </div>
                </div>
            </div></div>';
            $contador++;
            if($contador == 2)
            {
                $this->result .= '<div class="clearfix visible-sm-block"></div>';
                $contador = 0;
            }

        }


        if($countProducts > $page_size)
        {
                $this->result .= '<div class="pagination">;
                        <ul>';
                
                if(($page - 1) > 0){
                    $this->result .= '<li><a href="#" onclick="paginaReports('.($page-1).')"><b>Previous</b></a></li>';
                }

                for($i=1; $i <= $total_paginas; $i++){
                    if($page == $i){
                        $this->result .= '<li id="activo"><a href="#">'.$page.'</a></li>';
                    }else{
                        $this->result .= '<li><a href="#" onclick="paginaReports('.$i.')">'.$i.'</a></li>';
                    }
                }

                if($page < $total_paginas){
                    $this->result .= '<li><a href="#" onclick="paginaReports('.($page+1).')"><b>Next</b></a></li>';
                }
                $this->result .= '</ul>
                </div>';
        }

        /*$this->consulta = "select s.si_service as servicio, r.si_four_star,r.fec_last_solicited,m.si_m_name,m.si_m_lastname 
		from services as s 
		inner join reports as r 
		inner join mechanics as m 
		WHERE m.si_id = r.si_m_id 
        AND s.si_id = r.si_service 
        AND r.si_four_star > r.si_five_star
        AND r.si_four_star > r.si_three_star
        AND r.si_four_star > r.si_two_star
        AND r.si_four_star > r.si_one_star
		ORDER BY r.si_m_id";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->execute();



        
       $this->result .="<div class='card-header-list col-md-12'>SERVICIOS CON 4 ESTRELLAS</div><br>";

        foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
        {

        	$this->result .= '<div class="card-list-best col-md-4">';
        	$this->result .= '<div class="card-header-list">'.$row['si_m_name']." ".$row['si_m_lastname'].'</div>';
			$this->result.= "<div class='card-block-list'>
                				<p class='card-text'><strong>Servicio:</strong> ".$row['servicio']."</p>
                				<label><img src='img/fourstars.fw.png' width='100'/>";     
        	$this->result .= ' <strong>: '.$row['si_four_star'].' personas.</strong></label>';

        	$this->result.="<p class='card-text'><strong>Últ. vez solicitado:</strong> ".$row['fec_last_solicited']." hrs"."</p>
        	</div></div>";
        }*/


        echo $this->result;
	}
}

$object = new Reportes();

?>