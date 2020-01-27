<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Master.php';

class Portal extends Master {

    private $redes;
    private $controlador = "Portal";
    private $aviso = true;
    public function __construct() {
        parent::__construct();
                
        $this->loadLibraries();   
             
        $this->redes['arr_redes'] = array('facebook' =>'gobiernocolima', 'twitter' => 'gobiernocolima' );
    }
   
    public function index()
    {           
        
        $data['header'] = $this->_get_header();
        //Indicamos que archivos cargamos en la libreria
        //[1]menu-fixed.js
        $propiedad = array('menu_fixed' => 1);
        $data['footer'] = $this->_get_footer($propiedad);
        
        $banner['banner']    = $this->_banner();
               
        $data['slider']      = $this->loadView('slider', $banner,TRUE);
        $datos['CSRF_Name']  = $this->security->get_csrf_token_name();        
        $datos['CSRF_Hash']  = $this->security->get_csrf_hash();               
        $data['buscador']    = $this->loadView('sec_buscador',$datos,TRUE);            

        $tramites['tramites'] = $this->tramites->get_tramites();
        $data['tramites'] = $this->loadView('sec_tramites', $tramites,TRUE);
        $data['gobierno'] = $this->loadView('sec_gobierno', "",TRUE);
        
        $data['noticias'] = $this->loadView('sec_noticias_portal',"",TRUE);
        
        $eventos['datos'] = $this->_get_eventos();
        // $eventos['redes_sociales'] = $this->loadView('sec_redes_sociales_link',$redes);
        $data['eventos'] = $this->loadView('sec_eventos', $eventos, TRUE);
        $gabinete['funcionarios'] = $this->_get_all_funcionarios();
        $data['gabinete'] = $this->loadView('sec_gabinete', $gabinete,TRUE);
        
        $destacado['contenido'] = $this->procesarDestacados();
        $data['destacada']      = $this->loadView('sec_destacados',$destacado,TRUE);

        if(!$this->aviso){
            $avisos['datos'] = $this->_get_avisos();
            $data['avisos']  = $this->load->view('sec_avisos', $avisos, TRUE);
        }

        $campanas['contenido'] = $this->procesarCampanas();
        $data['campanas']      = $this->loadView('sec_campanas',$campanas,TRUE);
        $data['atencionc'] = $this->loadView('sec_atencion_ciudadana','',TRUE);
    
        $album['youtube']     = $this->youtube;
        $album['controlador'] = $this->controlador;
       
        //Los videos se cargan automaticamente al momento de cargar el js
        $data['multimedia'] = $this->load->view('sec_multimedia', $album, TRUE);
        $this->loadView('layout_home',$data);
		
    }

    public function _banner()
    {
        $banner = $this->_banner_principal();
		$response = $this->agregar_contenido_response($banner);

		return $response;
    }

    public function procesarCampanas()
    {
        $response = $this->_get_campanas()->registros;
        $data = array();
        if (isset($response)) {
            foreach ($response as $key => $campana) {
                $dato = array('id_cont' => $campana->id_cont
                ,'titulo' => (strlen($campana->titulo)  > 50) ? substr(ucfirst($campana->titulo), 0,50).'...' : ucfirst($campana->titulo)
                ,'descripcion' => $campana->descripcion
                ,'archivos' => $this->getArchivos($campana->archivos)
                ,'ruta' => $campana->archivos->ruta);
                
                array_push($data, $dato);
            }
            
        }
        
        return $data; 
        
    }

    public function procesarDestacados()
    {
        $model  = $this->_get_destacados()->registros;
        if (isset($model)) {
            $data = array();
            foreach ($model as $key => $destacado) {
                $dato = array('id_cont' => $destacado->id_cont
                              ,'titulo' => (strlen($destacado->titulo)  > 50) ? substr(ucfirst($destacado->titulo), 0,50).'...' : ucfirst($destacado->titulo)
                              ,'descripcion' => $destacado->descripcion
                              ,'archivos' => $this->getArchivos($destacado->archivos)
                              ,'ruta' => $destacado->archivos->ruta);

                array_push($data, $dato);
            }           
            return $data; 
        }else{ return array(); }

    }

    public function getArchivos($arrArchivo)
    {
        if (isset($arrArchivo) || isset($arrArchivo->registros)) {
           foreach ($arrArchivo->registros as $key => $archivo) {
                $obj = new \stdClass;
                $obj->id_archivo = $archivo->id_archivo;
                $obj->id_contenido = $archivo->id_contenido;
                $obj->nom_archivo = $archivo->nom_archivo;
                if(substr($archivo->nom_archivo, -3) == 'jpg'){
                    $obj->id_file_encoded = base64_encode($archivo->id_archivo);
                    $obj->url_image = URLCOLIMAEDO.'imagenv2.php?x='.base64_encode($archivo->id_archivo).'&amp;y=23&amp;z=1';

                } 
               
                return $obj;
           }
        }
    }

    protected function _get_header($str_css='', $Metas='') 
    {
        $cve_dep = IniRead("general", "id_dep_colima_edo");
        $this->load->model('General_model');
        $data = $this->General_model->getDependenciaInfo($cve_dep);
        //$codigoSeguimiento = isset($data[0]['codigo_seguimiento']) ? $data[0]['codigo_seguimiento'] : '';
        //$str_css .= "<script type='text/javascript' src='//script.crazyegg.com/pages/scripts/0085/1528.js' async='async'></script>";
        //$str_css .= $codigoSeguimiento;

        return $this->_header($cve_dep, $str_css, $Metas);
    }

    public function saliendo()
    {
        $data['header'] = $this->_get_header(); 
        //Indicamos que archivos cargamos en la libreria
        //[1]menu-fixed.js
        $js = array('menu_fixed' => 0);
        $data['footer'] = $this->_get_footer($js);
        $data['contenido'] = $this->load->view('saliendo_sitio',"", TRUE);
        $this->load->view('layout_detalles',$data);
    }
    
    protected function _get_footer($propiedad = array(), $stringjs='') 
    {        
        return $this->_footer($propiedad, $stringjs);
    }

