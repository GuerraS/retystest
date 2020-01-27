<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Breadcrumb
{
	protected $ci;
	public function __construct()
	{
        $this->ci   =& get_instance();
        $this->home = base_url();
        $this->breadcrumb = array(); 
	}
	public function agregar_elemento($parametros = array())
	{	
		if (isset($parametros)){
			$imgSrc =  "http://www.col.gob.mx/assets/img/escudo_breadcrum.png";
			$out ="";
			$out .= "<li class='breadcrumb-item'><a class='breadcrumb' href='".site_url()."' title='".GOBIERNO_ESTADO_COLIMA."'>";
			$out .= "<img class='bread-pbc' src='".$imgSrc."' alt='Gobierno colima'>";
			$out .= COL_GOB_BREADCRUM."</a></li>";
		 	foreach ($parametros as $key => $value) {
		 	$out .= "<li class='breditem-pt2 breadcrumb-item ".$value[2]."'><a  href='".$value[1]."' title=''>".$value[0]."</a></li>";
		 	}
		 	return $this->salida($out);
		}
		else{
		 	return array("msg"=>"Breadcrumb sin parametros");
		}
	}
	public function salida($elementos)
	{	
		$output = "<ol class='breadcrumb pull-right'>";
		$output .= $elementos;
		$output .= "</ol>";
		return $output;
	}

}

/* End of file breadcrumb.php */
/* Location: ./application/libraries/breadcrumb.php */
