<?php echo $header?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="canonical" href="http://www.col.gob.mx/Portal/Tramites">
	<meta property="og:url" content="http://www.col.gob.mx">
	<meta property="og:type" content="website">
	<meta property="og:title" content="Gobierno del estado de colima">
	<meta property="og:description" content="Gobierno del estado de colima">
  <meta property="og:image" content="http://www.col.gob.mx/assets/img/escudo.png">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/barra-herramientas.css">

  <link rel="stylesheet" type="text/css" href="http://www.col.gob.mx/assets/css/customcss.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-121812210-1"></script>

<div class="container-fluid" >
<div id="myToolbar"class="sidenav col-7 col-sm-7 col-md-4 col-lg-3 p-0">
        <div class="Trazado-6 ">
            <button class="closebtn" aria-label="Cerrar barra de herramientas accesibles" title="Cerrar barra de herramientas accesibles" id="closeTool">
              X
            </button>
        </div>
        <div class=" col-sm-12 col-md-12 ">
            <span class="ajuestes-de-accesibilidad-titulo"> 
                Ajustes de Accesibilidad
            </span>
        </div>
        <!-- Ajustes de texto  -->
        <div class="seccion-contenido col-12">                
            <div class="ajustes-contenido-titulo">   
                    <span title="Contenido">Contenido</span>               
            </div>
          <div class="row align-items-start ajustes-tamaño-fuente-titulo" >
            <div class="col-9 tamaño-fuente-titulo"   >
              <div class="col-sm-2 col-md-2 col-lg-2  fuente-imagen"><img class="img-responsive img1" src="<?php echo base_url()?>assets/icons/ICONOS-14@2x.png" alt="Icono de tamaño de fuentes"> </div>
              <div class="col-sm-10 col-md-10 col-lg-10  fuente-texto" title="Tamaño de texto"><span>Tamaño de texto</span></div>
            </div> 
          </div>
          <div class="row align-items-start "> 
            <div class="col-sm-4 col-md-4  pl-2 pr-2 ">
              <button class="btn-light1 col-12" aria-label="AUmentar tamaño de fuente" id="btn-decrease"><span>Aa-</span></button>
            </div>
            <div  class="col-sm-4 col-md-4 pl-2 pr-2 ">
              <button class="btn-light1 col-12" aria-label="Tamaño de fuente original" id="btn-origin"><span>Aa</span></button>
            </div>
            <div  class="col-sm-4 col-md-4 pl-2 pr-2 ">
              <button class="btn-light1 col-12" aria-label="Reducir tamaño de fuente" id="btn-increase"><span>Aa+</span></button>
            </div>
          </div>
          <div class="row align-items-start ">
            <div class="col-sm-6 col-md-6 pl-2 pr-2  ">
              <button class="btn-light2 btn-subrayar col-12" aria-label="Subrayar texto" ><span><u>Subrayar texto</u></span></button>
            </div>
            <div  class="col-sm-6 col-md-6 pl-2 pr-2 ">
              <button class="btn-light2 btn-legible col-12" aria-label="Fuente legible"><span><b>Fuente legible</b> </span></button> 
            </div>
          </div>         
        </div>

        <!-- Ajustes de Color y pantalla  -->
        <div class="seccion-color-pantalla col-12">                
          <div class="ajustes-color-pantalla-titulo">   
                  <span title="color-pantalla">Color y pantalla</span>               
          </div>        
          <div class="row align-items-start ">
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2 ">
              <button class="btn-light3 invertir-color col-12"  aria-label="Invertir colores de pantalla">
                <div>
                  <img class="img-responsive img2" src="<?php echo base_url()?>assets/icons/ICONOS_Mesa_de_trabajo_1@2x.png" alt="">
                </div>
                <div>
                  <span>Invertir colores</span>
                </div>
              </button>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4  pl-2 pr-2  ">
              <button class="btn-light3 contraste-alto col-12" aria-label="Contraste alto para pantalla">
                <div>
                  <img class="img-responsive img3" src="<?php echo base_url()?>assets/icons/ICONOS-02@2x.png" alt="">
                </div>
                <div>
                  <span>Alto contraste</span>
                </div>
              </button>
            </div>
            <div  class="col-12 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2 ">
              <button class="btn-light3 btn-enfatizar col-12 " aria-label="Enfatizar textos de pantalla">
                <div>
                  <img class="img-responsive img4" src="<?php echo base_url()?>assets/icons/ICONOS-03@2x.png" alt="">
                </div>
                <div>
                  <span>Enfatizar texto</span>
                </div>
              </button> 
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2  ">
              <button class="btn-light3 btn-contraste-oscuro col-12 "aria-label="Contraste oscuro de pantalla">
                <div>
                  <img class="img-responsive img5" src="<?php echo base_url()?>assets/icons/ICONOS-04@2x.png" alt="">
                </div>
                <div>
                  <span>Contraste oscuro</span>
                </div>
              </button>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2  ">
              <button class="btn-light3 btn-monocromo col-12 " aria-label="Cambiar a modo monocromo">
                <div>
                  <img class="img-responsive img6" src="<?php echo base_url()?>assets/icons/ICONOS-05@2x.png" alt="">
                </div>
                <div class="hyphenation">
                  <span>Monocromatico</span>
                </div>
              </button>
            </div>
            <div  class="col-12 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2 ">
              <button class="btn-light3 btn-contraste-luz col-12 "aria-label="Contraste claro de pantalla">
                <div>
                  <img class="img-responsive img7" src="<?php echo base_url()?>assets/icons/ICONOS-06@2x.png" alt="">
                </div>
                <div>
                  <span>Contraste de luz</span>
                </div>
              </button>
            </div>
          </div>         
        </div>
        <!-- Ajustes de navegación  -->
        <div class="seccion-ajustes-navegacion col-12">                
            <div class="ajustes-navegacion-titulo">   
                    <span title="Contenido">Ajustes de navegación</span>               
            </div>
            <div class="row align-items-start ">
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2  ">
              <button class="btn-light3 btn-cursor-negro-grande col-12 "aria-label="Aumentar tamaño de puntero y color negro" >
                <div>
                  <img class="img-responsive img11" src="<?php echo base_url()?>assets/icons/ICONOS-10@2x.png" alt="">
                </div>
                <div>
                  <span>Cursor negro grande</span>
                </div>
              </button>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2  ">
              <button class="btn-light3 btn-cursor-blanco-grande col-12 " aria-label="Aumentar tamaño de puntero y color blanco">
                <div>
                  <img class="img-responsive img12" src="<?php echo base_url()?>assets/icons/ICONOS-11@2x.png" alt="">
                </div>
                <div >
                  <span >Cursor blanco grande</span>
                </div>
              </button>
            </div>
            <div  class="col-12 col-sm-6 col-md-6 col-lg-4 pl-2 pr-2">
              <button class="btn-light3 col-12 enfatizar-al-pasar-cursor "aria-label="Enfatizar texto al pasar cursor y resaltar">
                <div>
                  <img class="img-responsive img13" src="<?php echo base_url()?>assets/icons/ICONOS-12@2x.png" alt="">
                </div>
                <div>
                  <span>Enfatizar al pasar cursor</span>
                </div>
              </button>
            </div>
            <div  class="col-12 col-sm-6 col-md-6 col-lg-12 pl-12 pr-2">
              <button class="btn-light3 col-12 btn-restablecer-ajustes"aria-label="Restablecer a ajustes predeterminados" >
                <div>
                  <span>Restablecer</span>
                </div>
              </button>
            </div>          
        </div>   
        </div>       
    </div>
