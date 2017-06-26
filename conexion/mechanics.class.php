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
        //OBTIENE CONEXION A BD
        $this->conex = Conexion::getInstance();
        $this->conexion = $this->conex->getConexion();


        //SI ESTÁ DEFINIDA LA VARIABLE option ENTONCES EJECUTA EL METODO eleccion
		if (isset($_REQUEST['option'])) 
		{
			self::eleccion($_REQUEST['option']);
		}else{
            echo "errorcito";
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

    //FUNCION PARA MOSTRAR LA TABLA DE MECANICOS
	private function indexAction()
	{     
        /*PARTE PARA EL PAGINADOR*/
        $this->consulta = "select * from mechanics";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->execute();
        //CUENTA LOS REGISTROS DE mechanics
        $countProducts = $this->pstmt->rowCount();            

        //ESTABLECE NUMERO DE REGISTROS A MOSTRAR POR PAGINA
            $page_size = 5;

            if (isset($_REQUEST['numPag'])) {
                $page = $_REQUEST['numPag'];
                $init = ($page - 1) * $page_size;
            }else{
                $page = 1;
                $init = 0;
            }

            //OBTIENE EL TOTAL DE PAGINAS A MOSTRAR
            $total_paginas = ceil($countProducts / $page_size);

        //CONSULTA LOS MECANICOS DE ACUERDO A LOS REGISTROS A MOSTRAR POR PAGINA
        $this->consulta = "select * from mechanics limit ?, ?";
        $this->pstmt = $this->conexion->prepare($this->consulta);
        $this->pstmt->bindParam(1, $init, PDO::PARAM_INT);
        $this->pstmt->bindParam(2, $page_size, PDO::PARAM_INT);
        $this->pstmt->execute();

        //SE CREA LA TABLA
		$this->result = "<div class='table-responsive'>
                    <table class='table table-hover table-striped table-bordered no-footer'>
                        <thead>
                            <tr>
                                <th>Imagen</th>
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
                                <td class="text-center"><img src="img/profiles/'.$row['image'].'" width="60"></td>
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



        // PARTE DEL PAGINADOR
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

        //RETORNA LA TABLA CON PAGINADOR
        echo $this->result;
	}




    private function addAction()
    {
        $name = htmlspecialchars($_POST['mechanicname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $phone = htmlspecialchars($_POST['phone']);
        $lat = htmlspecialchars($_POST['lat']);
        $lon = htmlspecialchars($_POST['lon']);
        $service = $_POST['Sservicios'];

        //SI LA VARIABLE PROFILE ESTA DEFINIDA, QUIERE DECIR QUE NO SE SELECCIONO UNA IMAGEN EN EL FORMULARIO Y POR LO TANTO SE OBTIENE LO QUE TIENE PROFILE
        if (isset($_POST['profile'])) 
        {
            $file = $_POST['profile'];
        }
        else
        {
            //SI LA VARIABLE PROFILE NO ESTA DEFINIDA ENTONCES SE OBTIENE LA INFORMACION DE LA IMAGEN SELECCIONADA
            $file = $_FILES['images']['name'];         
            //comprobamos si el archivo ha subido
            if ($file && move_uploaded_file($_FILES['images']['tmp_name'],"../img/profiles/".$file))
            {
            }
            else
            { //SI NO SE HA SUBIDO LA IMAGEN, VERIFICAMOS EL ERROR Y LO RETORNAMOS PARA MOSTRARLO EN LA INTERFAZ DEL USUARIO
                $message = '';
                switch( $_FILES['images']['error'] ) {
                    case UPLOAD_ERR_OK:
                        $message = false;
                        break;
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $message .= ' - file too large (limit of '.get_max_upload().' bytes).';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $message .= ' - file upload was not completed.';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $message .= ' - zero-length file uploaded.';
                        break;
                    default:
                        $message .= ' - internal error #'.$_FILES['images']['error'];
                        break;
                }
                echo $message;
                exit();
            }
        }


        //REALIZA INSERCIONES
        try {

            $this->consulta = "insert into mechanics values(null, ?,?,?,?)";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $name, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $lastname, PDO::PARAM_STR);
            $this->pstmt->bindParam(3, $phone, PDO::PARAM_STR);
            $this->pstmt->bindParam(4, $file, PDO::PARAM_STR);
            $this->pstmt->execute();

            //SELECCIONA EL ID DEL ULTIMO MECANICO AGREGADO 
            $this->consulta = "select max(si_id) as last from mechanics";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->execute();

            //GUARDA EL ID EN UNA VARIABLE
            foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
            {
                $ids = $row['last'];
            }

            //UTILIZA EL ID PARA INSERTARLO EN LA TABLA MARKERS JUNTO CON LAS COORDENADAS
            $this->consulta = "insert into markers values(null, ?,?,?)";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $ids, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $lat, PDO::PARAM_STR);
            $this->pstmt->bindParam(3, $lon, PDO::PARAM_STR);
            $this->pstmt->execute();

            //INSERTA LOS SERVICIOS EN TABLA service_mechanic
            for($i=0;$i<count($service);$i++)
            {
                $this->consulta = "insert into service_mechanic values(null, ?,?)";
                $this->pstmt = $this->conexion->prepare($this->consulta);
                $this->pstmt->bindParam(1, $service[$i], PDO::PARAM_STR);
                $this->pstmt->bindParam(2, $ids, PDO::PARAM_STR);
                $this->result = $this->pstmt->execute();
            }


            //SI LAS INSERCIONES FUERON CORRECTAS, RETORNA ok
            if($this->result == 1){
                echo "ok";
            }else{//SI NO, RETORNA EL MENSAJE OBTENIDO
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


            //OBTIENE TODOS LOS DATOS DEL MECANICO Y LOS GUARDA EN UN ARRAY
            foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
            {
                $datos = $row;
            }

            //CODIFICA EL ARRAY EN FORMATO JSON Y LO RETORNA
            echo json_encode($datos);
        } 
        catch (PDOException $e) 
        {
            echo $e->getMessage();
        }
    }

    //FUNCION PARA OBTENER LOS SERVICIOS DEL MECANICO A EDITAR
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

            $name = htmlspecialchars($_POST['mechanicname']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $phone = htmlspecialchars($_POST['phone']);
            $id = htmlspecialchars($_POST['update-id']);
            $lat = htmlspecialchars($_POST['lat']);
            $lon = htmlspecialchars($_POST['lon']);
            $service = $_POST['Sservicios'];
            $check = $_POST['check'];
            $datass = array();

            //SI LA VARIABLE PROFILE ESTA DEFINIDA, QUIERE DECIR QUE NO SE SELECCIONO UNA IMAGEN EN EL FORMULARIO Y POR LO TANTO SE OBTIENE LO QUE TIENE PROFILE
            if (isset($_POST['profile'])) 
            {
                $file = $_POST['profile'];
            }
            else
            {
                //SI LA VARIABLE PROFILE NO ESTA DEFINIDA ENTONCES SE OBTIENE LA INFORMACION DE LA IMAGEN SELECCIONADA
                $file = $_FILES['images']['name'];         
                //comprobamos si el archivo ha subido
                if ($file && move_uploaded_file($_FILES['images']['tmp_name'],"../img/profiles/".$file))
                {
                }
                else
                { //SI NO SE HA SUBIDO LA IMAGEN, VERIFICAMOS EL ERROR Y LO RETORNAMOS PARA MOSTRARLO EN LA INTERFAZ DEL USUARIO
                    $message = '';
                    switch( $_FILES['images']['error'] ) {
                        case UPLOAD_ERR_OK:
                            $message = false;
                            break;
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            $message .= ' - file too large (limit of '.get_max_upload().' bytes).';
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $message .= ' - file upload was not completed.';
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $message .= ' - zero-length file uploaded.';
                            break;
                        default:
                            $message .= ' - internal error #'.$_FILES['images']['error'];
                            break;
                    }
                    echo $message;
                    exit();
                }
            }

            //ACTUALIZA mechanics
            $this->consulta = "update mechanics set si_m_name = ? , si_m_lastname = ? , si_phone = ? , image = ?  where si_id = ? ";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $name, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $lastname, PDO::PARAM_STR);
            $this->pstmt->bindParam(3, $phone, PDO::PARAM_STR);
            $this->pstmt->bindParam(4, $file, PDO::PARAM_STR);
            $this->pstmt->bindParam(5, $id, PDO::PARAM_STR);
            $this->pstmt->execute();

            //ACTUALIZA markers
            $this->consulta = "update markers set si_lat = ? , si_lon = ? where si_m_id = ?";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->bindParam(1, $lat, PDO::PARAM_STR);
            $this->pstmt->bindParam(2, $lon, PDO::PARAM_STR);
            $this->pstmt->bindParam(3, $id, PDO::PARAM_STR);
            $this->pstmt->execute();

            //SI NO SE SELECCIONÓ EL CHECK BOX
            if($check == false || $check == "false") 
            {
                //BORRA TODOS LOS SERVICIOS LIGADOS AL MECANICO QUE SE EDITA
                $this->result = "";
                $this->consulta = "delete from service_mechanic where mechanic_id = ?";
                $this->pstmt = $this->conexion->prepare($this->consulta);
                $this->pstmt->bindParam(1, $id, PDO::PARAM_STR);
                $this->result = $this->pstmt->execute();


                //INSERTA LOS NUEVOS SERVICIOS
                if($this->result == 1){
                    for($i=0;$i<count($service);$i++)
                    {
                        $this->consulta = "insert into service_mechanic values(null, ?,?)";
                        $this->pstmt = $this->conexion->prepare($this->consulta);
                        $this->pstmt->bindParam(1, $service[$i], PDO::PARAM_STR);
                        $this->pstmt->bindParam(2, $id, PDO::PARAM_STR);
                        $this->result = $this->pstmt->execute();
                    } 

                    //SI TODO SE EJECUTÓ CORRECTAMENTE, RETORNA ok
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
            //SI SE SELECCIONÓ EL CHECK BOX
            elseif ($check == true || $check == "true") 
            {   
                //CONSULTA PARA VERIFICAR QUE SERVICIOS YA ESTAN ASIGNADOS AL MECANICO Y EVITAR DUPLICADOS
                for($i=0;$i<count($service);$i++)
                {
                    $datass = array();
                    $this->consulta = "select * from service_mechanic where mechanic_id = ? and service_id = ?";
                    $this->pstmt = $this->conexion->prepare($this->consulta);
                    $this->pstmt->bindParam(1, $id, PDO::PARAM_STR);
                    $this->pstmt->bindParam(2, $service[$i], PDO::PARAM_STR);
                    $this->pstmt->execute();

                    //GUARDA LOS SERVICIOS ACTUALES DEL MECANICO
                    foreach ($this->pstmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
                    {
                        $datass = $row;
                    }

                    //SI EL SERVICIO SELECCIONADO POR EL USUARIO NO SE ENCUENTRA EN LA BASE, ENTONCES LO INSERTA
                    if(count($datass)==0)
                    {
                        $this->consulta = "insert into service_mechanic values(null, ?,?)";
                        $this->pstmt = $this->conexion->prepare($this->consulta);
                        $this->pstmt->bindParam(1, $service[$i], PDO::PARAM_STR);
                        $this->pstmt->bindParam(2, $id, PDO::PARAM_STR);
                        $this->result = $this->pstmt->execute();
                        //echo var_dump($datass);
                        //LIBERA DE MEMORIA EL ARRAY
                        unset($datass);
                    }
                
                }
                //CIERRA CONEXIONES Y RETORNA ok
                $this->conexion = $this->conex->cerrar();
                $this->pstmt = "";
                $this->result = "";
                echo "ok";
            }
            else{
                echo "error";
            }
            
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

    //FUNCION PARA BORRAR UN MECANICO
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

    //FUNCION PARA MOSTRAR TODOS LOS SERVICIOS DE LA BD EN UN SELECT MULTIPLE
    private function servicesAction()
    {
         try {

            $this->consulta = "select * from services";
            $this->pstmt = $this->conexion->prepare($this->consulta);
            $this->pstmt->execute();            

            //$this->result = '<label for="Sservicios">Selecciona los servicios para el mecánico</label>';
            $this->result = '<select name="Sservicios[]" id="Sservicios" multiple class="form-control" size="10">';

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