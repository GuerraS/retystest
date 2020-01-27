<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tramites {

    protected $ci;

    public function __construct() {
        $this->ci = & get_instance();
    }

    public function  getTotalTramites(){
        try {            
            $url = URL_WS_TRAMITESLINEA."getTotalTramites/format/json";
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTotalTramites"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);            
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTotalTramites");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }
        return json_decode($response);
    }

    public function get_tramites() {
        try {            
            $this->ci->benchmark->mark('get_tramites_start');        
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramitesMasVisitados/format/xml";

        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "get_tramites"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
                        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_get_tramites");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }    
        $this->ci->benchmark->mark('get_tramites_end');
        
        return json_decode($response);
    }

    public function get_tramite($id = "") {
        try { 
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramite/format/xml?idTramite=" . $id;
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "get_tramite"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_get_tramite");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }  
        return json_decode($response);
    }

    public function getCategorias(){
        try { 
            $url = URL_WS_TRAMITESLINEA."getCategorias/format/json";
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getCategorias"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);
            }   
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getCategorias");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }      
        return json_decode($response);
    }
    
    public function getCategoria($Id){
        try { 
            $url = URL_WS_TRAMITESLINEA."getCategoria/".$Id."/format/json";
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getCategoria"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getCategoria");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    }
    
    public function getTramiteLinea($Id){
        try { 
            $url = URL_WS_TRAMITESLINEA."getTramite/".$Id."/format/json";
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTramiteLinea"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTramiteLinea");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }        
        return json_decode($response);
    }
    
    public function getDependencias(){
        try {
            $url = URL_WS_TRAMITESLINEA."getDependencias/format/json";
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getDependencias"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getDependencias");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    }
    
    public function getTramitesDependencia($Id){
        try {
            $url = URL_WS_TRAMITESLINEA."getTramitesDependencia/".$Id."/format/json";
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTramitesDependencia"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTramitesDependencia");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }       
        return json_decode($response);
    }
    
    public function getDependenciasRetys(){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getDependencias/format/xml";
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getDependenciasRetys"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getDependenciasRetys");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }      
        return json_decode($response);
    }
    
    public function getTramitesDependenciaRetys($IdAds){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramites/format/xml?idAds=".$IdAds;
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTramitesDependenciaRetys"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTramitesDependenciaRetys");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }      
        return json_decode($response);
    }

    public function getTotalTramitesRetys(){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTotalTramites/format/json";
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTotalTramitesRetys"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);    
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTotalTramitesRetys");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }    
        return json_decode($response);
    }
    
    public function getTramiteReTYS($IdTramite){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramite/format/xml?idTramite=".$IdTramite;        
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTramiteReTYS"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_TIMEOUT,60);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTramiteReTYS");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    }
    
    public function getTramiteReTYS_Short($IdTramite){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramiteShort/format/xml?idTramite=".$IdTramite;        
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTramiteReTYS_Short"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_TIMEOUT,60);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTramiteReTYS_Short");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    }
    
    public function getDependenciaReTYS($IdAds){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getDependencia/format/xml?IdAds=".$IdAds;        
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getDependenciaReTYS"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getDependenciaReTYS");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    }

    public function busquedaTramite($parametro)
    {
        try {                
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getBusqueda/format/json?param=".$parametro;                           
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "busquedaTramite"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);            
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }                        
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_busquedaTramite");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    } 
    
    public function busquedaTramite2($param) {
        try { 
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/";     
            
        //Inicio - Sección de cacheo [ OBTENER ]
            //$hash = $this->ci->pucache->getCacheHash(array($url, "busquedaTramite2"));
            //$cacheData = $this->ci->pucache->getByKey($hash);
            //// if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ci =& get_instance();
            $ci->load->library('rest2');
            $config = array('server' => $url);
            $ci->rest2->format('application/json');
            $ci->rest2->initialize($config);
            $response = $ci->rest2->get('retys/getBusqueda',array('param'=>$param));
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            //$this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_busquedaTramite2");
        //Fin - Sección de cacheo
            
        //$ci->rest2->debug();
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }      
        return json_decode($response);
    }

    public function getTramiteRetys_ABC($param){
        try {                            
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramitesABC/format/json?Letra=".$param['Letra'];                                       
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "busquedaTramite"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);            
            
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }                        
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_ABC");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    }

    public function getCategoriasRetys(){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getCategorias/format/xml";
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getCategoriasRetys"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getCategoriasRetys");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }      
        return json_decode($response);
    }

    public function getTipoUsuariosRetys(){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTipoUsuarios/format/xml";    
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTipoUsuariosRetys"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTipoUsuariosRetys");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }      
        return json_decode($response);
    }

    public function getTramitesCategoriaRetys($param){
        try { 
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/";     
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "TramiteCategoria_$param"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            $ci =& get_instance();
            $ci->load->library('rest2');
            $config = array('server' => $url);
            $ci->rest2->format('application/json');
            $ci->rest2->initialize($config);
            $response = $ci->rest2->get('retys/getTramitesCategoria',array('idCategoria'=>$param));
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_TramiteCategoria_$param");
        //Fin - Sección de cacheo
            
        //$ci->rest2->debug();
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }      
        return json_decode($response);
    }

    public function getTramitesTipoUsuarioRetys($param){
        try { 
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/";     
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "TramiteTipoUsuario_$param"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ci =& get_instance();
            $ci->load->library('rest2');
            $config = array('server' => $url);
            $ci->rest2->format('application/json');
            $ci->rest2->initialize($config);
            $response = $ci->rest2->get('retys/getTramitesTipoUsuario',array('idTipoUsuario'=>$param));
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_TramiteTipoUsuario_$param");
        //Fin - Sección de cacheo
            
        //$ci->rest2->debug();
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }      
        return json_decode($response);
    }

    public function getCategoriaRetys($param){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getCategoria/format/xml?id=".$param;                    
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getCategoriaReTYS"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getCategoriaReTYS");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    }

    public function getTipoUsuarioRetys($param){
        try {
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTipoUsuario/format/xml?id=".$param;        
            
        //Inicio - Sección de cacheo [ OBTENER ]
            $hash = $this->ci->pucache->getCacheHash(array($url, "getTipoUsuarioReTYS"));
            $cacheData = $this->ci->pucache->getByKey($hash);
            // if ($cacheData) return $cacheData;
        //Fin - Sección de cacheo
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            
        //Inicio - Sección de cacheo [ ESCRIBIR ]        
            $this->ci->pucache->setByKey($hash,json_decode($response),"Tramites_getTipoUsuarioReTYS");
        //Fin - Sección de cacheo
            
        }catch (Exception $exc) {
            $this->ci->apiwslog->log($exc);
        }     
        return json_decode($response);
    }
    
}

/* End of file tramites.php */
/* Location: ./application/libraries/tramites.php */
