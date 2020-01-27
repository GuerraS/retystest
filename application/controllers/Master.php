<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Master extends CI_Controller {
	public $id_dependencia;
	private $formato_respuesta;
	private $controlador;
	private $seccionBanner;
	private $seccionDestacados;
	private $cantidadBanner;
	
	private $registro_inicial;
	private $fecha_inicial;

	public function __construct($id_dependencia = ''){ 
		parent::__construct();
		
		$this->id_dependencia = ( ($id_dependencia) != '')  ? $id_dependencia : IniRead("general", "id_dep_colima_edo");
		$this->formato_respuesta = "json";

		$this->controlador = $this->uri->segment(1);				
		$this->cargar_librerias();
	}
	
	public function cargar_librerias()
	{				
		$this->load->library('consumepu');
		$this->load->library('load_files');		
	}
	
	public function _header($id_dependencia, $str_css, $metatags)
	{
		
		$cve_dep = ( ($id_dependencia) != '')  ? $id_dependencia : $this->id_dependencia;
		$this->benchmark->mark('get_header_start');
		$parametros = array('archivos'=> base64_encode($this->archivos($str_css, $metatags)), 'cv_dep' => $cve_dep);
		$response = $this->consumepu->get_contenido(METHOD_HEADER, $parametros, $this->formato_respuesta, TRUE);
		$this->benchmark->mark('get_header_end');
		return $response;
	}

	public function _footer($data, $stringjs = "")
	{	
		$this->benchmark->mark('get_footer_start');
		$data['menu_fixed'] = (count($data['menu_fixed']) == 0) ? 0 : $data['menu_fixed'];
		$scripts = base64_encode($this->load_files->load_js($data, $this->controlador, $stringjs));
		
		$parametros = array('cv_dep' => IniRead("general", "id_dep_footer") , 'scripts' => $scripts, 'jquery' => 1, 'bootstrap' => 4);
        $response = $this->consumepu->get_contenido(METHOD_FOOTER, $parametros, $this->formato_respuesta, TRUE);
		$this->benchmark->mark('get_footer_end');

		return $response;
	}

	private function getUrl(){
        $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $currentURL .= $_SERVER["SERVER_NAME"];  
        
        if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443"){
            $currentURL .= ":".$_SERVER["SERVER_PORT"];
        } 
        
        // $currentURL= URL_WWWCOLIMAEDO;
        return $currentURL;
    }

    public function archivos($str_css = '', $metatags = '')
    {
    	$this->load->library('Load_files');
    	$archivos ="";
		if ($metatags == '') {
			$metatags = '<Link rel = "canonical" href = "'.site_url($this->uri->uri_string()).'"/>';
			$metatags .= '<meta property="og:url" 	 content="'.$this->getUrl().'" />';
			$metatags .= '<meta property="og:type"  content="website" />';
			$metatags .= '<meta property="og:title" content="Gobierno del estado de colima" />';
			$metatags .= '<meta property="og:description" content="Gobierno del estado de colima" />';
			$metatags .= '<meta property="og:image" content="'.URL_IMG_ESCUDO.'" />';
			$archivos .= $metatags;
		}
		$archivos .= $metatags;
        $archivos.= $this->load_files->load_css($str_css);
        $archivos.= '<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=59cd2679fdc69400125962c9&product=inline-share-buttons"></script>';
		return $archivos;
	}
	
	public function _banner_principal($id_dep=0)
	{
		$this->benchmark->mark('banner_principal_start');
		$this->seccionBanner = IniRead("general", "sec_banner_p");
		$this->cantidadBanner = IniRead("general", "num_banners_p");
		$this->registro_inicial = IniRead("general", "banner_inicial_p");
		$this->fecha_inicial = date('Y-m-d 00:00:00', strtotime("-2 year"));
		$id_dependencia =  (isset($id_dep) && $id_dep > 0) ? $id_dep : $this->id_dependencia; 
		
		$parametros = array($id_dependencia, $this->seccionBanner, $this->fecha_inicial, $this->cantidadBanner, $this->registro_inicial, 'fecha_publicacion DESC');
		$response = $this->consumepu->get_contenido(METHOD_CONTENIDOS, $parametros, $this->formato_respuesta);
			
		$this->benchmark->mark('banner_principal_end');

		return $response;
	}


	public function _get_destacados($registro_inicial, $fecha_inicial, $cve_dep)
	{
		$this->benchmark->mark('get_destacados_start');
	
        // $cve_dep   = IniRead("general", "id_dep_colima_edo");
        $this->seccionDestacados   = IniRead("general", "sec_destacado");
        $cantidadDestacados   = IniRead("general", "num_destacados");
        $registro_inicial   = isset($registro_inicial) ? IniRead("general", "destacado_inicial") : $registro_inicial;
        $fecha_inicial = isset($fecha_inicial) ? IniRead("general", "fecha_ini_destacado") : $fecha_inicial0; //IniRead("general", "fecha_ini_destacado");
        $destacados_orderby = "fecha_publicacion DESC";
		$id_dependencia = (!empty($cve_dep)) ? $cve_dep : $this->id_dependencia;			
		$parametros = array($id_dependencia, $this->seccionDestacados, $fecha_inicial, $cantidadDestacados, $registro_inicial, $destacados_orderby);
		$response   = $this->consumepu->get_contenido(METHOD_CONTENIDOS, $parametros, $this->formato_respuesta);
		if (is_array($response) && count($response) > 0 && !isset($response['msg'])) {
            
        
            foreach ($response->registros as $oDestacado) {
                
                $archivos = (array) $oDestacado->archivos;

                foreach ($archivos as $key => $archivo) {
                    if (!is_numeric($key)) {
                        $oDestacado->$key = $archivo;
                        unset($archivos[$key]);
                    }
                }

                $oDestacado->archivos = array_values($archivos);
            }
		}
		
		$this->benchmark->mark('get_destacados_end');
		
		return $response;
	}

	public function _get_programas($cve_dep)
	{
		$seccion = IniRead("general", "sec_programas");
		$cuantos = 7;
		$reg_ini = 0;
		$f_inicial = date('Y-m-d 00:00:00', strtotime("-2 year"));
		$orderby   = "RAND";
		$cve_dep = isset($cve_dep) ? $cve_dep  : $this->id_dependencia;
		

		$parametros = array($cve_dep, $seccion, $f_inicial, $cuantos, $reg_ini, $orderby);
		$response = $this->consumepu->get_contenido(METHOD_CONTENIDOS, $parametros, $this->formato_respuesta);
		
		if (isset($response->registros) && count($response->registros) > 0) {
			foreach ($response->registros as $key => $value) {
				
				if (isset($value->descripcion) && strlen($value->descripcion) > 0) {
						$url = $value->descripcion;
						$target = '_blank';
						$js = 'onclick=SaliendoPortal();';
					}else{
						$url = base_url($this->session->dependenceInfo['shortname'].'/detalle_programa/').base64_encode($value->id_cont);
						$target = '_self';
						$js="";
					}	

				$value->ruta_contenido =  $url;
				$value->target_contenido =  $target;
				$value->js_contenido =  $js;
			}
			
			return $response;
		}else{
			return array();
		}


		
	}

	public function getArchivos($arrArchivo) {

		if (isset($arrArchivo) || isset($arrArchivo->registros)) {
			
			$ArrArchivos = array();
			foreach ($arrArchivo->registros as $key => $archivo) {
				//$obj               = new \stdClass;
				$archivo->id_archivo   = $archivo->id_archivo;
				$archivo->id_contenido = $archivo->id_contenido;
				$archivo->nom_archivo  = $archivo->nom_archivo;

				$patron = "%\.(jpe?g|png)$%i"; 
				// Ejemplo de visualización del resultado 
				if ( preg_match($patron, $archivo->nom_archivo)) 
				{
					$archivo->id_file_encoded = base64_encode($archivo->id_archivo);
					$archivo->url_image       = URLCOLIMAEDO.'imagenv2.php?x='.base64_encode($archivo->id_archivo).'&amp;y=23&amp;z=1';
					array_push($ArrArchivos, $archivo);

				}
				
			}

			return $ArrArchivos;
		}

	}

	public function _obtener_imagenes($arrArchivo)
    {
        if (isset($arrArchivo) || isset($arrArchivo->registros)) {
           foreach ($arrArchivo->registros as $key => $archivo) {
                $obj = new \stdClass;
                $obj->id_archivo = $archivo->id_archivo;
                $obj->id_contenido = $archivo->id_contenido;
                $obj->nom_archivo = $archivo->nom_archivo;
                if((substr($archivo->nom_archivo, -3) == 'jpg')||(substr($archivo->nom_archivo, -4) == 'jpeg')){
                    $obj->id_file_encoded = base64_encode($archivo->id_archivo);
                    $obj->url_image = URLCOLIMAEDO.'imagenv2.php?x='.base64_encode($archivo->id_archivo).'&amp;y=23&amp;z=1';

                } 
               
                return $obj;
           }
        }
    }

	public function agregar_contenido_response($data)
	{
		
		$slider = array();
		if (isset($data) || count($data->registros) > 0 ) {
			foreach ($data->registros as $key => $contenido) {
				$obj = new \stdClass;
				$obj->urlserver = URL_IMAGENES;
				$limpia = str_replace("<p>", "", $contenido->cuerpo_cont);
				$obj->imagen = str_replace("</p>", "", $limpia);
				$obj->cuerpo_cont = $limpia;
								
				$obj->archivos = $this->_obtener_imagenes($contenido->archivos);
				array_push($slider, $obj);
			}
		}
		
		return $slider;
	}

	protected function _get_campanas() {
        $this->benchmark->mark('get_campanas_start');
        $seccion_campanas   = IniRead("general", "sec_campanas");
        $cantidad_campanas   = IniRead("general", "num_destacados");
        $registro_inicial   = IniRead("general", "destacado_inicial");
        $fecha_inicial = IniRead("general", "fecha_ini_destacado");
        //$id_destacados = IniRead("general","id_dep_destacados");
        $campanas_orderby = "RAND";
        //$cve_dep:     Clave de la Dependencia
        //$seccion_campanas:     # de seccion_campanas, 1 para destacados
        //$fecha_inicial:   Fecha a partir de la cual tomara los destacados
        //$cantidad_campanas:     Indica la cantidad de registros que retornara
        //$registro_inicial:     Registro inicial

        $parametros = array($this->id_dependencia, $seccion_campanas, $fecha_inicial, $cantidad_campanas, $registro_inicial, $campanas_orderby);        
        $response   = $this->consumepu->get_contenido(METHOD_CONTENIDOS, $parametros, $this->formato_respuesta);
      
        if (is_array($response) && count($response) > 0 && !isset($response['msg'])) {
            
        
            foreach ($response->registros as $oDestacado) {
                
                $archivos = (array) $oDestacado->archivos;

                foreach ($archivos as $key => $archivo) {
                    if (!is_numeric($key)) {
                        $oDestacado->$key = $archivo;
                        unset($archivos[$key]);
                    }
                }

                $oDestacado->archivos = array_values($archivos);
            }
        }
      
        $this->benchmark->mark('get_campanas_end');
        
        return $response;
	}

	protected function _getws_contenidos($id_cont, $cve_dep)
	{
		
		if (is_null($id_cont)) {
			return array("msg" => "ID de contenido obligatorio");
		}
		
		$id_dep = isset($cve_dep) ? $cve_dep : $this->id_dependencia;
		$parametros = array($id_dep, base64_decode($id_cont));

		return $this->consumepu->get_contenido(METHOD_CONTENIDO, $parametros, $this->formato);	
		
	}

	public function tramites($idAds)
    {
		if($idAds){
			$url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramites/format/json?idAds=".$idAds;
			return $this->consumepu->_get_ws($url);
		}else{
			return array();
		}
               
    }

	
	

}

/* End of file Master.php */
/* Location: ./application/controllers/Servicio/Master.php */