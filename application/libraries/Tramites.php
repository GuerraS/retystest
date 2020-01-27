<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tramites {

    protected $ci;

    public function __construct() {
        
    }
//Se obtiene el total de tramites en linea
    public function  getTotalTramitesLinea(){
        try {            
            $url = URL_WS_TRAMITESLINEA."getTotalTramites/format/json";
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
        }catch (Exception $exc) {
            //$this->ci->apiwslog->log($exc);
        }
        $array = json_decode($response, TRUE);
        //  echo $rest=($array["Tramites"]);
        return $rest=($array["Tramites"]);
    }
    

//Se obtiene el total de tramites presenciales
    public function  getTotalTramitesPresenciales(){
        try {            
            $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTotalTramites/format/json";
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
        }catch (Exception $exc) {
            //$this->ci->apiwslog->log($exc);
        }
        $array = json_decode($response, TRUE);
        //  echo $rest=($array["Tramites"]);
        return $rest=($array["Tramites"]);
    }
        public function categoriasLinea()
        {
            try {         
            $url = URL_WS_TRAMITESLINEA."getCategorias/format/json";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            //Convertir JSON a array para extraer todas las categorias y su id posteriormente
            $array_categoriasLinea_partes = json_decode($response, true);
            //print_r($array_categoriasLinea_partes);
            //Id de la priemra categoria
            curl_close($ch);
            //For para agregar tamites por categoria en linea, se agrega el campo tramites al array que arroja del ws 
            //
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            $array_final= array();
            foreach($array_categoriasLinea_partes as $val)
            {
                $tramites= $this->getTramitesCategoriaLineaId($val['id']);
                $roo= array('id'=>$val['id'], 'descripcion'=>$val['descripcion'],'tramites'=>$tramites);
                array_push($array_final, $roo);
                
            }
        }catch (Exception $e) {
            echo $e->getMessage();
                die();
        }   
            //echo '<pre>'; print_r($array_final); die();
            return $array_final;
        }
        public function getTramitesCategoriaLineaId($Id)
        {   
            //print_r($Id);                
            $url = URL_WS_TRAMITESLINEA."getCategoria/".$Id."/format/json";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $result = json_decode($response); 
            //$TramiteCategoriaLinea=array();
            //$TramiteCategoriaLinea[$i]=$Id[$i]->descripcion;              
            curl_close($ch);
            $result= json_decode(json_encode($result), true);
            return $result;
        }
        public function getTramitesLineaId($Id)
        { 
            //print_r($Id);                
            $url = URL_WS_TRAMITESLINEA."getTramite/".$Id."/format/json";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            $response = curl_exec($ch);
            if ($response=='') {
                throw new Exception("Error en Webservice de ReTYS", 1);            
            }
            $error = curl_error($ch);
            $result = json_decode($response); 
            //$TramiteCategoriaLinea=array();
            //$TramiteCategoriaLinea[$i]=$Id[$i]->descripcion;              
            curl_close($ch);
            
            return $result;
        }
        public function getDependencias(){
            try {
                $url = URL_WS_TRAMITESLINEA."getDependencias/format/json";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);  
                $array_dependencia = json_decode($response, true);
                $array_final= array();
                if ($response=='') {
                    throw new Exception("Error en Webservice de ReTYS", 1);            
                }
                foreach($array_dependencia as $val)
                    {
                        $tramites= $this->getTramitesDependencia($val['id_dependencia']);
                        $roo= array('id'=>$val['id_dependencia'], 'descripcion'=>$val['nombre_dependencia'],'tramites'=>$tramites);
                        array_push($array_final, $roo);  
                        
                    } 
                }catch (Exception $e) {
                    echo $e->getMessage();
                        die();
                }      
            return $array_final;
        }
        public function getTramitesDependencia($Id){
            try {
                $url = URL_WS_TRAMITESLINEA."getTramitesDependencia/".$Id."/format/json";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);   
            }catch (Exception $e) {
                echo $e->getMessage();
                    die();
            }    
            $result= json_decode(($response), true);
            
            return $result;
        }
        
        public function getTramiteReTYS($IdTramite){
            try {
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramite/format/xml?idTramite=".$IdTramite;         
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
            //Fin - Sección de cacheo
                
            }catch (Exception $e) {
                echo $e->getMessage();
                    die();
            }     
            return json_decode($response);
        }
        public function getDependenciasRetys(){
            try {
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getDependencias/format/xml";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                if ($response==''){
                    throw new Exception("Error en Webservice de ReTYSbbbb", 1);            
                }   
                $array_dependencia = json_decode($response, true);
                $array_final= array();
                foreach($array_dependencia as $val)
                    {
                        $tramites= $this->getTramitesDependenciaRetys($val['Id_Ads']);     
                        $roo = array('Id_Ads'=>$val['Id_Ads'], 'descripcion'=>$val['Descrip'],'tramites'=>$tramites);
                        array_push($array_final, $roo);  
                    } 
                
                }catch (Exception $e) {
                    echo $e->getMessage();
                        die();
                }       
            return $array_final;
        }
        public function getUsuariosRetys(){
            try {
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTipoUsuarios/format/xml";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                if ($response==''){
                    throw new Exception("Error en Webservice de ReTYS", 1);            
                }   
                $array_usuario = json_decode($response, true);
                $array_final= array();
                foreach($array_usuario as $val)
                    {
                        $tramites= $this->getTramitesTipoUsuarioRetys($val['Id_Tipo_Usuario']);     
                        $roo = array('Id_Ads'=>$val['Id_Tipo_Usuario'], 'descripcion'=>$val['Descrip'],'tramites'=>$tramites);
                        array_push($array_final, $roo);  
                        
                    } 
                }catch (Exception $e) {
                    echo $e->getMessage();
                        die();
                }        
            return $array_final;
        }
        public function getTramitesTipoUsuarioRetys($param){
            try {
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramitesTipoUsuario/format/xml?idTipoUsuario=".$param;
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
            }catch (Exception $e) {
                echo $e->getMessage();
                    die();
            }      
            return json_decode($response);
        }
             
        public function getTramitesDependenciaRetys($IdAds){
            try {
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramites/format/xml?idAds=".$IdAds;
            
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                if ($response=='') {
                    throw new Exception("Error en Webservice de ReTYSasdasd", 1);            
                }    
            }catch (Exception $e) {
                echo $e->getMessage();
                    die();
            }      
            return json_decode($response);
        }
        public function getCategoriasRetys(){
            try {
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getCategorias/format/xml";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                if ($response==''){
                    throw new Exception("Error en Webservice de ReTYS", 1);            
                }   
                $array_categoria = json_decode($response, true);
                $array_final= array();
                foreach($array_categoria as $val)
                    {
                        $id=$val['Id_TemaCategoria'];
                        $tramites= $this->getTramitesCategoriaRetys($id);
                        $roo = array('Id_Ads'=>$id, 'descripcion'=>$val['Descrip'],'tramites'=>$tramites);
                        array_push($array_final, $roo);  
                    }
                }catch (Exception $e) {
                    echo $e->getMessage();
                        die();
                }       
            return $array_final;
        } 
        public function getTramitesCategoriaRetys($IdAds){
            try {
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getTramitesCategoria/format/xml?idCategoria=".$IdAds;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                if ($response=='') {
                    throw new Exception("Error en Webservice de ReTYSasdasd", 1);            
                }    
            }catch (Exception $e) {
                echo $e->getMessage();
                    die();
            }      
            return json_decode($response);
        }
        public function busquedaTramite($parametro)
        {
            try {                
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/retys/getBusqueda/format/json?param=".$parametro;                                   
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
            }catch (Exception $e) {
                echo $e->getMessage();
                    die();
            }     
            return json_decode($response);
        }
        public function busquedaTramite2($param) {
            try { 
                $url = "http://www.tramitesyservicios.col.gob.mx/retys_rest/index.php/";     

                $ci =& get_instance();
                $ci->load->library('rest2');
                $config = array('server' => $url);
                $ci->rest2->format('application/json');
                $ci->rest2->initialize($config);
                $response = $ci->rest2->get('retys/getBusqueda',array('param'=>$param));
            
            }catch (Exception $exc) {
                $this->ci->apiwslog->log($exc);
            }      
            return json_decode($response);
        }     
}

/* End of file tramites.php */
/* Location: ./application/libraries/tramites.php */
