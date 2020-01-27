<?php echo $header?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="canonical" href="http://www.col.gob.mx/Portal/Tramites">
	<meta property="og:url" content="http://www.col.gob.mx">
	<meta property="og:type" content="website">
	<meta property="og:title" content="Gobierno del estado de colima">
	<meta property="og:description" content="Gobierno del estado de colima">
  <meta property="og:image" content="http://www.col.gob.mx/assets/img/escudo.png">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">

  <link rel="stylesheet" type="text/css" href="http://www.col.gob.mx/assets/css/customcss.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-121812210-1"></script>

<div  class="container-fluid">
  <div id="myToolbar"class="sidenav col-4 col-sm-4 col-md-4 col-lg-3 col-xl-3">
  <a href="javascript:void(0)" class="closebtn" id="closeTool" >&times;</a>
      <div class="row">
        <div class="col-2 col-sm-2 col-md-2 col-lg-2">
          <h5>Ajustes de Accesibilidad</h5>
        </div>   
      </div>
      <br>
      <div class="content">
        <div class="contenido col-sm" >
          <h5><span>Contenido</span></h5>
            <div class=" row align-items-start ajustes-div">
              <div class="btn-light  col-4 col-sm-12 col-md-4 col-lg-4 " id="btn-decrease" role="button">
                <span id="fuente">Aa-</span>
              </div>
              <div class="btn-light col-4 col-sm-12 col-md-4 col-lg-4 " id="btn-origin" role="button">
                <span id="fuente">Aa</span>
              </div>
              <div class="btn-light col-4 col-sm-12 col-md-4 col-lg-4 " id="btn-increase" role="button">
                <span id="fuente">Aa+</span>
              </div> 
            </div>
          <div class="row align-items-start ajustes-div">
            <div class="btn-light btn-subrayar col-sm-12 col-md-6 col-lg-6 " id="ajuste-1" role="button">
              <span id="ajuste">Subrayar texto</span>
            </div>  
            <div class="btn-light legible col-sm-12 col-md-6 col-lg-6 " id="ajuste-2" role="button">
              <span id="ajuste">Fuente legible</span>
            </div>
          </div>
        </div> 
        <div class="color-display col-12"> 
          <h5><span>Color y display</span></h5>
            <div class="row align-items-end ajustes-div">
              <div class="change-contrast btn-light col-sm-12 col-md-6 col-lg-6" id="ajuste-3" role="button">
                <span id="ajuste">Contraste Alto</span>
              </div>
              <div class="invert-color btn-light col-sm-12 col-md-6 col-lg-6" id="ajuste-4" role="button">
                <span id="ajuste">Invertir Colores</span>
              </div>
            </div>
            <div class="row align-items-end ajustes-div">
              <div class="btn-light col-sm-12 col-md-6 col-lg-6" id="ajuste-3" role="button">
                <span id="ajuste">Saturación Alta</span>
              </div>
              <div class="btn-enfatizar btn-light col-sm-12 col-md-6 col-lg-6" id="ajuste-4" role="button">
                <span id="ajuste">Enfatizar</span>
              </div>
            </div>

        </div>     
      </div>  
  </div>
</div>
<main class="inner-page interior ficha">
  <br>
  <div class="container no-padding-pu border-separador">
            <div  class="row">
                <div class="col-12"><?php echo $bread ?></div>
            </div>
  </div>
    <div class="container" id="sec_atencion">
        <div class="hidden-xs font-changer internal print" id="accesibility-content" style="z-index:100">
			<button class="font-modifier" tittle="Boton para abrir barra de herramientas accesibles" id="openToolbar"><span class="fa fa-universal-access fa-3x" aria-hidden="true"></span></button>
        </div>
        <br>
        <br>
        <div class="row">
            <h1>Trámites</h1>
            <div class="col-12 separador-secciones-dark-2-pu"></div>
			<span class="col-1 separador-secciones-dark-1-pu"></span>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 text-justify">
                <div class="row" id="divleyenda">
                    <p id="leyenda">
                        El Registro Estatal de Trámites y Servicios (RETyS) es 
                        el sistema electrónico que contiene la información de los 
                        trámites y servicios de las dependencias y entidades de la 
                        administración pública estatal. Las dependencias no podrán 
                        aplicar trámites o servicios adicionales a los establecidos 
                        en este registro, ni podrán exigir requisitos adicionales en 
                        forma distinta a como se inscriben. La legalidad y el contenido 
                        de la información que inscriben las dependencias en el registro 
                        son de su estricta responsabilidad.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6"></div>
        </div>
    </div>
</main> 
<?php echo $footer?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/accesibilidad.js"></script>

