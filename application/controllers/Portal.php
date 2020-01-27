<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prueba extends CI_Controller {
    public function __construct() {
        parent::__construct();
                
        $this->loadLibraries();   
             
       
    }
    public function loadLibraries(){
        $this->load->library('Tramites');
        

    }
	public function index(){
            //datos a enviar
            //url contra la que atacamos
            //datos a enviar
        $bread[] = array("Portal",base_url('Portal'),"");
        $bread[] = array("Trámites","","active");
        $data['bread'] = $this->agregar_elemento($bread);
        $data['header']=$this->_header();
        $data['footer']=$this->_footer();
        $data['TotalTramitesLinea'] = $this->tramites->getTotalTramitesLinea();
        $data['TotalTramitesPresenciales'] = $this->tramites->getTotalTramitesPresenciales();
        //$data['TotalTramitesPresenciales'] = $this->agregar_elemento($bread);
        $this->output->cache(5);
        $categoria=$this->tramites->categoriasLinea();
        $dependencia=$this->tramites->getDependencias();
        $data['CategoriaLinea']=$categoria;
        $data['DependenciaLinea']=$dependencia;
        $this->load->view('portal',$data);
        
        // $IdCategoria = $categoria[0];
        // $this->getCategoria($IdCategoria);
        }
    private function _header()
    {
        try {
            $data = array("a" => "a");
            //url contra la que atacamos
            $ch = curl_init("http://www.openapis.col.gob.mx/API_PU/index.php/Portalunico/encabezado");
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            //obtenemos la respuesta
            $response = curl_exec($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            $array = json_decode($response, TRUE);        
            curl_close($ch);
            
        }catch(Exception $e) {
            echo $e->getMessage();
                die();
        }
        return $rest=base64_decode($array['encabezado']); 
    }
    private function _footer()
    {
        try {
            $data = array("a" => "a");
            //url contra la que atacamos
            $ch = curl_init("http://www.openapis.col.gob.mx/API_PU/index.php/Portalunico/footer");
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            //obtenemos la respuesta
            $response = curl_exec($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            // Se cierra el recurso CURL y se liberan los recursos del sistema        
            $array = json_decode($response, TRUE);    
            //print_r($array);    
            curl_close($ch);
            
        }catch(Exception $e) {
            echo $e->getMessage();
                die();
        }
        return $rest=base64_decode($array['footer']);
    }
    public function agregar_elemento($parametros = array())
    {
        if (isset($parametros)){
            $imgSrc =  "http://www.col.gob.mx/assets/img/escudo_breadcrum.png";
            $out ="";
            $out .= "<li class='breadcrumb-item'><a href='".site_url()."' title='".GOBIERNO_ESTADO_COLIMA."'>";
            $out .= "<img class='bread-pbc' src='".$imgSrc."' alt='Logo de Gobierno del estado de Colima'>";
            $out .= COL_GOB_BREADCRUM."</a></li>";
            foreach ($parametros as $key => $value){
            $out .= "<li class='breditem-pt2 breadcrumb-item ".$value[2]."'><a href='".$value[1]."' title=''>".$value[0]."</a></li>";
            }
        return $this->salida($out);
        }
        else{
            return array("msg"=>"Breadcrumb sin parametros");
        }
    }
    function salida($elementos){
        $output = "<ol class='breadcrumb pull-right'>";
		$output .= $elementos;
		$output .= "</ol>";
		return $output;
    }
    //Tip de mejora, en vez de llamar funcion por funcioon, crear una funcion que reciba como parametros el tipo de
    //servicio que necitas y ese parametro procesarlo con un Switch.
    public function getTramitesLineaId()
        {
            $id_tramite = $this->input->get('id_tramite');    
            $Tramite=$this->tramites->getTramitesLineaId($id_tramite);
            $claveRETYS=$Tramite->cve_retis;
            $TramiteRetys = $this->tramites->getTramiteReTYS($claveRETYS); 
            if($claveRETYS!=""){
                if(trim($TramiteRetys[0]->servicio_enlinea_URL)==""){
                    $array=array($Tramite,$Tramite->url_tramite,$TramiteRetys[0]->FichaTecnica);
                }else{
                    $array=array($Tramite,$TramiteRetys[0]->servicio_enlinea_URL,$TramiteRetys[0]->FichaTecnica);
                }        
            }else{
                $array=array($Tramite);
            }
            echo json_encode($array);
        }
    public function getTramitesDependenciaPresencial()
    {   
        $Tramite=$this->tramites->getDependenciasRetys();
        echo json_encode($Tramite);
    }
    public function getTramitesCategoriaPresencial()
    {   
        $Tramite=$this->tramites->getCategoriasRetys();
        
        echo json_encode($Tramite);
    }
    public function getTramitesTipoUsuarioPresencial()
    {   
        $Tramite=$this->tramites->getUsuariosRetys();
        echo json_encode($Tramite);
    }
    public function getTramiteRetysId()
        {
            $array=array();
            $id_tramite = $this->input->get('id_tramite');    
            $Tramite=$this->tramites->getTramiteReTYS($id_tramite);
            $nombre=$Tramite[0]->Nombre;
            $fichaTecnica=$Tramite[0]->FichaTecnica;
            $aviso=$Tramite[0]->Aviso_privacidad;
            $descripcion=$Tramite[0]->Descripcion;
            if(trim($aviso)!=""){
                $array=array($nombre,$descripcion,$fichaTecnica,$aviso);           
            }else{
                $array=array($nombre,$descripcion,$fichaTecnica);
            }
            echo json_encode($array);
            
           
        }
        public function busquedaTramitesGeneralesRetys()
        {
            $param = $this->input->get('param');
            $response=$this->tramites->busquedaTramite($param);
            if (isset($response) && count($response) > 0) {
                foreach ($response as $key1 => $value) {
                 $tramite = $this->tramites->getTramiteReTYS($value->id_tramite);
                    foreach ($tramite as $key2 => $link) {
                        $result[] = array("id" =>$link->Id_Ads."/".$value->id_tramite, "nombre" =>$value->nombre);
                    }
                }
                echo json_encode($result);                
            }else{
                echo json_encode(array());
            } 
          
               
        }

        
}


/* End of file Master.php */
/* Location: ./application/controllers/Servicio/Master.php */