</div>
<main class="inner-page interior ficha">
  <br>  
  <br>
  <br>
  <div class="container  border-separador">
    <div  class="row bread">
      <div class="col-12"><?php echo $bread ?></div>
    </div>   
			<button class="hidden-xs font-changer internal print" id="accesibility-content" tittle="Boton para abrir barra de herramientas accesibles" aria-label="Boton para abrir barra de herramientas accesibles" tabindex="0" style="z-index:100"><img class="img-responsive" class="img-responsive" src="<?php echo base_url()?>assets/icons/accesibilidad.png" alt="Abrir barra de herramientas de accesibilidad"></button>
  </div>
  <div class="container" id="sec_atencion">
    <div class="page-content" >
      <div class="row" >
        <h1  id="tramites-servicios" title="Tramites y servicios"  tabindex="0" aria-label="Tramites y Servicios">Trámites y Servicios</h1>
          <div class="col-12 separador-secciones-dark-2-pu"></div>
          <span class="col-1 separador-secciones-dark-1-pu"></span>
      </div>
      <div class="row" >
        <div class="col-sm-12 col-md-12 col-lg-12 text-justify" tabindex="0"  id="divleyenda" >
              <p  id="leyenda"  aria-label="El Registro Estatal de Trámites y Servicios (RETyS) es 
                          el sistema electrónico que contiene la información de los 
                          trámites y servicios de las dependencias y entidades de la 
                          administración pública estatal. Las dependencias no podrán 
                          aplicar trámites o servicios adicionales a los establecidos 
                          en este registro, ni podrán exigir requisitos adicionales en 
                          forma distinta a como se inscriben. La legalidad y el contenido 
                          de la información que inscriben las dependencias en el registro 
                          son de su estricta responsabilidad.">
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
      <!-- Seccion de Tramites y Servicios -->
      <div class="row align-items-start seleccionar_tipo_tramites">
        <button class="col-11 col-sm-5 col-md-5 col-lg-5  tramiteLinea" id="tramiteLinea" aria-label="Ir a <?php echo $TotalTramitesLinea?> Trámites en Linea"  role="button">
          <div class="col-2 icon" id="linea-icono"><i class="fa fa-desktop " ></i> </div>
          <div class="col-10 titulo"id="linea-titulo"><p >Ir a <?php echo $TotalTramitesLinea?> Trámites y servicios en Línea</p></div>
        </button>
        <button  class="col-11 col-sm-5 col-md-5 col-lg-5  tramitePresencial"  id="tramitePresencial" aria-label="Ir a <?php echo $TotalTramitesPresenciales?> Trámites Presenciales" role="button" >
          <div class="col-2 icon " id="presencial-icon"><i class="fa fa-users"></i></i> </div>
          <div class="col-10 titulo" id="presencial-titulo"><p >Ir a <?php echo $TotalTramitesPresenciales?> Trámites Presenciales</p></div>
        </button>
      </div>
      <div tabindex="0"id="tramites_y_servicios_en_linea">
        <h2>Trámites y servicios en línea</h2>
      </div>
      <div class="row categoria-dependencia-Linea" id="categoria-dependencia-Linea">
        <button class=" col-6 col-sm-6 col-md-6 col-lg-4  categoria-linea" id="categoria-linea" role="button" >
          <div class="col-12 catSection categoria"><p >Categorías</p></div>
        </button>
        <button  class="col-6 col-sm-6 col-md-6 col-lg-4  dependencia-linea" id="dependencia-linea" role="button"  >
          <div class="col-12 catSection dependencia"><p>Dependencias</p></div>
        </button>
        <button  class="col-6 col-sm-6 col-md-6 col-lg-4  dependencia-linea" role="button"  >
          <div class="col-12 catSection dependencia"><p>Buscar trámite</p></div>
        </button>
      </div>

      <div tabindex="0" id="tramites_y_servicios_presenciales">
        <h2>Trámites y servicios presenciales</h2>
      </div>
      <div class="row categoria-dependencia-presencial" id="categoria-dependencia-presencial">
        <button class=" col-6 col-sm-6 col-md-6 col-lg-3  categoria-presencial" onclick="MostrarTramitesPresenciales(3)" id="dependencia-presencial" role="button" >
          <div class="col-12 catSection categoria"><p >Dependencia</p></div>
        </button>
        <button  class="col-6 col-sm-6 col-md-6 col-lg-3  dependencia-presencial" onclick="MostrarTramitesPresenciales(4)" id="categoria-presencial"  role="button"  >
          <div class="col-12 catSection dependencia"><p>Categoría</p></div>
        </button>
        <button  class="col-6 col-sm-6 col-md-6 col-lg-3  dependencia-presencial" onclick="MostrarTramitesPresenciales(5)" id="tipo-usuario-presencial" role="button"  >
          <div class="col-12 catSection dependencia"><p>Tipo de usuario</p></div>
        </button>
        <input type="text" class="" id="busqueda" maxlength="50" name="busqueda_tramite" placeholder="Busqeda de trámite" value="">  
        <button  class="col-1  dependencia-presencial custom-buttom-noticias"  id="boton-busqueda"  role="button"  >
          <div><span class="fa fa-chevron-right"></span></div>
        </button> 
      </div>
      <div class="row align-items-start panel-tramites-categoria-dependencia-linea" id="panel-tramites-categoria-dependencia-linea">
        <div class="panel-tramite-linea col-12" id="panel-tramite-linea">  
          <div class="col-5">
              <div class="col-9">
                  <div class=" panel-group" id="accordion">
                      <div class="card" id="card">
                        <?php foreach($CategoriaLinea as $key =>$value){ ?> 
                        <div class="card-header" id="card-header">
                          <h5 class="panel-title">
                              <a  data-toggle="collapse" title="Categoría <?php print_r($value["descripcion"]);?>" aria-expanded="true" aria-label="Categoría <?php print_r($value["descripcion"]);?>"  data-parent="#accordion" href="#collapse<?php print_r($value["id"]);?>"><p><?php print_r($value["descripcion"]);?></p></a>
                          </h5>
                        </div>                 
                        <div id="collapse<?php print_r($value["id"]);?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <?php foreach($value["tramites"] as $key =>$value2) { ?>
                            <div class="col-12 card-body" role="button">
                                <a class="tramite-liga" href="javascript:CargaTramite(<?php  print_r($value2["id_tramite"])?>,1);">
                                  <div class="col-11">
                                    <span>
                                      <?php  print_r($value2["nombre"])?>
                                    </span>
                                  </div>
                                  <div class="col-1">
                                    <span class="fa fa-chevron-right "></span>
                                  </div>
                                </a>
                            </div>                           
                          <?php } ?>
                        </div>
                        <?php } ?>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-7 contenido-info-tramites" >
            <div class="col-12 info-tramite-categoria"style="border-left:1px solid" id="informacion-tramite-categoria" aria-label="Información de trámite"> 
            </div>
          </div>
        </div>

        <div class="panel-tramite-dependencia col-12" id="panel-tramite-dependencia">  
          <div class="col-5">
              <div class="col-9">
                  <div class="accordion panel-group" >
                      <div class="card">
                        <?php foreach($DependenciaLinea as $key =>$value){ ?> 
                        <div class="card-header" >
                          <h5 class="panel-title">
                              <a data-toggle="collapse" aria-expanded="true" aria-controls="#collapsedep<?php print_r($value["id"]);?>" title="Dependencia <?php print_r($value["descripcion"]);?>"aria-label="Dependencia <?php print_r($value["descripcion"]);?>" href="#collapsedep<?php print_r($value["id"]);?>"><p><?php print_r($value["descripcion"]);?></p></a>
                          </h5>
                        </div>                 
                        <div id="collapsedep<?php print_r($value["id"]);?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <?php foreach($value["tramites"] as $key =>$value2) { ?>
                            <div class="col-12 card-body"  role="button">
                                <a class="tramite-liga"  href="javascript:CargaTramite(<?php  print_r($value2["id"])?>,2);">
                                  <div >
                                    <span  >
                                      <?php  print_r($value2["nombre"])?>
                                    </span>
                                  </div>
                                  <div>
                                    <span class="fa fa-chevron-right"></span>
                                  </div>
                                </a>
                            </div>                           
                          <?php } ?>
                        </div>
                        <?php } ?>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-7 contenido-info-tramites">
            <div class="col-12 info-tramite-dependencia"style="border-left:1px solid" id="informacion-tramite-dependencia" aria-label="Información de trámite"> 
            </div>
          </div>
        </div> 
      </div>

      <div class="row align-items-start panel-tramites-categoria-dependencia-presencial" id="panel-tramites-categoria-dependencia-presencial">
        <div class="panel-tramite-presencial col-12" id="panel-tramite-presencial">  
          <div class="col-5">
              <div class="col-9">
                  <div class=" panel-group" id="accordion">
                      <div class="card" id="card3">                                  
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-7 contenido-info-tramites" >
            <div class="col-12 info-tramite-presencial" style="border-left:1px solid" id="informacion-tramite-categoria" aria-label="Información de trámite"> 
            </div>
          </div>
        </div> 
      </div> 

      <div class="row align-items-start busquedaRetys" id="buesquedaRety">
        <div class="panel-busquedaRetys col-12" id="panel-busquedaRetys">  
          <div class="col-12">
              <div class="col-12">
                  <div class="panel-group" id="accordion">
                      <div class="table" id="table">  
                      </div>
                  </div>
              </div>
          </div>
        </div> 
      </div>
    </div>
  </div>  
</main> 
<?php echo $footer?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/accesibilidad.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/panel-tramites.js"></script>
<script>

$(document).ready(function (){
            $(".tramite-liga").click(function (){
              console.log("object");
                $('html, body').animate({
                    scrollTop: $(".categoria-dependencia-Linea").offset().top
                }, 1500);
            });
        });
$(window).resize(function() {
  
   var widthBrowser =$(window).height();
   var heightBrowser =$(window).width();
   console.log("Tamaño de la pantalla del navegador: width="+widthBrowser +" height="+heightBrowser );
});
</script>