    public function detalle_gabinete($id = '') {
        if ($id != "") {

            $data['header'] = $this->_get_header();
            //Indicamos que archivos cargamos en la libreria
            //[1]menu-fixed.js
            $js = array('menu_fixed' => 0);
            $data['footer'] = $this->_get_footer($js);
            /*Breadcrumb*/    
            //Label //URL //Activo
            $bread[] = array("Portal",base_url('Portal'),"");
            //$bread[] = array("Icsic","www.colima.col","");
            $bread[] = array("Detalle gabinete","","active");
            $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
            $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
            $funcionario['funcionario'] = $this->_get_detalle_funcionario($id);
            $funcionario['gobernador'] = $this->_get_contenido('NjQzMg==');
           
            $data['contenido'] = $this->load->view('detalle_gabinete', $funcionario, TRUE);
            $this->load->view('layout_detalles', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function detalle_video_guardar(){
        
        $image = "https://i.ytimg.com/vi/".$this->input->post('id')."/maxresdefault.jpg";
        // Read image path, convert to base64 encoding
        $imageData = file_get_contents($image);
        // Format the image SRC:  data:{mime};base64,{data};
        $src = $imageData;
        
        $insert = array(
            'clave' => $this->input->post('id'),
            'imagen' => $src,
            'longitud' => strlen($src),
            'titulo' => base64_decode($this->input->post('titulo')),
            'contenido' => base64_decode($this->input->post('contenido'))
        );
        $this->db->replace('De_VideosPortalUnico',$insert);
        exit();
    }
    
    public function image_video(){
        $id = $this->uri->segment(3);
        $this->db->where(array('clave'=>$id));
        $query = $this->db->get('De_VideosPortalUnico');
        $listado = $query->row_array();
        $query->free_result();
        $response = array('status' => 'OK');
        print $this->output
            ->set_status_header(200)
            ->set_content_type('jpeg')
            ->set_output($listado['imagen'])
            ->_display();
        exit;
    }
	
    public function detalle_video($id = NULL)
	{
        if (is_null($id)) { redirect(base_url(),'refresh'); }else{
            
            $data['header'] = $this->_get_header();
            //$data['navbar']   = $this->load->view('navbar',"",TRUE);
            //Indicamos que archivos cargamos en la libreria
            //[1]menu-fixed.js
            $js = array('menu_fixed' => 0);
            $data['footer'] = $this->_get_footer($js);

            $listado['posicion']=0;
            $listado['redessociales']   = $this->load->view('sec_redes_sociales',$listado,TRUE);
            $data['atencionc']   = $this->load->view('sec_atencion_ciudadana',"",TRUE);
            /*Breadcrumb*/    
            //Label //URL //Activo
            $bread[] = array("Portal",base_url('Portal'),"");
            //$bread[] = array("Icsic","www.colima.col","");
            $bread[] = array("Video","","active");
            $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
            $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
			
	        $listado['controlador']= $this->controlador;
	        $listado['youtube']= ""; 
			
	        $listado['id_video']= $id; // tambien en detalle_video()
            //                utils::pre($listado);
            if (preg_match("/face/i", $_SERVER['HTTP_USER_AGENT'])) {
                
                $this->db->where(array('clave'=>$id));
                $query = $this->db->get('De_VideosPortalUnico');
                $listado['data'] = $query->row_array();
                $query->free_result();
                
                $html = $this->load->view('detalle_video_face',$listado,TRUE);
                print $html;
                exit();
            } else{
                $data['contenido'] = $this->load->view('detalle_video',$listado,TRUE);
            }
            
            //            $data['contenido'] = $this->load->view('detalle_video',$listado, TRUE);
            $this->load->view('layout_detalles', $data);
        }
    }

    public function busqueda($parametro)
    {
        if ($parametro != "") {
            $formato = "json";
            //Cambiar segun dependencia
            $cve_dep = IniRead("general", "id_dep_colima_edo");           

            //parametros para WS
            //[0]Dependencia
            //[1]Archivos
            $parametros = array($parametro);
            // $config_api = $this->consumepu->_set_config_api($cve_dep);
            $response = $this->consumepu->get_contenido(METHOD_BUSQUEDA, $parametros, $formato);            
            
            return $response;
        }
        //else{ return "<div class='alert alert-warning' role='alert'>Ingresar parámetro de búsqueda.</div>"; }

    }

    public function busquedaProcesada($object)
    {
        // $datos['lista'] = $object->resultado->registros;
        //$contador_contenidos = (isset($data['lista']) && is_object($data['lista']) && array_key_exists('resultado', (array)$data['lista']) && array_key_exists('registros', (array)$data['lista']->resultado) && count($data['lista']->resultado->registros)>0) ? count($data['lista']) : 0;
        // echo "<pre>";
        // print_r (is_object($object));
        // echo "</pre>";
        $obj = array();
        foreach ($object->resultado->registros as $key => $value) {
            array_push($obj, $value);
        }
        // echo "<pre>";
        // print_r ($obj);
        // echo "</pre>";
        return $obj;
    }

    public function create_url($dep = "" , $id_cat = "", $id_cont = "",$shortname ="")
    {
        $this->load->library('uri_busqueda');
        if ($dep != "" && $id_cat != "" && $id_cont != "" && $shortname != "") {            
            $url = $this->uri_busqueda->crear_url($dep, $id_cat,$id_cont,$shortname);
            redirect(base_url().$url);
        }else{            
            $url = $this->uri_busqueda->crear_url($dep, $id_cat,$id_cont,"portal");            
            redirect(base_url().$url);
            //redirect(base_url());
        }
    }

    public function detalle_tramite_get($param)
    {            
            //$parametro = $this->elimina_acentos($param);
            $response =  $this->tramites->busquedaTramite($param);            
            if (isset($response) && count($response) > 0) {
                foreach ($response as $key1 => $value) {
                 $tramite = $this->tramites->getTramiteReTYS($value->id_tramite);
                    foreach ($tramite as $key2 => $link) {
                        $result[] = array("id" =>$link->Id_Ads."/".$value->id_tramite, "nombre" =>$value->nombre);
                    }
                }
                return $result;                
            }else{
                 return array();
            }                
    }

    public function detalle_tramite_ABC($Letra)
    {            
            $param=array(
                'Letra'=>$Letra
            );            
            $response =  $this->tramites->getTramiteRetys_ABC($param);                        
            if (isset($response) && count($response) > 0) {
                foreach ($response as $key1 => $value) {
                 $tramite = $this->tramites->getTramiteReTYS($value->id_tramite);
                    foreach ($tramite as $key2 => $link) {
                        $result[] = array("id" =>$link->Id_Ads."/".$value->id_tramite, "nombre" =>$value->nombre);
                    }
                }
                return $result;                
            }else{
                 return array();
            }                
    }
    
    public function detalle_tramite2_get($param)
    {
            $response =  $this->tramites->busquedaTramite2($param);
            if (isset($response) && count($response) > 0) {
                foreach ($response as $key1 => $value) {
                    $tramite = $this->tramites->getTramiteReTYS($value->id_tramite);     
                    foreach ($tramite as $key2 => $link) {
                        $result[] = array("id" =>$link->Id_Ads."/".$value->id_tramite, "nombre" =>$value->nombre);
                    }
                }
                return $result;                
            }else{
                 return array();
            }             
    }
    public function limpiar_string($parametro)
    {              
        $parametro = trim($parametro);     
        $parametro= str_replace(" ","%20",$parametro);
        return $parametro;
    }
    public function detalle_busqueda() {
            $data['header'] = $this->_get_header();
            // Indicamos que archivos cargamos en la libreria 
            // [1]menu-fixed.js
            $js = array('menu_fixed' => 1);
            $data['footer'] = $this->_get_footer($js);
            
            $bread[] = array("Portal",base_url('Portal'),"");
            $bread[] = array("Listado de búsquedas","","active");
            $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
            $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
                                    
            //$data['parametrobusqueda'] = $param;
            $data['busque'] = $this->input->get_post("q");
            $data['CSRF_Name']=$this->security->get_csrf_token_name();
            $data['CSRF_Hash']=$this->security->get_csrf_hash();

            $data['contenido'] = $this->load->view('busqueda', $data, TRUE);
            $this->load->view('layout_detalles', $data);
    }
    public function detalle_secretarias($id = "",$lyr = "") 
    {
        if (!empty($id) && strlen($id) > 0) {
            $lyr = base64_decode($lyr);
            switch ($lyr) {
                case 'gobierno':
                    $datos['listado_gob'] = $this->_get_contenido($id);
                    $datos['css_circulo_gob'] = "color-red";
                    break;
                case 'organismos':
                    $datos['listado_gob'] = $this->_get_contenido($id);
                    $datos['css_circulo_organismos'] = "color-red";
                    break;
                case 'municipios':
                    $datos['listado_gob'] = $this->_get_contenido($id);
                    $datos['css_circulo_numicipios'] = "color-red";
                    break;

                case 'legislativo':
                    $datos['listado_legislativo'] = $this->_get_contenido($id);
                    $datos['css_circulo_legislativo'] = "color-red";

                    break;
                case 'judicial':
                    $datos['listado_judicial'] = $this->_get_contenido($id);
                    $datos['css_circulo_judicial'] = "color-red";
                    break;
                case 'federal':
                    $datos['listado_federal'] = $this->_get_contenido($id);
                    $datos['css_circulo_federal'] = "color-red";
                    break;
                
                default:
                    $datos['listado'] = $this->_get_contenido($id);
                    break;
            }

            
            //$datos['listado'] = $this->_get_contenido($id);
            // echo "<pre>";
            // print_r ($datos);
            // echo "</pre>";
        }

        $data['header'] = $this->_get_header();
        //Indicamos que archivos cargamos en la libreria 
        //[1]menu-fixed.js
        $js = array('menu_fixed' => 0);
        $data['footer'] = $this->_get_footer($js);


        
        $data['contenido'] = $this->load->view('detalle_secretariasv2', $datos, TRUE);
        /*Breadcrumb*/    
        //Label //URL //Activo
        $bread[] = array("Portal",site_url(''),"");
        $bread[] = array("Gobierno","","active");
        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
        $this->load->view('layout_detalles', $data);
    }

    public function detalle_tramites() {
        $data['header'] = $this->_get_header();

        //Indicamos que archivos cargamos en la libreria
        //[1]menu-fixed.js
        $js = array('menu_fixed' => 0);
        $data['footer'] = $this->_get_footer($js);

        $data['contenido'] = $this->load->view('detalle_tramites', "", TRUE);
        $this->load->view('layout_detalles', $data);
    }

    protected function _get_view($view_name, $params = array()) {
        return $this->load->view($view_name, $params, TRUE);
    }
        
    protected function _get_contenido($id_cont = NULL, $cve_dep) 
    {
        return $this->_getws_contenidos($id_cont, $cve_dep);
    }
    
    protected function _get_contenido_noticia($id_cont = NULL) {
        //$cve_dep:     Clave de la Dependencia
        //$seccion:     # de seccion, 3 para cursos
        //$f_inicial:   Fecha a partir de la cual tomara los cursos
        //$formato:     Formato del resultado del web service, si no se indica por default queda json
        //$cuantos:     Indica la cantidad de registros que retornara
        //$reg_ini:     Registro inicial

        if (is_null($id_cont)) {
            return array("msg" => "ID de contenido obligatorio");
        }

        $id_contenido = base64_decode($id_cont);
        //cambiar segun dependencia
        //$cve_dep = IniRead("general", "id_dep_colima_edo");
        $cve_dep = IniRead("general", "cve_portalnoticias"); //Mientras se suben noticias al portal 10200
        $formato = "json";
        // $config_api = $this->consumepu->_set_config_api($cve_dep);
        $parametros = array($cve_dep, $id_contenido);
        $contenido = $this->consumepu->get_contenido(METHOD_CONTENIDO, $parametros, $formato);
        
        return $contenido;
    }

    protected function _get_banner_principal() {
       return $this->_banner_principal();
    }

    public function bannerPrincipalAjax()
    {
        $banner['banner'] = $this->_get_banner_principal();
        echo $this->load->view('sec_slider',$banner,TRUE);
    }

    protected function _get_eventos() {
        $this->benchmark->mark('get_eventos_start');
        
        #cambiar segun dependencia
        $cve_dep = IniRead("general", "id_dep_eventos");
        $seccion = IniRead("general", "sec_eventos_p");
        $cuantos = IniRead("general", "num_eventos_p");
        $reg_ini = IniRead("general", "evento_inicial_p");
        $f_inicial = date('Y-m-d 00:00:00', strtotime("-1 days"));
        $formato = "json";
        $fechainicial     = date('Y-m-d');        
        $orderby       = "fecha_publicacion DESC";     
        //$cve_dep:     Clave de la Dependencia
        //$seccion:     # de seccion, 6 para banners
        //$f_inicial:   Fecha a partir de la cual tomara los banners
        //$formato:     Formato del resultado del web service, si no se indica por default queda json
        //$cuantos:     Indica la cantidad de registros que retornara
        //$reg_ini:     Registro inicial
        if (is_null($cve_dep) || is_null($seccion)) {
            return array();
        }
        $parametros = array($cve_dep, $seccion, $f_inicial, $cuantos, $reg_ini,$orderby,$fechainicial);

        // $config_api = $this->consumepu->_set_config_api($cve_dep);
        $response = $this->consumepu->get_contenido(METHOD_LISTADOS, $parametros, $formato);
        
        $this->benchmark->mark('get_eventos_end');
        
        return $response;
    }

    protected function _get_more_events() {
        $this->load->helper("fechas");
        #cambiar segun dependencia
        $cve_dep       = IniRead("general", "id_dep_eventos");
        $seccion       = IniRead("general", "sec_eventos_p");  
        $cuantos       = 12; //IniRead("general", "num_programa_listado");
        $reg_ini       = 0;//niRead("general",  "evento_inicial_p");
        $f_inicial     = date('Y-m-d 00:00:00',strtotime("90 days"));        
        $fechainicial     = date('Y-m-d');        
        $formato       = "json"; 
        $orderby       = "fecha_publicacion DESC";                  
        /***
        $cve_dep:     Clave de la Dependencia
        $seccion:     # de seccion, 6 para banners  CATEGORIA 
        $f_inicial:   Fecha a partir de la cual tomara los banners
        $formato:     Formato del resultado del web service, si no se indica por default queda json
        $cuantos:     Indica la cantidad de registros que retornara
        $reg_ini:     Registro inicial        
        ***/ 
        if (is_null($cve_dep) || is_null($seccion)) {
            return array();
        }
        $parametros = array($cve_dep, $seccion, $f_inicial, $cuantos, $reg_ini, $orderby,$fechainicial);
        
        // $config_api = $this->consumepu->_set_config_api('30106');
        $response = $this->consumepu->get_contenido(METHOD_LISTADOS, $parametros, $formato);
        foreach ($response->registros as $key => $value) {
            $value->id_cont_b64 = base64_encode($value->id_cont);
            $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
            $value->str_mes_publicacion = strtoupper(get_str_month_short($value->fecha_publicacion));
        }

        return $response;
    }

    protected function _get_noticias_col_edo() {
        $noticia['noticia'] = array();
        //Obtenemos noticias y limpiamos la informacion
        $obtenernoticias = $this->noticias_colima_edo->get_noticias();
        foreach ($obtenernoticias as $valor) {
            array_push($noticia['noticia'], $this->noticias_colima_edo->limpiar_contenido_noticias($valor));
        }
        $noticia['nextpage'] = isset($obtenernoticias['nextPageToken']) ? $obtenernoticias['nextPageToken'] : "";
        return $noticia;
    }
    
    function _get_noticias_col_edo_paginacion($key) {
        $noticia['noticia'] = array();
        //Obtenemos noticias y limpiamos la informacion
        $obtenernoticias = $this->noticias_colima_edo->get_noticias_paginacion($key);
        foreach ($obtenernoticias as $valor) {
            array_push($noticia['noticia'], $this->noticias_colima_edo->limpiar_contenido_noticias($valor));
        }
        $noticia['nextpage'] = isset($obtenernoticias['nextPageToken']) ? $obtenernoticias['nextPageToken'] : "";
        return $noticia;
    }


    public function detalle_noticia($id = "") {
        if ($id != "") {
            $contenido = (array)$this->_get_contenido_noticia($id);
            
            $Image=URLCOLIMAEDO.'imagenv2.php?x='.base64_encode($contenido['archivos']->registros[0]->id_archivo)."&y=1&z=6";
            $Metas='
            <Link rel = "canonical" href = "'.site_url( $this->uri->uri_string()).'"/>
            <meta property="og:url"     content="'.site_url( $this->uri->uri_string()).'" />
            <meta property="og:type"    content="article" />
            <meta property="og:title"   content="'.utf8_encode($contenido['cuerpo_cont'][0]->titulo).'" />
            <meta name="keywords"       content="'.utf8_encode($contenido['cuerpo_cont'][0]->palabras_clave).'" />
            <meta name="description"    content="'.utf8_encode($contenido['cuerpo_cont'][0]->titulo).'" />
            <meta name="title"          content="'.utf8_encode($contenido['cuerpo_cont'][0]->titulo).'" />
            <meta name="author"         content="Gobierno del Estado de Colima" />
            ';                                    
            
            $this->load->helper("fechas");
            //$response = $this->noticias_colima_edo->get_noticia($id);
            $data['header'] = $this->_get_header('', $Metas);

            $js = array('menu_fixed' => 0);

            $data['footer'] = $this->_get_footer($js, $dataJS='');                                   

            foreach ($contenido->cuerpo_cont as $key => $contenido) {
                $contenido->id_cont_b64 = base64_encode($contenido->id_cont);
                $contenido->dia_publicacion = strtoupper(get_day($contenido->fecha_publicacion));
                $contenido->str_mes_publicacion = get_str_month($contenido->fecha_publicacion);  
            } 

            $noticia['noticia'] = $contenido;
            $noticia['otras_noticias'] = (array)$this->_get_noticias_portal()->registros;
            // $noticia['noticias_relacionadas'] = (array)$this->_get_noticias_relacionadas($metadastos,$id);
            $noticia['redessociales']   = $this->load->view('sec_redes_sociales_link',$this->redes,TRUE);

            if (preg_match("/face/i", $_SERVER['HTTP_USER_AGENT'])) {
                $html = $this->load->view('detalle_noticias_portal_face', $noticia, TRUE);
                print $html;
                exit();
            } else{
                $data['contenido'] = $this->load->view('detalle_noticias_portal',$noticia,TRUE);
            }

            $banner['banner'] = $this->_get_banner_principal();
            /*Breadcrumb*/    
            //Label //URL //Activo
            $bread[] = array("Portal",base_url('Portal'),"");
            $bread[] = array("Listado noticias","","active");
            $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
            $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
            $data['atencionc'] = $this->load->view('sec_atencion_ciudadana', "", TRUE);
            $this->load->view('layout_detalles', $data);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function denuncia()
    {
        $this->load->model('General_model');
        $data['header'] = $this->_get_header('');
        $data['footer'] = $this->_get_footer("","");
        
        $data['slider']      = $this->loadView('sliderDenuncia', "",TRUE);
        $catalogo['catalogos'] = $this->General_model->getConsejeros();
        $data['contenido'] = $this->load->view('denuncia', $catalogo, TRUE);
        // //Label //URL //Activo
        $bread[] = array("Portal", base_url('Portal'), "");
        $bread[] = array("Denuncia", "", "active");
        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);

        $this->load->view("layout_detalles",$data);   
    }


    public function listado_noticias()
    {               
        $this->load->helper("fechas");
        $data['header'] = $this->_get_header();   
        $this->load->helper("fechas");
        $js = array('menu_fixed' => 0);
        $data['footer'] = $this->_get_footer($js);
        $banner['banner'] = $this->_get_banner_principal();
        
        $contenido = $this->_get_noticias_portal();
        foreach ($contenido as $key => $value) {
            $value->id_cont_b64 = base64_encode($value->id_cont);
            $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
            $value->str_mes_publicacion = strtoupper(get_str_month_short($value->fecha_publicacion));

        }
        $noticia['noticia'] = (array)$contenido->registros;
        $data['contenido'] = $this->load->view('listado_noticias_portal',$noticia,TRUE);
        
        /*$noticia = $this->_get_noticias_col_edo();
        $data['contenido'] = $this->load->view('listado_noticias_colimaedo',$noticia,TRUE);*/
       
        /*Breadcrumb*/
        $this->load->library('Breadcrumb');
        //Label //URL //Activo
        $bread[] = array("Portal",base_url('Portal'),"");
        $bread[] = array("Listado noticias","","active");
        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
        $data['atencionc'] = $this->load->view('sec_atencion_ciudadana', "", TRUE);
        $this->load->view('layout_detalles',$data);
    }
    
    public function listado_noticias_ajax($count)
    {   
        $contenido = $this->_get_noticias_portal_paginacion($count);
        $noticia['noticia'] = (array)$contenido->registros;
        echo $this->load->view('ajax_listado_noticias',$noticia,TRUE);
        exit();
      
    }
   
    public function get_noticiaportal_ajax()
    {   
        // $noticia['noticias'] = $this->_get_noticias_portal();
        $noticia['noticias'] = $this->procesarNoticias();        
        $html = base64_encode($this->load->view('ajax_noticias_portal',$noticia,TRUE));
        echo json_encode(array('respuesta' => $html));
        exit();
        
    }

    public function procesarNoticias()
    {
        $model= $this->_get_noticias_portal();
        $noticias = array();
      
        if (isset($model->registros) && count($model->registros) > 0) {
            $lng = 0;
            foreach ($model->registros as $key => $noticia) { 

                if ($noticia->pprincipal == 1 ) {
                    $lng++;
                    if ($lng <= 1) {
                        $noticias['principal'][] = $this->construirNoticia($noticia);
                    }else{
                         $noticias['noticias'][] = $this->construirNoticia($noticia); 
                    }
                }else{

                    $noticias['noticias'][] = $this->construirNoticia($noticia); 
                }
               
           }
        }
        
        return $noticias;
    }

    public function construirNoticia($noticia)
    {
        
        $arr['id_dpcia'] = $noticia->id_dpcia;
        $arr['pprincipal'] = $noticia->pprincipal;
        $arr['ruta'] = isset($noticia->archivos->ruta) ? $noticia->archivos->ruta : URL_ADMIWEB;
        $arr['dia_publicacion'] = $noticia->dia_publicacion;
        $arr['str_mes_publicacion'] = $noticia->str_mes_publicacion;
        $arr['titulo'] = $noticia->titulo;
        $arr['descripcion'] = $noticia->descripcion;
        $arr['id_cont_b64'] = $noticia->id_cont_b64;
        
        if (isset($noticia->archivos) && isset($noticia->archivos->registros) && count($noticia->archivos) > 0) {
           foreach ($noticia->archivos->registros as $key => $noticia) {
                if (isset($noticia->nom_archivo) && count($noticia) > 0) {
                   $arr['archivo']['nombre']    = $noticia->nom_archivo;
                   $arr['archivo']['url_image'] = URLCOLIMAEDO.'imagenv2.php?x='.base64_encode($noticia->id_archivo)."&amp;y=1&amp;z=2";//'&amp;y=23&amp;z=1';
                }else{
                    $arr['archivo']['nombre'][] = URLCOLIMAEDO."assets/img/sin-imagen.png";
                }
           }
        }else{
            $arr['archivo']['url_image'] = URLCOLIMAEDO."assets/img/sin-imagen.png";
        }
       
       return $arr;
    }
    
    public function get_album_ajax(){                        
        $Album=$this->get_galeria_flick(4);        
        $album['album'] = $Album;
        $html =  base64_encode($this->load->view('ajax_multimedia_portal',$album,TRUE));   
        echo json_encode(array('respuesta' => $html));
        exit();
    }
    
    protected function _get_noticias_portal_paginacion($count)
    {    
        $this->load->helper("fechas");
        $cve_dep = IniRead("general", "cve_portalnoticias");
        $seccion = IniRead("general", "sec_noticia");
        $cuantos = $count+6;
        $reg_ini = 0;//IniRead("general", "noticia_inicial");
        $f_inicial = date('Y-m-d');
        $orderby = "fecha_publicacion DESC";        
        $parametros = array($cve_dep, $seccion, $f_inicial, $cuantos, $reg_ini, $orderby, "");
        // $config_api = $this->consumepu->_set_config_api($cve_dep);
        $formato = "json";
        $contenido = $this->consumepu->get_contenido(METHOD_LISTADOS,$parametros, $formato);
        
        if (isset($contenido->registros) && count($contenido->registros) > 0 ) 
        {
            foreach ($contenido->registros as $key => $value) {
                $value->id_cont_b64 = base64_encode($value->id_cont);
                $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
                $value->str_mes_publicacion = strtoupper(get_str_month_short($value->fecha_publicacion));
            }

        }
        return $contenido;
    }

    protected function _get_all_funcionarios() {
        $response = $this->get_funcionario->get_funcionarios_all();
        
        if (is_null($response) && count($response) < 0 && !isset($response)) {
            return array("msg" => "Sin informacion.");
        } else {
            return $response;
        }
    }

    protected function _get_detalle_funcionario($id = "") {
        if ($id == "") {
            return array();
        } else {
            $response = $this->get_funcionario->getFuncionario_detalles($id);
            return $response;
        }
    }
    
    public function get_galeria_flick($Limit=0){                
        $this->load->model('General_model');
        $this->load->library('flickr');
        
        $cve_dep = IniRead("general", "id_dep_colima_edo");
        $Flickr = $this->General_model->getDependenciaInfo($cve_dep);
        $IdCollection=isset($Flickr[0]['usr_flickr']) ? $Flickr[0]['usr_flickr'] : '';
        
        $parametros = array(
            'collection_id' => $IdCollection,
            'user_id' => IniRead("general", "id_user_flickr")
        );                                    

    //Inicio - Sección de cacheo [ OBTENER ]
        $hash = $this->pucache->getCacheHash(array($parametros,"_get_galeria_flick"));
        $cacheData = $this->pucache->getByKey($hash);
        if ($cacheData) return $cacheData;
    //Fin - Sección de cacheo        

        //Metodo generico para obtener album y fotos de album       
        $response = $this->flickr->call(FLICKR_GET_COLLECTIONS, $parametros);         
        $procesar = $this->flickr->_procesar_collection($response,$Limit);               
        
    //Inicio - Sección de cacheo [ ESCRIBIR ]  
        $this->pucache->setByKey($hash,$procesar,"get_galeria_flick");
    //Fin - Sección de cacheo
        return $procesar;
    }   
    
    public function enviar_correo() {
        $this->load->library('form_validation');
        if ($this->input->post()) {
            $this->form_validation->set_rules('nombre', '<b>Nombre</b>', 'trim|required');
            $this->form_validation->set_rules('telefono', '<b>Teléfono</b>', 'trim|numeric');
            $this->form_validation->set_rules('email', '<b>Correo</b>', 'trim|required|valid_email');
            $this->form_validation->set_rules('mensaje', '<b>Mensaje</b>', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $msg['status'] = 'Error';
                $msg['msg'] = validation_errors();

            } else {

                if ($this->input->post('g-recaptcha-response') == FALSE) {
                    $msg['status'] = 'Capcha';
                    $msg['msg'] = "Verificación de reCAPTCHA obligatorio";
                    echo json_encode($msg);
                    die();
                } else {

                    $nombre = $this->input->post('nombre');
                    $asunto = $this->input->post('asunto');
                    $telefono = $this->input->post('telefono');
                    $email = trim($this->input->post('email'));
                    $mensaje = $this->input->post('mensaje');

                    									
                    /*Edwin bandera para enviar a otros correos*/
                    if ($this->input->post('sendto') == 1) {
                        $ban = 1;
                    }else{
                        $ban = 0;
						$curl = curl_init();    
						$Url="http://atencionciudadana.col.gob.mx/solicitudes/";        
						$POSTFIELDS= array(
							'nombre'=>$nombre,
							'telefono'=>$telefono,
							'correo'=>$email,
							'requerimiento' =>$mensaje
						);
						

						curl_setopt_array($curl, array(
							CURLOPT_URL => $Url,
							CURLOPT_RETURNTRANSFER => true,   
							CURLOPT_TIMEOUT => 15,        
							CURLOPT_POST => 1,        
							CURLOPT_POSTFIELDS => http_build_query($POSTFIELDS),
							CURLOPT_HTTPHEADER => array(        
								"Authorization: Basic QXRlbmNpb246TSVqSzJrJixTZTFTNVhF",        
							),
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);
						curl_close($curl);
                    }
                    

                    $data = Array(
                        'nombre' => $nombre,
                        'email' => $email,
                        'telefono' => $telefono,
                        'asunto' => ucfirst($asunto),
                        'mensaje' => $mensaje,
                        'sendto'  => $ban);
                    
                    echo $this->enviarCorreoOpenApis($data);
                }
            }
        } else {
            $msg['status'] = 'Error';
            $msg['msg'] = 'Lo sentimos, no fue posible enviar tu mensaje. Inténtalo nuevamente gracias.';
            echo json_encode($msg);
        }
    }

    public function enviarCorreoAdjuntos()
    {        
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre', '<b>Nombre</b>', 'trim|required');
        $this->form_validation->set_rules('domicilio', '<b>Domicilio</b>', 'trim|required');
        $this->form_validation->set_rules('hostigadora', '<b>Mensaje</b>', 'trim|required');
        $this->form_validation->set_rules('selectdependencia', '<b>Mensaje</b>', 'trim|required');   
        $this->form_validation->set_rules('narracion', '<b>Mensaje</b>', 'trim|required');
        $this->form_validation->set_rules('evidencia', '<b>evidencia</b>', 'trim|required');
        
        if (empty($_FILES)) {
            $this->form_validation->set_rules('archivoadjunto', '<b>archivo</b>', 'required');
        }

        $msg['status']='';
        $msg['msg']  = "";
        
        if ($this->form_validation->run() == FALSE) {
            $msg['status']='Error';
            $msg['msg']=validation_errors();
        }else{
            $this->load->library('Contenidos');
            $upload = $this->contenidos->uploadFileFtp($_FILES);

            $data = array(
                'nombre' => $this->input->post('nombre'),
                'domicilio' => $this->input->post('domicilio'),
                'hostigadora' => $this->input->post('hostigadora'),
                'selectdependencia' => $this->input->post('selectdependencia'),
                'narracion' => $this->input->post('narracion'),
                'evidencia' => $this->input->post('evidencia'),
                'archivoadjunto' => URL_DOWNLOAD_ICM.$upload
            );
            
            $request = $this->consumepu->get_contenido(ENDPOINT_CORREOADJUNTOS, $data, "json" , TRUE);
            // $request = $this->consumepu->consumeWsCurlPost($data, $url);
            echo json_encode($request);
            die();
        }

        echo json_encode($msg);
        
    }

    public function emailConfiguracion()
    {
        $config = Array(
                   'protocol' => 'smtp',
                   'smtp_host' => 'smtp.mail.yahoo.com',
                   'smtp_port' => 587,
                   'smtp_crypto' => 'tls',
                   'smtp_user' => 'sfadiego@yahoo.com',
                   'smtp_pass' => 'Dasfaci0',
                   'mailtype' => 'html',
                   'charset' => 'utf-8',
                   'newline' => "\r\n"
                );
        
        $this->load->library('email');
        $this->email->initialize($config); 

    }


    public function enviarCorreoOpenApis($data = array())
    {
        if (isset($data) && count($data) > 0 ) {
            
            $Authorization = array('usr' => "portalUnico",'pwd' => "123456789");
            $mensajeHtml = $this->load->view('email_mensajes', $data, TRUE);
            $Url = "http://www.openapis.col.gob.mx/correos/v3/enviar";

           

           if ($data['sendto'] ==1) {
                $correos = 'compras2228@gmail.com,compras2228@hotmail.com'; 
            //$correos = 'abayarde21@gmail.com,lic.edwin.perez@gmail.com';
           }else{
                $correos = 'atencioncolima@gmail.com,atencioncolima2@gmail.com';
           }

            $post = array(
                        'correo' => $correos, 
                        'titulo' => $data['asunto'],
                        'contenido' => $mensajeHtml    
                      );

        }else{
             throw new Exception("Faltan parametros", 1);          
        }

        try {
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $Authorization["usr"] . ':' . $Authorization["pwd"]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            
            return $response;

        } catch (Exception $e) {
             
             die($e->getMessage());

        }
        
    }


    public function EnviaObservacionRetys(){
        $Tramite = $this->tramites->getTramiteReTYS($this->input->post('Tramite'));
        $Tramite=$Tramite[0];

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'webmaster.edo.colima@gmail.com',
            'smtp_pass' => '20corral15',
            'mailtype' => 'html',
            'charset' => 'utf-8');

        $this->load->library('email');
        $this->email->set_newline("\r\n");
        // Set to, from, message, etc.
        $this->email->initialize($config);
        
        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
                
        $Titulo = utf8_decode('Mensaje enviado desde el Portal Unico - Colima');
        $Mensaje="<p>El sr(a). <b>$Name</b> con correo electrónico <b>$Email</b> ha enviado el siguiente mensaje desde el <b>Portal Unico</b> al estar consultando el trámite <b>".$Tramite->Nombre."</b>: </p>";        
        $Mensaje.= utf8_decode($_POST['Message']);
        //echo $Mensaje; die();

        $mail="mejoraregulatoria@gobiernocolima.gob.mx";
        //$mail="vazquezornelas@gmail.com";
        $this->email->to($mail, 'Portal Único');
        $this->email->from($Email, "Portal Único");

        $this->email->subject($Titulo);        
        $this->email->message($Mensaje);
        $msg = array();
        if ($this->email->send()) {
            $msg['status'] = 'OK';
            $msg['msg'] = 'Para nosotros su opinión es muy importante, a la brevedad nos pondremos en contacto con usted.';
        } else {
            $msg['status'] = 'Error';
            $msg['msg'] = 'No fue posible enviar sus comentarios, inténtelo nuevamente. Gracias.';
        }
        echo json_encode($msg);
    }

    public function vContacto(){        
        $Data=array(
            'IdTramite'=>$this->input->post('Tramite')
        );
        $this->load->view("vcontacto",$Data);
    }

    public function Tramites() {
        $data['header'] = $this->_get_header();
        $js = array('menu_fixed' => 1);
        $data['footer'] = $this->_get_footer($js);
        $Categorias = $this->tramites->getCategorias();
        $IdCategoria = $Categorias[0]->id;
        $data['CSRF_Name']=$this->security->get_csrf_token_name();
        $data['CSRF_Hash']=$this->security->get_csrf_hash();

        $data['EnLinea_Categorias'] = $Categorias;
        $data['EnLinea_Tramites'] = $this->tramites->getCategoria($IdCategoria);
        $data['EnLinea_Tramites_Count']=$this->tramites->getTotalTramites();
        
        $Dependencias = $this->tramites->getDependencias();
        $Categorias = $this->tramites->getCategoriasRetys();
        $TipoUsuarios = $this->tramites->getTipoUsuariosRetys();                

        $IdCategoria = $Categorias[0]->Id_TemaCategoria;
        $TramitesXcategoria=$this->tramites->getTramitesCategoriaRetys($IdCategoria);
        $IdTipoUsuario= $TipoUsuarios[0]->Id_Tipo_Usuario;                
        $TramitesXtipoUsuarios=$this->tramites->getTramitesTipoUsuarioRetys($IdTipoUsuario);        

        $IdDependencia = $Dependencias[0]->id_dependencia;
        $data['EnLinea_Dependencias'] = $Dependencias;
        $data['EnLinea_Tramites_Dependencia'] = $this->tramites->getTramitesDependencia($IdDependencia);

        $DependenciasReTYS = $this->tramites->getDependenciasRetys();
        $IdAds = $DependenciasReTYS[0]->Id_Ads;
        $data['Retys_Total_Tramites'] = $this->tramites->getTotalTramitesRetys();
        $data['Retys_Categorias'] = $Categorias;        
        $data['Retys_TiposUsuarios'] = $TipoUsuarios;
        $data['Retys_Dependencias'] = $DependenciasReTYS;        

        $data['Retys_Tramites_Categoria'] = $TramitesXcategoria;
        $data['Retys_Tramites_TipoUsuario'] = $TramitesXtipoUsuarios;
        $data['Retys_Tramites'] = $this->tramites->getTramitesDependenciaRetys($IdAds);        


        $data['atencionc'] = $this->load->view('sec_atencion_ciudadana', "", TRUE);
        //$data['atencionc'] = $this->load->view('sec_atencion_ciudadana', "", TRUE);
        // if ($this->agent->is_mobile()) {
        //     $data['contenido'] = $this->load->view('tramites_movil', $data,TRUE);
        // }else{
        // $data['tramiteLinea'] = $this->load->view("tramites_en_linea");
        // $data['tramitePresencial'] = $this->load->view("tramites_presencial");
        
        $data['contenido'] = $this->load->view('tramites', $data,TRUE);
        // }
        /*Breadcrumb*/
        //Label //URL //Activo
        $bread[] = array("Portal",base_url('Portal'),"");
        //$bread[] = array("Icsic","www.colima.col","");
        $bread[] = array("Trámites","","active");
        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
        $this->load->view("layout_detalles",$data);
    }

    public function DetalleTramiteReTYS($IdAds, $IdTramite) {
        $Tramite = $this->tramites->getTramiteReTYS($IdTramite);
        if($Tramite != false){
            $Tramite = $Tramite[0];
        }else{
            redirect(site_url());
        }
        $data['header'] = $this->_get_header();
        $this->load->library('Directorio_integral');
        $Dependencia = $this->directorio_integral->getDependencia($IdAds);                        
        if(isset($Dependencia->error)){
            $Dependencia=$this->tramites->getDependenciaReTYS($IdAds);            
        }
        $data['Dependencia'] = $Dependencia;
        $data['Tramite'] = $Tramite;
        if($Tramite != false){
            $IdAds = $Tramite->Id_Ads;
        }else{
            $IdAds = false;
        }
        $Responsable = $this->directorio_integral->getDependencia($IdAds);
        $data['Responsable'] = $Responsable;
        $js = array('menu_fixed' => 1);
        $data['footer'] = $this->_get_footer($js);
        $data['atencionc'] = $this->load->view('sec_atencion_ciudadana', "", TRUE);
        /*Breadcrumb*/    
        //Label //URL //Acustoctivo
        $bread[] = array("Portal",base_url('Portal'),"");
        //$bread[] = array("Icsic","www.colima.col","");
        $bread[] = array("Trámites","","active");
        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
        $_SESSION['UID'] = uniqid();
        $data['contenido'] = $this->load->view('layout_detalle_tramite', $data ,TRUE);
        $this->load->view('layout_detalles', $data);
    }
    #busqueda tramites 
    public function busquedaTramitesRetys_table()
    {  
       $parametro = $this->input->post('inputBusquedaRetys');
       $param = $this->limpiar_string($parametro);       
       if (isset($param) && $param !="") {
            $response =  $this->detalle_tramite_get($param);            
            
            if (isset($response) && count($response) > 0) {
                $sum = 0;
                foreach ($response as $key => $registro) {
                    $rutatramite = base_url('Portal/DetalleTramiteReTYS/'.$registro['id']);
                    $sum = $key+1; 
                    $name = $registro['nombre'];
                    $link = "<a target='_blank' href='". base_url('Portal/DetalleTramiteReTYS/'.$registro['id'])."' title=''><i class='fa fa-external-link titlu-rojo-pu'></i></a>";
    $html[] =  <<<EOT
"<tr>
       <th scope='row'>$sum</th>
       <td><a class="cursor"  href="$rutatramite" target='_blank' class="cursor">$name</a></td>
       <td>$link</td>
     </tr>"; 
EOT;
                  
                }
            echo json_encode(array("status"=>"Success","textbuscador"=>$this->input->post('inputBusquedaRetys'),"html"=>$html,"CSRF_Name"=>$this->security->get_csrf_token_name(),"CSRF_Hash"=>$this->security->get_csrf_hash()));

            }else{
                echo json_encode(array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor","textbuscador"=>$this->input->post('inputBusquedaRetys'),"CSRF_Name"=>$this->security->get_csrf_token_name(),"CSRF_Hash"=>$this->security->get_csrf_hash()));
            }

       }else{
          echo json_encode(array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor","textbuscador"=>$this->input->post('inputBusquedaRetys'),"CSRF_Name"=>$this->security->get_csrf_token_name(),"CSRF_Hash"=>$this->security->get_csrf_hash()));

       }
       exit();
    }

    public function busquedaTramitesRetys_ABC(){
        $Letra=$this->input->post("Letra");
        $response =  $this->detalle_tramite_ABC($Letra);                    
        if (isset($response) && count($response) > 0) {
            $sum = 0;
            foreach ($response as $key => $registro) {
                $rutatramite = base_url('Portal/DetalleTramiteReTYS/'.$registro['id']);
                $sum = $key+1; 
                $name = $registro['nombre'];
                $link = "<a target='_blank' href='". base_url('Portal/DetalleTramiteReTYS/'.$registro['id'])."' title=''><i class='fa fa-external-link titlu-rojo-pu'></i></a>";
$html[] =  <<<EOT
"<tr>
   <th scope='row'>$sum</th>
   <td><a class="cursor"  href="$rutatramite" target='_blank' class="cursor">$name</a></td>
   <td>$link</td>
 </tr>"; 
EOT;
              
        }
        echo json_encode(array("status"=>"Success","textbuscador"=>$this->input->post('inputBusquedaRetys'),"html"=>$html,"CSRF_Name"=>$this->security->get_csrf_token_name(),"CSRF_Hash"=>$this->security->get_csrf_hash()));

        }else{
            echo json_encode(array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor","textbuscador"=>$this->input->post('inputBusquedaRetys'),"CSRF_Name"=>$this->security->get_csrf_token_name(),"CSRF_Hash"=>$this->security->get_csrf_hash()));
        }
    }

    public function get_tramite_linea($parametro)
    {
        $formato = "json";
        //Cambiar segun dependencia
        $cve_dep = IniRead("general", "id_dep_colima_edo");
        //parametros para WS
        //[0]Dependencia
        //[1]Archivos
        $parametros = array($parametro);
        //print_r($parametros);         
        // $config_api = $this->consumepu->_set_config_api($cve_dep);                        
        $response = (array)$this->consumepu->get_contenido(METHOD_BUSQUEDA_TRAMITE, $parametros, $formato);        
        //utils::pre($response);
        return $response;
    }
    
    /*Angular Request angular*/
    public function busqueda_tramite_linea()
    {
       $parametro = $this->input->post('inputBusquedalinea');
       if (isset($parametro) && $parametro !="") {
            $response = $this->get_tramite_linea($parametro);
            if (count($response['resultado']) > 0 && isset($response['resultado']->registros)) {
                
                echo json_encode($response);

            }else{
                return $this->output->set_content_type('application/json')->set_output(json_encode( array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor")));
            }
            
        }else{
           return $this->output->set_content_type('application/json')->set_output(json_encode( array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor")));
        }

    }
    /*Fin */
    
    public function busquedaTramiteLinea()
    {
       $datos['CSRF_Name']=$this->security->get_csrf_token_name();
       $datos['CSRF_Hash']=$this->security->get_csrf_hash();
       
       $parametro = $this->input->post('inputBusquedalinea');
       $param = $this->limpiar_string($parametro);
       if (isset($param) && $param !="") {
            $response = $this->get_tramite_linea($param);
            if (isset($response['resultado']) && count($response['resultado']) > 0 && isset($response['resultado']->registros)) {
               
                foreach ($response['resultado']->registros as $key => $value) {
                    $rutaretys = false;
                    if($value->cve_retis != false){                        
                        //// VERIFICAR SI EXISTE EN RETYS PARA MANDAR EL LINK A LA FICHA TECNICA, EN CASO DE NO EXISTIR SE MANDA AL LA URL DEL TRAMITE
                        $Tramite = $this->tramites->getTramiteReTYS($value->cve_retis);
                        if($Tramite != false){
                            $Tramite = $Tramite[0];
                            $IdAds = $Tramite->Id_Ads;
                            $rutaretys =  base_url('Portal/DetalleTramiteReTYS/'.$IdAds.'/'.$value->cve_retis);
                        }
                    }
                    $sum = $key+1; 
                    if($rutaretys == false){
                       $linkdescripcion = "<a class='cursor' onclick='javascript:SaliendoPortal(".'"'.$value->url_tramite.'"'.")'>$value->nombre</a>";
                       $link  = "<a onclick='javascript:SaliendoPortal(".'"'.$value->url_tramite.'"'.")'  title='' target='_blank'> <i class='fa fa-external-link titlu-rojo-pu cursor'></i></a>";
                    }else{
                       $linkdescripcion = "<a href=".'"'.$rutaretys.'"'."  title='' target='_blank'>$value->nombre</a>";
                       $link  = "<a href=".'"'.$rutaretys.'"'."  title='' target='_blank'> <i class='fa fa-external-link titlu-rojo-pu cursor'></i></a>";
                    }
$html[] =  <<<EOT
"<tr>
       <th scope='row'>$sum</th>
       <td>$linkdescripcion</td>
       <td>$link</td>
     </tr>"; 
EOT;
                }
              echo json_encode(array("status"=>"Success","textbuscador"=>$this->input->post('inputBusquedalinea'),"html"=>$html,"CSRF_Name"=>$this->security->get_csrf_token_name(),"CSRF_Hash"=>$this->security->get_csrf_hash()));

            }else{
                echo json_encode(array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor","textbuscador"=>$this->input->post('inputBusquedalinea'),"CSRF_Name"=>$this->security->get_csrf_token_name(),"CSRF_Hash"=>$this->security->get_csrf_hash()));
            }
        }else{
                echo json_encode(array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor","textbuscador"=>$this->input->post('inputBusquedalinea'),"CSRF_Name"=>$this->security->get_csrf_token_name(),"CSRF_Hash"=>$this->security->get_csrf_hash()));

        }
        exit();
    }
    # fin busqueda tramites 

    public function Categoria($Id) {
        $Tramites = $this->tramites->getCategoria($Id);
        
        echo '<h3 style="margin-top: 15px;margin-bottom: 10px;">' . $Tramites[0]->Seccion . '</h3>';
        echo '<ul>';
        if (count($Tramites) > 0) {
            foreach ($Tramites as $row) {
                // echo "<pre>";
                // print_r ($row->mantenimiento);
                // print_r ($row->nombre);
                // echo "</pre>";
                if ($row->mantenimiento != 1) {
                    echo '<li id="P2_' . $row->id . '">
                            <a class="subcategory" onclick="javascript:IrArriba()" href="javascript:CargaTramite(' . $row->id_tramite . ',\'pane3\');" data-subcategory-id="' . $row->id_tramite . '" style="display:flex">
                                <div class="col-12">  
                                    <span>' . $row->nombre . '</span>
                                </div>
                                <div class="col-1" style="padding-top:7px;">
                                    <span class="pull-right fa fa-chevron-right"></span>    
                                </div>  
                            </a>
                        </li>';
                }
            }
        }
        echo '</ul>';
        exit();
    }

    public function CargaTramite($Id) {
        $Tramite = $this->tramites->getTramiteLinea($Id);
        $ClaveRetys=$Tramite->cve_retis;      
        echo '<h3 class="text-justify">' . $Tramite->nombre . '</h3>';        
        //echo $Tramite->descripcion;        
        $Descrip=$Tramite->descripcion;            
        $Descrip = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $Descrip);
        echo $Descrip;

        if (trim($Tramite->url_tramite) != "") {
            $Url = $Tramite->url_tramite;
            echo '<div class="row">
                <div class="col-6">';                
            if($ClaveRetys!=""){
                $TramiteRetys = $this->tramites->getTramiteReTYS($ClaveRetys); 
                                          
                if(count($TramiteRetys)>0){
                    echo '<button class="btn btn-default custom-buttom-noticias col-12 cursor" onClick="LanzaTramite(\''.$TramiteRetys[0]->Id_Ads.'\','.$ClaveRetys.');">Ver más</button>';
                }
            }                
            echo '
                </div>
                    <div class="col-6">
                        <div onclick="javascript:SaliendoPortal('."'".$Url."'".')" class="btn btn-default custom-buttom-noticias col-12 cursor" title="Ir a trámite">Ir a trámite</div>
                    </div>                
                </div>';
        }

        exit();
    }

    public function TramitesDependencia($Id) {
        $Tramites = $this->tramites->getTramitesDependencia($Id);
        if (count($Tramites) > 0) {
            if (isset($Tramites->exito)) {
                die();
            }
            echo '<h3 style="margin-top: 15px;margin-bottom: 10px;">' . $Tramites[0]->Dependencia . '</h3>';
            echo '<ul>';
            if (count($Tramites) > 0) {
                foreach ($Tramites as $row) {
                    if ($row->mantenimiento != 1) {
                        echo '<li id="PD2_' . $row->id . '">
                                <a class="subcategory" onclick="javascript:IrArriba()" href="javascript:CargaTramite(\'' . $row->id . '\',\'pane6\');" data-subcategory-id="' . $row->id . '" style="display:flex">
                                    <div class="col-12">  
                                        <span>' . $row->nombre . '</span>
                                    </div>
                                    <div class="col-1" style="padding-top:7px;">
                                        <span class="pull-right fa fa-chevron-right"></span>    
                                    </div>  
                                </a>
                            </li>';
                    }
                }
            }
            echo '</ul>';
        }
    }    

    public function TramitesCategoriaReTYS($Id){                
        $Categoria = $this->tramites->getCategoriaRetys($Id);           
        $Tramites = $this->tramites->getTramitesCategoriaRetys($Id);        
        echo '<h3 style="margin-top: 15px;margin-bottom: 10px;">' . $Categoria->Descrip . '</h3>';        
        if (count($Tramites) > 0) {            
            echo '<ul>';
            if (count($Tramites) > 0) {
                foreach ($Tramites as $row) {                    
                    echo '<li id="PD2_' . $row->Id_Tramite . '_C">
                            <a class="subcategory" onclick="javascript:IrArriba()" href="javascript:CargaTramiteReTYS(\'' . $Id . '\',' . $row->Id_Tramite . ',1);" data-subcategory-id="' . $row->Id_Tramite . '" style="display:flex">
                                <div class="col-12">  
                                    <span>' . $row->Nombre . '</span>
                                </div>
                                <div class="col-1" style="padding-top:7px;">
                                    <span class="pull-right fa fa-chevron-right"></span>    
                                </div>  
                            </a>
                        </li>';
                }
            }
            echo '</ul>';
            exit();
        }        
    }

    public function TramitesTipoUsuarioReTYS($Id){        
        $TipoUsuario = $this->tramites->getTipoUsuarioReTYS($Id);
        echo '<h3 style="margin-top: 15px;margin-bottom: 10px;">' . $TipoUsuario->Descrip . '</h3>';        
        $Tramites = $this->tramites->getTramitesTipoUsuarioRetys($Id);
        if (count($Tramites) > 0) {                        
            echo '<ul>';
            if (count($Tramites) > 0) {
                foreach ($Tramites as $row) {                    
                    echo '<li id="PD2_' . $row->Id_Tramite . '_U">
                            <a class="subcategory" onclick="javascript:IrArriba()" href="javascript:CargaTramiteReTYS(\'' . $TipoUsuario->Id_Tipo_Usuario . '\',' . $row->Id_Tramite . ',2);" data-subcategory-id="' . $row->Id_Tramite . '" style="display:flex">
                                <div class="col-12">  
                                    <span>' . $row->Nombre . '</span>
                                </div>
                                <div class="col-1" style="padding-top:7px;">
                                    <span class="pull-right fa fa-chevron-right"></span>    
                                </div>  
                            </a>
                        </li>';
                }
            }
            echo '</ul>';
            exit();
        }
    }

    public function TramitesDependenciaReTYS($IdAds) {
        $Dependencia = $this->tramites->getDependenciaReTYS($IdAds);
        $Tramites = $this->tramites->getTramitesDependenciaRetys($IdAds);
        if (count($Tramites) > 0) {
            if (isset($Tramites->exito)) {
                die();
            }
            echo '<h3 style="margin-top: 15px;margin-bottom: 10px;">' . $Dependencia->Descrip . '</h3>';
            echo '<ul>';
            if (count($Tramites) > 0) {
                foreach ($Tramites as $row) {
                    echo '<li id="PD2_' . $row->id_tramite . '">
                            <a class="subcategory" onclick="javascript:IrArriba()" href="javascript:CargaTramiteReTYS(\'' . $IdAds . '\',' . $row->id_tramite . ',3);" data-subcategory-id="' . $row->id_tramite . '" style="display:flex">
                                <div class="col-12">  
                                    <span>' . $row->nombre . '</span>
                                </div>
                                <div class="col-1" style="padding-top:7px;">
                                    <span class="pull-right fa fa-chevron-right"></span>    
                                </div>  
                            </a>
                        </li>';
                }
            }
            echo '</ul>';
            exit();
        }
    }

    public function CargaTramiteReTYS($IdAds, $Id) {        
        $Tramite = $this->tramites->getTramiteReTYS($Id);                
        echo '<h3 class="text-justify">' . $Tramite[0]->Nombre . '</h3>';
        echo '<p class="text-justify">' . $Tramite[0]->Descripcion . '</p>';        

        echo '<div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                    <a href="' . site_url('Portal/DetalleTramiteReTYS/' . $IdAds . '/' . $Tramite[0]->Id_Tramite) . '" target="_blank" class="btn btn-default custom-buttom-noticias col-12" title="Ver más">Ver más</a>
                </div>                
              </div>';

        if(trim($Tramite[0]->Aviso_privacidad) != "" ){
            $AvisoPrivacidad="http://www.tramitesyservicios.col.gob.mx/formatos/".$Tramite[0]->Aviso_privacidad;
        }else{
            //$AvisoPrivacidad=base_url('assets/docs/avisodeprivacidad.pdf');
            $AvisoPrivacidad="";
        }        

        if($AvisoPrivacidad!=""){

        echo '<div class="row" style="margin: 30px 0px;text-align:right">                   
                   <div class="col-lg-12">
                        <a href="'.$AvisoPrivacidad.'" target="_blank" style="padding: 0px;color: #4A90E2;font-style: italic;">
                            Política de Privacidad y Manejo de Datos Personales&nbsp;&nbsp;<span class="fa fa-file-pdf-o"></span>
                        </a>    
                   </div> 
              </div>';  
        }
        exit();
    }    

    public function eventos() {        
        $data['header'] = $this->_get_header();
        //Indicamos que archivos cargamos en la libreria
        //[1]menu-fixed.js
        $js = array('menu_fixed' => 1);
        $data['footer'] = $this->_get_footer($js);
        /*Breadcrumb*/    
        //Label //URL //Activo
        $bread[] = array("Portal",base_url('Portal'),"");
        //$bread[] = array("Icsic","www.colima.col","");
        $bread[] = array("Eventos","","active");
        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
        
        $evento['eventos'] = (array) $this->_get_more_events();
        
        $data['atencionc'] = $this->load->view('sec_atencion_ciudadana', "", TRUE);
        
        $data['contenido'] = $this->load->view('eventos', $evento,TRUE);
        $this->load->view('layout_detalles', $data);
    }

    public function escudo() {        
        $data['header'] = $this->_get_header();
        //Indicamos que archivos cargamos en la libreria
        //[1]menu-fixed.js
        $js = array('menu_fixed' => 1);
        $data['footer'] = $this->_get_footer($js);
        /*Breadcrumb*/    
        //Label //URL //Activo
        $bread[] = array("Portal",base_url('Portal'),"");
        //$bread[] = array("Icsic","www.colima.col","");
        $bread[] = array("Escudo","","active");
        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
    
        
        $data['contenido'] = $this->load->view('detalle_escudo', "",TRUE);
        $this->load->view('layout_detalles', $data);
    }

    protected function _get_event_detail($id=NULL) {
        $this->load->helper("fechas");
        if (is_null($id)) {
            return array("msg" => "ID de contenido obligatorio");
        }

        $id_contenido = base64_decode($id);             
        $cve_dep = IniRead("general", "id_dep_eventos");       
        $formato = "json";
        // $config_api = $this->consumepu->_set_config_api($cve_dep);
        $parametros = array($cve_dep, $id_contenido);
        $contenido = $this->consumepu->get_contenido(METHOD_CONTENIDO, $parametros, $formato);                 
        $contenido->cuerpo_cont[0]->str_dia_publicacion = strtoupper(get_day($contenido->cuerpo_cont[0]->fecha_publicacion));
        $contenido->cuerpo_cont[0]->str_mes_publicacion = strtoupper(get_str_month($contenido->cuerpo_cont[0]->fecha_publicacion));               
        return $contenido;
    }

    public function detalle_eventos() {         
        if ($this->uri->segment(3) != ""){           
            $data['header'] = $this->_get_header();
            //Indicamos que archivos cargamos en la libreria
            //[1]menu-fixed.js
            $js = array('menu_fixed' => 1);
            $data['footer'] = $this->_get_footer($js);
            /*Breadcrumb*/    
            //Label //URL //Activo
            $bread[] = array("Portal",base_url('Portal'),"");
            //$bread[] = array("Icsic","www.colima.col","");
            $bread[] = array("Eventos","","active");
            $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
            $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);        
            $evento['detail'] = (array) $this->_get_event_detail($this->uri->segment(3));

            $evento['redessociales']   = $this->load->view('sec_redes_sociales_mod',"",TRUE);
            $data['contenido'] = $this->load->view('detalle_eventos', $evento,TRUE);
            $data['atencionc'] = $this->load->view('sec_atencion_ciudadana', "", TRUE);
            
            if (preg_match("/face/i", $_SERVER['HTTP_USER_AGENT'])) {
                $html = $this->load->view('detalle_eventos_face',$evento,TRUE);
                print $html;
                exit();
            }
            
            $this->load->view('layout_detalles', $data);    
        }else{
            redirect($_SERVER['HTTP_REFERER']);
        }
        
    }

    


    function ajax_destacados(){
        $id = $this->input->post("id_reg");
        if($id > 0 && is_numeric($id)){
            $response = $this->_get_contenido(base64_encode($id),IniRead("general", "id_dep_colima_edo"));
            if (isset($response)) {
                echo json_encode($response);
            }else{
                return array("mensaje" => 'Error al obtener los datos');
            }
        }
    }

    function contenido($id=0){
        $this->load->helper("fechas");
        $data['header'] = $this->_get_header();
        $js = array('menu_fixed' => 0);
        $data['footer'] = $this->_get_footer($js);
        //$data['navbar']   = $this->load->view('navbar',"",TRUE);


        $contenido = $this->_get_contenido($id);

        foreach ($contenido->cuerpo_cont as $key => $value) {
            $value->id_cont_b64 = base64_encode($value->id_cont);
            $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
            $value->str_mes_publicacion = get_str_month($value->fecha_publicacion);
            
        }

        $datos['contenido'] = (array)$contenido;
        $data['atencionc']   = $this->load->view('sec_atencion_ciudadana',"",TRUE);


        /*Breadcrumb*/
        $this->load->library('Breadcrumb');
        //Label //URL //Activo
        $bread[] = array("Portal",site_url(DPCIA_PORTAL),"");
        $bread[] = array("Contenidos","","active");

        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);

        $data['contenido'] = $this->load->view('detalle_contenido',$datos,TRUE);
        $this->load->view('layout_detalles',$data);

    }
    
    function mapa_sitio($id=0){
        $this->load->helper("fechas");
        $data['header'] = $this->_get_header();
        $js = array('menu_fixed' => 0);
        $data['footer'] = $this->_get_footer($js);
        //$data['navbar']   = $this->load->view('navbar',"",TRUE);


       // $data['atencionc']   = $this->load->view('sec_atencion_ciudadana',"",TRUE);


        /*Breadcrumb*/
        $this->load->library('Breadcrumb');
        //Label //URL //Activo
        $bread[] = array("Portal",site_url(DPCIA_PORTAL),"");
        $bread[] = array("Mapa del sitio","","active");

        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);

        $data['contenido'] = $this->load->view('mapa_sitio',false,TRUE);
        $this->load->view('layout_detalles',$data);

    }

    function contenido_ajax(){
        $this->load->helper("fechas");

        $contenido = array();
        if (strlen($this->input->post("id_reg")) > 0) {
            $id_reg = $this->input->post("id_reg");
            $contenido = $this->_get_contenido($id_reg);

           

            if (count($contenido) > 0) {
                
                foreach ($contenido->cuerpo_cont as $key => $value) {
                    $value->id_cont_b64 = base64_encode($value->id_cont);
                    $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
                    $value->str_mes_publicacion = get_str_month($value->fecha_publicacion);
                    
                }

                
            }
            $status = 1;
            $html = $contenido->cuerpo_cont[0]->cuerpo_cont;
        }else{
            $status = 0; 
            $html = "Error";
        }

        $contenido = array('status' => $status, 'code_html' => $html); 

        echo json_encode($contenido);

    }

    protected function _get_noticias_relacionadas($metadatos = '', $id_cont = 0)
    {    
        $this->benchmark->mark('get_noticias_start');  

        $this->load->model('Noticias_model');
        
        $this->load->helper("fechas");
         //$cve_dep = IniRead("general", "id_dep_colima_edo");
        $cve_dep = IniRead("general", "cve_portalnoticias"); //Mientras se suben noticias a portal 10200
         //$cve_dep = 120000; //ID EJEMPLO PARA TRAER NOTICIAS DESDE EL ADMINWEB   
         $seccion = IniRead("general", "sec_noticia");
         $cuantos = 6;

         $ArrMetadatos = explode(',',$metadatos);

       // var_dump($ArrMetadatos);

        if($contenido = $this->Noticias_model->getNotRelacionadas($seccion,$cve_dep,$ArrMetadatos,base64_decode($id_cont))){
            //print_r($contenido);

            $encontro_principal=0;
            $noticiasordenadas= array();
             foreach ($contenido as $key => $value) 
             {
                $value->id_cont_b64 = base64_encode($value->id_cont);
                $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
                $value->str_mes_publicacion = strtoupper(get_str_month_short($value->fecha_publicacion));
                if($value->pprincipal==1 && $encontro_principal==0)
                {
                    $encontro_principal=1;
                    array_push($noticiasordenadas, $value);
                }

                 
             }
            $encontro_principal=0;
             foreach ($contenido as $key => $value) 
             {
                $value->id_cont_b64 = base64_encode($value->id_cont);
                $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
                $value->str_mes_publicacion = strtoupper(get_str_month_short($value->fecha_publicacion));
                if($value->pprincipal==1 && $encontro_principal==0)
                {
                    $encontro_principal=1;
                }
                else
                {
                    array_push($noticiasordenadas, $value);
                }
             }

        }else{
            $contenido = array();
        }
    

        $this->benchmark->mark('get_noticias_end');
        
         //return $contenido;
        $variableregreso = $noticiasordenadas;
         return $variableregreso;
    }

    protected function _get_noticias_portal()
    {   
        $this->benchmark->mark('get_noticias_start');   
        
         $this->load->helper("fechas");
         //$cve_dep = IniRead("general", "id_dep_colima_edo");
         $cve_dep = IniRead("general", "cve_portalnoticias"); //Mientras se suben noticias a portal 10200

         //$cve_dep = 999999; //ID EJEMPLO PARA TRAER NOTICIAS DESDE EL ADMINWEB   
         $seccion = IniRead("general", "sec_noticia");
         $cuantos = 15;
         $reg_ini = 0;//IniRead("general", "noticia_inicial");
         $f_inicial = date('Y-m-d');
         $orderby = "fecha_publicacion DESC, id_cont DESC";        
         $parametros = array($cve_dep, $seccion, $f_inicial, $cuantos, $reg_ini, $orderby, 0, "");
         // $config_api = $this->consumepu->_set_config_api($cve_dep);
         $formato = "json";
         $contenido = $this->consumepu->get_contenido(METHOD_LISTADOS,$parametros, $formato);
      
         if (isset($contenido->registros) && count($contenido->registros) > 0 ) 
         {
            // $encontro_principal=0;
            // $noticiasordenadas= array();

             foreach ($contenido->registros as $key => $value) 
             {

                $value->id_cont_b64 = base64_encode($value->id_cont);
                $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
                $value->str_mes_publicacion = strtoupper(get_str_month_short($value->fecha_publicacion));
                // if($value->pprincipal==1 && $encontro_principal==0)
                // {
                //     $encontro_principal=1;
                //     array_push($noticiasordenadas, $value);
                // }else{
                     // array_push($noticiasordenadas, $value);
                // }

             }

         }

        $this->benchmark->mark('get_noticias_end');

        
        // echo "<pre>";
        // print_r ($contenido->registros);
        // echo "</pre>";
         //return $contenido;
       // $variableregreso->registros = $noticiasordenadas;

        return $contenido;
    }
    
    public function detalle_galeria($id = NULL){           
        if (is_null($id)) { redirect(base_url(),'refresh'); }else{            
            $data['header'] = $this->_get_header();
            //$data['navbar']   = $this->load->view('navbar',"",TRUE);
            //Indicamos que archivos cargamos en la libreria
            //[1]menu-fixed.js
            $js = array('menu_fixed' => 1);
            $data['footer'] = $this->_get_footer($js);                        
            
            $this->load->library('flickr');
            $cve_dep = IniRead("general", "id_dep_colima_edo");            
            $parametros = array(
                'photoset_id' => $id,
                'user_id' => IniRead("general", "id_user_flickr")
            );                                                       
            $response = $this->flickr->call(FLICKR_GET_FOTOS, $parametros);                                             
            $response=$this->flickr->_procesar_photoset($response,0);                        

            $listado["lst_galerias"] = $response['Fotos'];                                                
            $listado['posicion'] = 0;                        
            
            if (preg_match("/face/i", $_SERVER['HTTP_USER_AGENT'])) {
                $html = $this->load->view('galeria_slider_face',$listado,TRUE);
                print $html;
                exit();
            } else{
                $listado['sliderg']  = $this->load->view('galeria_slider',$listado,TRUE);
            }            
                           
            $this->load->model("Depcias_model");
            $Flickr=$this->Depcias_model->getFlickr($cve_dep);                        
            if(isset($Flickr->usr_flickr)){
                $IdCollection=$Flickr->usr_flickr;        
                $Data=array(
                    'Id'=>$IdCollection,                
                    'Controlador'=>$this->controlador
                );            
                $listado['otros_album'] = $this->load->view('sec_otros_album',$Data, TRUE);
            }
            
            $data['atencionc']   = $this->load->view('sec_atencion_ciudadana',"",TRUE);
            /*Breadcrumb*/
            //Label //URL //Activo

            $bread[] = array("Portal",base_url(DPCIA_PORTAL),"");
            $bread[] = array("Galerías",base_url('portal/listado_album'),"");
            $bread[] = array("Detalle de Galería","","active");

            $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
            $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);

            $listado['redessociales']   = $this->load->view('sec_redes_sociales_link',$this->redes,TRUE);
            $data['contenido'] = $this->load->view('detalle_galeria',$listado, TRUE);
            $this->load->view('layout_detalles', $data);
        }
    }
     
    public function listado_album(){        
        $data['header'] = $this->_get_header();
        //Indicamos que archivos cargamos en la libreria
        //[1]menu-fixed.js
        $js = array('menu_fixed' => 0);
        $data['footer'] = $this->_get_footer($js);
        
        $Galeria=$this->get_galeria_flick(0);        
        $listado["Albums"] = $Galeria;                
        
        $listado["Controlador"]= $this->controlador;
        /*Breadcrumb*/
        $this->load->library('Breadcrumb');
        //Label //URL //Activo

        $bread[] = array("Portal",base_url(DPCIA_PORTAL),"");
        $bread[] = array("Galerías","","active");

        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
        $data['atencionc']   = $this->load->view('sec_atencion_ciudadana',false,TRUE);
        $data['contenido']   = $this->load->view('listado_fotografias_portal',$listado,TRUE);
        
        $this->load->view('layout_detalles',$data);
    }
    
    public function intranet($id=0){
        $this->load->helper("fechas");
        $data['header'] = $this->_get_header();
        $js = array('menu_fixed' => 1);
        
        $data['footer'] = $this->_get_footer($js);
        //$data['navbar']   = $this->load->view('navbar',"",TRUE);

        $contenido = $this->_get_contenido('NTY0OQ==');//id de contenido de intranet
        
        foreach ($contenido->cuerpo_cont as $key => $value) {
            $value->id_cont_b64 = base64_encode($value->id_cont);
            $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
            $value->str_mes_publicacion = get_str_month($value->fecha_publicacion);
            
        }

        $datos['contenido'] = (array)$contenido;

        $data['contenido'] = $this->load->view('detalle_contenido',$datos,TRUE);
        $this->load->view('layout_detalles',$data);
    }

    public function logout(){

        $this->session->unset_userdata('dependenceInfo');
                        utils::pre($_SESSION);

    }
        /*Fin */
 
    public function busquedaGeneral(){
       $parametro = $this->input->post('q');       
       $param = $this->limpiar_string($parametro);                     
       
       //$datos['CSRF_Name']=$this->security->get_csrf_token_name();
       //$datos['CSRF_Hash']=$this->security->get_csrf_hash();            
       
       //utils::pre($param);
       if (isset($parametro) && $parametro !="" && $param != false) {
           if(strlen($parametro) >= 3){                                           
                $data['lista'] = $this->busqueda($param);                                
                $data['tramites'] = $this->detalle_tramite2_get($param);                
                $data['tramitesLinea'] = $this->get_tramite_linea($param);                                                
                               
                $data['parametrobusqueda'] = $parametro;
                $this->load->model("busqueda_model");                
                //$data['micrositio'] = $this->busqueda_model->getBusquedaMicrositios($param);                
                $contador_tramites = ((isset($data['tramites']) && count($data['tramites'])>0) ) ? count($data['tramites']) : 0;
                
                $contador_tramiteslinea = (isset($data['tramitesLinea']) && isset($data['tramitesLinea']['resultado']) && array_key_exists('registros', (array)$data['tramitesLinea']['resultado']) && count((array)$data['tramitesLinea']['resultado']->registros) > 0) ? count($data['tramitesLinea']) : 0;
                $contador_contenidos = (isset($data['lista']) && is_object($data['lista']) && array_key_exists('resultado', (array)$data['lista']) && array_key_exists('registros', (array)$data['lista']->resultado) && count($data['lista']->resultado->registros)>0) ? count($data['lista']) : 0;
                $contar = $contador_tramites + $contador_tramiteslinea + $contador_contenidos;
                
                if($contar >= 1){
                    $html = base64_encode($this->load->view("ajax_busqueda_general",$data,true));
                    echo json_encode(array("status" => "Success"
                                          ,"textbuscador" => $parametro
                                          ,"html" => $html
                                          ,"CSRF_Name" => $this->security->get_csrf_token_name()
                                          ,"CSRF_Hash" => $this->security->get_csrf_hash()
                                    ));
                    exit();
                }else{
                    echo json_encode(array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor","textbuscador"=>$parametro,));
                    exit();
                }
            }else{
                echo json_encode(array("status"=>"Error","msg"=>"Favor de ingresar al menos 3 caracteres.","textbuscador"=>$parametro,));
                exit();
            }
           
        }else{
                echo json_encode(array("status"=>"Error","msg"=>"Parámetro de búsqueda no retorno ningún valor","textbuscador"=>$parametro,));
                exit();

        }
        
    }
    
    public function setTramiteLinea(){
        $idTramite = $this->input->get('tramite');
        //$url = "http://www.col.gob.mx/API_PU/";     
        $url = URL_API_COLIMAEDO;     
        $ci =& get_instance();
        $ci->load->library('rest2');
        $config = array('server' => $url);
        $ci->rest2->format('application/json');
        $ci->rest2->initialize($config);
        $response = $ci->rest2->get('Portalunico/accesosTramite',array('tramite'=>$idTramite));
        echo json_decode($response);
        exit();
    }
    
    public function CargaToken(){
        $datos['CSRF_Name']=$this->security->get_csrf_token_name();
        $datos['CSRF_Hash']=$this->security->get_csrf_hash();
        echo json_encode($datos);
    }
    
    function elimina_acentos($text)
    {
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        $patron = array (
            // Espacios, puntos y comas por guion
            //'/[\., ]+/' => ' ',
 
            // Vocales
            '/\+/' => '',
            '/&agrave;/' => 'a',
            '/&egrave;/' => 'e',
            '/&igrave;/' => 'i',
            '/&ograve;/' => 'o',
            '/&ugrave;/' => 'u',
 
            '/&aacute;/' => 'a',
            '/&eacute;/' => 'e',
            '/&iacute;/' => 'i',
            '/&oacute;/' => 'o',
            '/&uacute;/' => 'u',
 
            '/&acirc;/' => 'a',
            '/&ecirc;/' => 'e',
            '/&icirc;/' => 'i',
            '/&ocirc;/' => 'o',
            '/&ucirc;/' => 'u',
 
            '/&atilde;/' => 'a',
            '/&etilde;/' => 'e',
            '/&itilde;/' => 'i',
            '/&otilde;/' => 'o',
            '/&utilde;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            // Otras letras y caracteres especiales
            '/&aring;/' => 'a',
            '/&ntilde;/' => 'n',
 
            // Agregar aqui mas caracteres si es necesario
 
        );
 
        $text = preg_replace(array_keys($patron),array_values($patron),$text);
        return $text;
    }

    function get_album(){
        $this->load->model("Depcias_model");
        $this->load->library('flickr');
        $cve_dep = IniRead("general", "id_dep_colima_edo");
        $Flickr=$this->Depcias_model->getFlickr($cve_dep);        
        $parametros = array(
            'collection_id' => $this->input->post('Id'),
            'user_id' => IniRead("general", "id_user_flickr")
        );        
        $response = $this->flickr->call(FLICKR_GET_COLLECTIONS, $parametros);
        echo json_encode($response);
    }    
    
    function carga_galerias(){
        $Ids=$this->input->post('Ids');
        if(count($Ids)>0){
            foreach($Ids as $row){                
                $this->get_photoset($row);                
            }
        }
    }
    
    function get_photoset($Id){        
        $this->load->library('flickr');                
        $parametros = array(
            'photoset_id' => $Id,
            'user_id' => IniRead("general", "id_user_flickr")
        );                
        $response = $this->flickr->call(FLICKR_GET_INFO, $parametros);                        
        $parametros=array(
            'photo_id'=>$response['photoset']['@attributes']['primary']
        );                
        $response2=$this->flickr->call(FLICKR_GET_PHOTO,$parametros);                
        $Photo=$this->flickr->_procesar_photo($response2);         
        $Data=array(
            'Controlador'=> $this->controlador,
            'src'=>$Photo['src'],
            'id'=>$response['photoset']['@attributes']['id'],
            'title'=>$response['photoset']['title']            
        );                 
        $this->load->view("sec_foto",$Data);
    }        

    function testFlickr(){
        $this->load->model("Depcias_model");
        $this->load->library('flickr');
    
        $Url="https://api.flickr.com/services/rest/?method=flickr.photosets.getInfo&api_key=13e740bd7cbba0a4ab5401521d3a8399&format=rest&photoset_id=72157688528865622";                
        $Op=1;

        if($Op==1){            
            $Opts=array('http' => array('header' => 'Accept: application/xml', 'timeout'=>10));
            $context  = stream_context_create($Opts);
            $data = file_get_contents($Url, false, $context);            
        }else if($Op==2){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $data = curl_exec($ch);            
            $Info = curl_getinfo($ch);                    
        }
        
        $Xml=simplexml_load_string($data);
        $json = json_encode($Xml);
        $array = json_decode($json, TRUE);        
        print_r($array);        
        
    }

    public function loadView($url, $data = '', $opt = FALSE)
    {
        return $this->load->view($url, $data, $opt);
    }

    public function loadLibraries()
    {
        $this->load->library('load_files');
        $this->load->library('user_agent');
        $this->load->library('consumepu');
        $this->load->library('Noticias_colima_edo');
        $this->load->library('Get_funcionario');
        $this->load->library('Tramites');
        $this->load->library('Breadcrumb');
    }

    public function historial_noticias()
    {
        $str_css = '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">';
        $data['header'] = $this->_get_header($str_css);
        //Indicamos que archivos cargamos en la libreria
        //[1]menu-fixed.js
        $js = array('menu_fixed' => 0);
        $str_js='<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="'.base_url("assets/js/historial.js").'"></script>';
        $data['footer'] = $this->_get_footer($js,$str_js);
        /*Breadcrumb*/    
        //Label //URL //Activo



        $bread[] = array("Portal",base_url('Portal'),"");
        $bread[] = array("Historial de noticias","","active");
        $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
        $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
       
        $this->load->model("historialNot_model");
        $datos['listado'] = $this->historialNot_model->getAll();
        // $datos['total'] = $this->historialNot_model->getTotal();
        
        $data['contenido'] = $this->load->view('vw_HistorialNoticias', $datos, TRUE);
        $this->load->view('layout_detalles', $data);



    }

    public function detalle_historial($id = "")
    {

         if ($id != "") {

            $this->load->model("historialNot_model");
            $this->load->helper("fechas");
            //$response = $this->noticias_colima_edo->get_noticia($id);
            $data['header'] = $this->_get_header();

            $js = array('menu_fixed' => 0);

            $dataJS ='';
            $data['footer'] = $this->_get_footer($js,$dataJS); 
                   
            $contenido = $this->historialNot_model->getbyId(base64_decode($id));
           
            
            foreach ($contenido->cuerpo_cont as $key => $value) {
                $value->id_cont_b64 = base64_encode($value->id_cont);
                $value->dia_publicacion = strtoupper(get_day($value->fecha_publicacion));
                $value->str_mes_publicacion = get_str_month($value->fecha_publicacion);               
            }
            $noticia['noticia'] = (array)$contenido;
            $noticia['otras_noticias'] = (array)$this->_get_noticias_portal()->registros;
            $noticia['redessociales']   = $this->load->view('sec_redes_sociales_link',$this->redes,TRUE);
            
            $data['contenido'] = $this->load->view('detalle_noticias_historial',$noticia,TRUE);
              

            $banner['banner'] = $this->_get_banner_principal();
            /*Breadcrumb*/    
            //Label //URL //Activo
            $bread[] = array("Portal",base_url('Portal'),"");
            //$bread[] = array("Icsic","www.colima.col","");
            $bread[] = array("Listado noticias","","active");
            $breadcrumb['bread'] = $this->breadcrumb->agregar_elemento($bread);
            $data['bread'] = $this->load->view('breadcrumb', $breadcrumb,TRUE);
            $data['atencionc'] = $this->load->view('sec_atencion_ciudadana', "", TRUE);
            $this->load->view('layout_detalles', $data);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    function ajax_historial()
    {

       //$this->load->model("historialNot_model");

        //$db = $this->load->database('colimaedo',TRUE);
        
        $Columnas = array(
            'titulo',
            'fecha_publicacion',            
            'palabras_claves',
            'id_cont'
        );
        $Columns="";
        $ArrColumn=array();
        foreach ($Columnas as $row) {            
            $Columns.="`".$row."`,";            
            array_push($ArrColumn, $row);
        } 
        $Columns = substr($Columns, 0, strlen($Columns) - 1);
        $aColumns = $Columns;       
        
        $sTable = "webcontenidosBlogNoticias";                
                                
        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_POST['start']) && $_POST['length'] != '-1') {
            $sLimit = "LIMIT " . intval($_POST['start']) . ", " .
                    intval($_POST['length']);
        }
        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_POST['order'])) {
            if($_POST['order'][0]['column']!=0){
                $sOrder = "ORDER BY  ";
                $sOrder.= $ArrColumn[$_POST['order'][0]['column']-1]." ".($_POST['order'][0]['dir'] === 'asc' ? 'asc' : 'desc');
            }
            
        }
        $sOrder='ORDER BY fecha_publicacion desc';

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */        
        
        $sWhere = "WHERE id_dpcia=10200 and id_categoria=1 and referencia IS NOT NULL";
        $Search=$this->input->post('search');
        if (isset($_POST['search']) && $_POST['search'] != "") {            
            if($Search['value']!=""){
                
                $sWhere.=" AND ( titulo LIKE '%".$Search['value']."%' )";
               // $sWhere.=" AND ( fecha_publicacion beetwen '".$Search['value']."%' )";

                                                
            }
        }  


        /*
         * SQL queries
         * Get data to display
         */

        /* Data set length after filtering */
        $this->load->database();

        $sQuery = "SELECT FOUND_ROWS() as Registros";
        $Resource=$this->db->query($sQuery);
        $Result=$Resource->row();           
        $iFilteredTotal=$Result->Registros;

        $sQuer = "
            SELECT DISTINCT(id_cont),titulo,fecha_publicacion,palabras_clave
            FROM   $sTable
            $sWhere
            $sOrder
            $sLimit
        ";                         
        //echo $sQuer; die();
        $Resource=$this->db->query($sQuer);
        $Registros=$Resource->result();     

        /* Total data set length */
        $sQuery = "SELECT COUNT(DISTINCT(id_cont)) as Registros FROM $sTable WHERE id_dpcia=10200 and id_categoria=1 and referencia IS NOT NULL";
        $Resource=$this->db->query($sQuery);
        $Result=$Resource->row();    
        $iTotal=$Result->Registros;

        /*
         * Output
         */
        // "sEcho" => intval($_POST['sEcho']),
        if(isset($_POST['sEcho'])){
            $sEcho=intval($_POST['sEcho']);
        }else{
            $sEcho=0;
        }
        $output = array(
            "draw" => $sEcho,
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iTotal,
            "data" => array()
        );
        
        if(count($Registros)>0){
            foreach($Registros as &$row)
            { 
                //print_r($row);
                $Arr = array(
                    '<a style="text-decoration:none;" href="'.base_url('Portal/detalle_historial/').base64_encode($row->id_cont).'" title=""><i  class="fa fa-external-link titlu-rojo-pu"> </i> '.$row->titulo.'</a>',
                $row->fecha_publicacion,
                $row->palabras_clave
                );

                array_push($output['data'],$Arr);
            }
        }        
        echo json_encode($output);



        

    }

    public function rss()
    {
        $this->load->helper('xml');
        $this->load->helper('text');
        
        $data['feed_name'] = 'Gobierno del estado de colima'; // your website
        $data['encoding'] = 'utf-8'; // the encoding
        $data['feed_url'] = 'http://www.col.gob.mx/index.php/Portal/rss'; // the url to your feed
        $data['page_description'] = 'What my site is about comes here'; // some description
        $data['page_language'] = 'en-en'; // the language
        $data['creator_email'] = 'http://www.col.gob.mx/index.php/Portal/rss'; 
        $data['posts'] = $this->consumepu->get_contenido('rssFeed');
        
		header('Content-Type: application/rss+xml; charset=ISO-8859-1');
        
		$rss = $this->load->view('feed/noticiasrss.xml', $data,TRUE);		
		exit($rss);
    }

    protected function _get_avisos() {
		#cambiar segun dependencia
		$cve_dep   = IniRead("general", "id_dep_colima_edo");
		$seccion   = IniRead("general", "sec_avisos");
		$cuantos   = 1;
		$reg_ini   = 0;
		$f_inicial = date('Y-m-d 00:00:00');
		$formato   = "json";
		$orderby   = "fecha_publicacion DESC";
		//$cve_dep:     Clave de la Dependencia
		//$seccion:     # de seccion, 6 para banners
		//$f_inicial:   Fecha a partir de la cual tomara los banners
		//$formato:     Formato del resultado del web service, si no se indica por default queda json
		//$cuantos:     Indica la cantidad de registros que retornara
		//$reg_ini:     Registro inicial
		if (is_null($cve_dep) || is_null($seccion)) {
			return array();
		}
		$parametros = array($cve_dep, $seccion, $f_inicial, $cuantos, $reg_ini, $orderby);

		$response = $this->consumepu->get_contenido(METHOD_LISTADOS, $parametros, $formato);
		return $response;
	}


}
